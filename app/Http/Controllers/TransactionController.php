<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create a new transaction for an event
     */
    public function create(Event $event)
    {
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
    public function store(Request $request, Event $event)
    {
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

        if ($existingTransaction) {
            if ($existingTransaction->payment_status === 'pending') {
                return redirect()->route('transactions.show', $existingTransaction)
                    ->with('info', 'Anda sudah memiliki transaksi pending untuk event ini.');
            } else {
                return redirect()->route('events.show', $event)
                    ->with('info', 'Anda sudah pernah membayar untuk event ini.');
            }
        }

        // Create transaction record
        $transaction = Transaction::create([
            'event_id' => $event->id,
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
            // Delete the transaction if payment creation fails
            $transaction->delete();

            return redirect()->route('events.show', $event)
                ->with('error', 'Gagal membuat transaksi pembayaran. Silakan coba lagi.');
        }
    }

    /**
     * Show transaction details
     */
    public function show(Transaction $transaction)
    {
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
        } elseif ($notification->transaction_status == 'deny' ||
                  $notification->transaction_status == 'cancel' ||
                  $notification->transaction_status == 'expire') {
            $transaction->payment_status = 'failed';
        } elseif ($notification->transaction_status == 'pending') {
            $transaction->payment_status = 'pending';
        }

        $transaction->save();

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
