<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class TransactionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('notificationHandler');
    }

    /**
     * Create a new transaction for an event
     */
    public function create($event)
    {
        $event = Event::where('id', $event)->published()->firstOrFail();

        // Check if the event is paid
        if ($event->is_free) {
            return redirect()->route('events.show', $event)
                ->with('error', 'Event ini gratis, tidak perlu pembayaran.');
        }

        return view('transactions.create', compact('event'));
    }

    /**
     * Store a new transaction and initiate payment
     */
    public function store(Request $request, $event)
    {
        $event = Event::where('id', $event)->published()->firstOrFail();

        // Validate the event is not free
        if ($event->is_free) {
            return redirect()->route('events.show', $event)
                ->with('error', 'Event ini gratis, tidak perlu pembayaran.');
        }

        $user = auth()->user();

        // Check if user already has a pending transaction for this event
        $existingTransaction = Transaction::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->whereIn('payment_status', ['pending', 'paid'])
            ->first();

        // Also check in event_registrations table for duplicate registrations
        $existingRegistration = EventRegistration::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->where('payment_status', '!=', 'free')
            ->first();

        if ($existingTransaction || $existingRegistration) {
            if (($existingTransaction && $existingTransaction->payment_status === 'pending') ||
                ($existingRegistration && $existingRegistration->payment_status === 'pending')) {
                // If we have an existing registration, redirect to its checkout
                $reg = $existingRegistration ?: EventRegistration::where('user_id', $user->id)
                    ->where('event_id', $event->id)
                    ->first();
                return redirect()->route('payment.checkout', $reg->id)
                    ->with('info', 'Anda sudah memiliki transaksi pending untuk event ini.');
            } else {
                return redirect()->route('events.show', $event)
                    ->with('info', 'Anda sudah pernah membayar untuk event ini.');
            }
        }

        // Create or find event registration record
        $eventRegistration = EventRegistration::firstOrCreate([
            'event_id' => $event->id,
            'user_id' => $user->id,
        ], [
            'payment_status' => 'pending',
            'payment_reference' => 'REG-' . strtoupper(Str::random(10)),
            'registered_at' => now(),
        ]);

        // Create transaction record
        $transaction = Transaction::create([
            'event_id' => $event->id,
            'registration_id' => $eventRegistration->id,
            'user_id' => $user->id,
            'amount' => $event->price,
            'payment_status' => 'pending',
        ]);

        // Set Midtrans configuration
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Create Snap API parameter
        $payload = [
            'transaction_details' => [
                'order_id' => $transaction->id,
                'gross_amount' => $transaction->amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => $event->id,
                    'price' => $event->price,
                    'quantity' => 1,
                    'name' => $event->title,
                ]
            ]
        ];

        try {
            // Get Snap payment page URL
            $snap = Snap::createTransaction($payload);

            // Update transaction with Snap token and payment URL
            $transaction->snap_token = $snap->token;
            $transaction->payment_url = $snap->redirect_url;
            $transaction->save();

            // Redirect to payment page
            return redirect($transaction->payment_url);
        } catch (\Exception $e) {
            // Delete the transaction and registration if payment creation fails
            $transaction->delete();
            // Only delete the registration if it was newly created and has no payment
            if ($eventRegistration->wasRecentlyCreated) {
                $eventRegistration->delete();
            }

            return redirect()->route('events.show', $event)
                ->with('error', 'Gagal membuat transaksi pembayaran. Silakan coba lagi.');
        }
    }

    /**
     * Show transaction details
     */
    public function show($transaction)
    {
        $transaction = Transaction::with('event')->findOrFail($transaction);
        $this->authorizeTransactionAccess($transaction);

        return view('transactions.show', compact('transaction'));
    }

    /**
     * Handle Midtrans notification callback
     */
    public function notificationHandler(Request $request)
    {
        // Get JSON from Midtrans
        $json = $request->getContent();
        $notification = json_decode($json);

        // Find transaction by order ID
        $transaction = Transaction::find($notification->order_id);

        if (!$transaction) {
            return response('Transaction not found', 404);
        }

        // Update payment status based on notification
        if ($notification->transaction_status == 'capture' || $notification->transaction_status == 'settlement') {
            $transaction->payment_status = 'paid';
        } elseif (
            $notification->transaction_status == 'deny' ||
            $notification->transaction_status == 'cancel' ||
            $notification->transaction_status == 'expire'
        ) {
            $transaction->payment_status = 'failed';
        } elseif ($notification->transaction_status == 'pending') {
            $transaction->payment_status = 'pending';
        }

        $transaction->save();

        // Update related event registration
        if ($transaction->eventRegistration) {
            $paymentStatus = $transaction->payment_status;
            if ($paymentStatus === 'paid') {
                $transaction->eventRegistration->update([
                    'payment_status' => 'paid',
                    'ticket_code' => 'TKT-' . strtoupper(Str::random(10)),
                ]);
            } else {
                $transaction->eventRegistration->update([
                    'payment_status' => $paymentStatus,
                ]);
            }
        }

        return response('Notification received', 200);
    }

    /**
     * Check access authorization for transaction
     */
    private function authorizeTransactionAccess(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to transaction.');
        }
    }
}
