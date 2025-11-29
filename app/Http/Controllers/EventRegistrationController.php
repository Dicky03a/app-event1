<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EventRegistrationController extends Controller
{
    /**
     * Register a user to an event.
     */
    public function store(Request $request, $slug)
    {
        // Verify user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mendaftar event.');
        }

        // Find the event
        $event = Event::where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Validate that the event is published
        if ($event->status !== 'published') {
            abort(403, 'Event belum dibuka untuk pendaftaran.');
        }

        // Check if user has already registered
        $existingRegistration = EventRegistration::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($existingRegistration) {
            return redirect()->route('events.show', $event->slug)
                ->with('error', 'Anda sudah terdaftar pada event ini.');
        }

        // Handle registration based on event price
        if ($event->price == null || $event->price == 0 || $event->is_free) {
            // Free event registration
            EventRegistration::create([
                'event_id' => $event->id,
                'user_id' => Auth::id(),
                'payment_status' => 'free',
                'registered_at' => now(),
            ]);

            return redirect()->route('events.success', $event->slug)
                ->with('success', 'Anda berhasil terdaftar pada event gratis.');
        } else {
            // Paid event registration - create pending registration
            $registration = EventRegistration::create([
                'event_id' => $event->id,
                'user_id' => Auth::id(),
                'payment_status' => 'pending',
                'payment_reference' => 'REG-' . strtoupper(Str::random(10)),
                'registered_at' => now(),
            ]);

            // Redirect to checkout page which will handle transaction creation
            return redirect()->route('payment.checkout', $registration->id)
                ->with('info', 'Silakan selesaikan pembayaran untuk menyelesaikan pendaftaran Anda.');
        }
    }

    /**
     * Show registration success page.
     */
    public function success($slug)
    {
        $event = Event::where('slug', $slug)
            ->published()
            ->firstOrFail();

        $registration = EventRegistration::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('registrations.success', compact('event', 'registration'));
    }

    /**
     * Show registration status page.
     */
    public function status($slug)
    {
        $event = Event::where('slug', $slug)
            ->published()
            ->firstOrFail();

        $registration = EventRegistration::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$registration) {
            return redirect()->route('events.show', $event->slug)
                ->with('error', 'Anda belum terdaftar pada event ini.');
        }

        return view('registrations.status', compact('event', 'registration'));
    }

    /**
     * Show all registered users for an event (admin only).
     */
    public function index($eventSlug)
    {
        $event = Event::where('slug', $eventSlug)->firstOrFail();

        // Authorize - only admin or event creator can view registrations
        if (!Auth::user()->isAdmin() && Auth::id() !== $event->created_by && !Auth::user()->isSuperAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat pendaftar event ini.');
        }

        $registrations = EventRegistration::where('event_id', $event->id)
            ->with('user')
            ->latest()
            ->get();

        return view('admin.event-registrations.index', compact('event', 'registrations'));
    }

    /**
     * Show checkout page for paid events.
     */
    public function checkout($id)
    {
        $registration = EventRegistration::with('event')->findOrFail($id);

        // Only allow user to checkout their own registration
        if ($registration->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk checkout pendaftaran ini.');
        }

        // If payment is still pending, try to redirect to existing transaction or create new one
        if ($registration->payment_status === 'pending' && $registration->event->price > 0) {
            // Look for existing transaction linked to this registration
            $transaction = \App\Models\Transaction::where('registration_id', $registration->id)
                ->where('payment_status', 'pending')
                ->first();

            if ($transaction && $transaction->payment_url) {
                // If we already have a payment URL, redirect there directly
                return redirect($transaction->payment_url);
            } else {
                // No existing transaction, try to create one by redirecting to the transaction creation flow
                // But first check if there's already a transaction for this event/user that's pending
                $existingTransaction = \App\Models\Transaction::where('event_id', $registration->event_id)
                    ->where('user_id', $registration->user_id)
                    ->where('payment_status', 'pending')
                    ->first();

                if ($existingTransaction) {
                    if ($existingTransaction->payment_url) {
                        return redirect($existingTransaction->payment_url);
                    } else {
                        // Transaction exists but no payment URL, redirect to transaction create
                        return redirect()->route('transactions.create', $registration->event_id);
                    }
                } else {
                    // No existing transaction, redirect to transaction create
                    return redirect()->route('transactions.create', $registration->event_id);
                }
            }
        }



        return view('registrations.checkout', compact('registration'));
    }

    /**
     * Update payment status after successful payment.
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'payment_reference' => 'required|string',
        ]);

        $registration = EventRegistration::findOrFail($id);

        // Only allow event creator or admin to update payment status
        if (!Auth::user()->isAdmin() && Auth::id() !== $registration->event->created_by && !Auth::user()->isSuperAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk memperbarui status pembayaran.');
        }

        $registration->update([
            'payment_status' => 'paid',
            'payment_reference' => $request->payment_reference,
        ]);

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}
