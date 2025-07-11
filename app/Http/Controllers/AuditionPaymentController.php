<?php

namespace App\Http\Controllers;

use App\Models\Audition;
use App\Models\AuditionRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuditionPaymentController extends Controller
{
    //
    public function createOrder(Request $request)
    {
        $audition = AuditionRegistration::findOrFail($request->audition_id);

        $response = Http::withBasicAuth(env('PAYPAL_CLIENT_ID'), env('PAYPAL_SECRET'))
            ->post('https://api-m.sandbox.paypal.com/v2/payments/payment', [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'amount' => [
                            'value' => $audition->amount,
                            'currency_code' => 'USD'
                        ]
                    ]
                ],
                'application_context' => [
                    'return_url' => route('paypal.success', ['audition_id' => $audition->id]),
                    'cancel_url' => route('paypal.cancel', ['audition_id' => $audition->id]),
                ]
            ]);


        if($response->failed()) {
            return redirect()->back()->with('error', 'Failed to create PayPal order.');
        }

        $order = $response->json();
        $audition->payment_order_id = $order['id'];
        $audition->save();

        return response()->json([
            'id' => $order['id'],
            'approval_url' => collect($order['links'])->firstWhere('rel', 'approve')['href']
        ]);
    }

    public function success(Request $request)
    {
        $audition = AuditionRegistration::findOrFail($request->audition_id);

        $response = Http::withBasicAuth(env('PAYPAL_CLIENT_ID'), env('PAYPAL_SECRET'))
            ->get("https://api-m.sandbox.paypal.com/v2/payments/orders/{$audition->payment_order_id}");

        if($response->failed()) {
            return redirect()->back()->with('error', 'Failed to capture PayPal payment.');
        }

        $order = $response->json();
        $audition->payment_status = $order['status'];
        $audition->save();

        return redirect()->route('audition_registration.show', $audition->id)->with('success', 'Payment successful. Your audition is confirmed.');
    }

    public function cancel(Request $request)
    {
        $audition = AuditionRegistration::findOrFail($request->audition_id);

        $audition->payment_status = 'failed';
        $audition->save();
    }

}
