<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Notifications\CinemaTickets;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Stripe;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaymentController extends Controller
{
    
    public function checkout(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $booking = Booking::find($request->booking_id);
        $session = \Stripe\Checkout\Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'product_data' => [
                            'name' => $booking->movie->name,
                        ],
                        'unit_amount' => 100 * $booking->total_price,
                        'currency' => 'USD',
                    ],
                    'quantity' => 1
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('checkout.cancel', [], true),
        ]);

        $booking->booking_status = 'confirmed';
        $booking->save();

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $sessionId = $request->get('session_id');
        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            if (!$session) {
                throw new NotFoundHttpException();
            }
            // $customer = \Stripe\Customer::retrieve($session->customer);

            $booking = Booking::where('session_id', $session->id)->first();
            if (!$booking) {
                throw new NotFoundHttpException();
            }
            if ($booking->booking_status === 'confirmed') {
                $booking->booking_status = 'paid';
                $booking->QRcode = uniqid() . '-' . $booking->id;
                $booking->save();
                // Send email to customer
                $details = [
                    'greeting' => 'Welcome to Cinema Tickets',
                    'firstline' => 'Good Day',
                    'secondtline' => 'This is your Booking Code: ' . $booking->QRcode,
                    'button' => 'Cinema Tickets',
                    'url' => route('index'),
                    'lastline' => 'Thank you',
                ];
                $user = $booking->user;
                Notification::send($user , new CinemaTickets($details));
            }

            return redirect()->route('bookings.thanks');
        } catch (\Exception $e) {
            throw new NotFoundHttpException();
        }
    }

    public function webhook()
    {
        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response('', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response('', 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;

                $booking = Booking::where('session_id', $session->id)->first();
                if ($booking && $booking->booking_status === 'unpaid') {
                    $booking->booking_status = 'paid';
                    $booking->save();
                    // Send email to customer
                    $details = [
                        'greeting' => 'Welcome to Cinema Tickets',
                        'firstline' => 'Good Day',
                        'secondtline' => 'This is your Booking Code: ' . $booking->QRcode,
                        'button' => 'Cinema Tickets',
                        'url' => route('index'),
                        'lastline' => 'Thank you',
                    ];
                    $user = $booking->user;
                    Notification::send($user , new CinemaTickets($details));
                    
                }

            // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        return response('');
    }
}
