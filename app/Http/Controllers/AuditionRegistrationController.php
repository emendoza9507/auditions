<?php

namespace App\Http\Controllers;

use App\Models\AuditionRegistration;
use App\Models\VerifiedPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AuditionRegistrationController extends Controller
{
    public function show(AuditionRegistration $auditionRegistration)
    {
        return view('audition_registrations.show', compact('auditionRegistration'));
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateAuditionRegistration($request);

        $auditionRegistration = AuditionRegistration::query()->create([...$validatedData, 'payment_status' => 'completed']);

        VerifiedPayment::query()->create([
            'order_id' => $request->input('payment_order_id'),
            'email' => $auditionRegistration->email,
            'verified_at' => now(),
        ]);

        // Send email notification
        Mail::to($auditionRegistration->email)->send(new \App\Mail\NewAuditionRegistration($auditionRegistration));

        return response()->json($auditionRegistration, 201)->header('Location', route('audition_registration.show', [ 'auditionRegistration' => $auditionRegistration->id ]));
    }

    public function verify(Request $request) 
    {
        $validatedData = $this->validateAuditionRegistration($request);

        
        if(VerifiedPayment::query()->where('order_id', $request->input('payment_order_id'))->exists()) {
            return response()->json(['message' => 'Payment already verified.'], 200);
        }

        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return response()->json(['message' => 'Failed to retrieve PayPal access token.'], 500);
        }

        $response = \Illuminate\Support\Facades\Http::withToken($accessToken)
            ->get('https://api-m.paypal.com/v2/checkout/orders/' . $request->input('payment_order_id'));

        if (!$response->ok()) {
            return response()->json(['message' => 'Failed to verify payment, not found'], 404);
        }

        $paypalStatus = $response['status'];
        $paypalEmail = $response['payer']['email_address'] ?? null;

        if($paypalStatus === 'COMPLETED' && strtolower($paypalEmail) === strtolower($validatedData['email'])) {
            $auditionRegistration = AuditionRegistration::query()->create([...$validatedData, 'payment_status' => 'pending']);
        
            VerifiedPayment::query()->create([
                'order_id' => $request->input('payment_order_id'),
                'email' => $validatedData['email'],
                'verified_at' => now(),
            ]);

            Mail::to($auditionRegistration->email)->send(new \App\Mail\NewAuditionRegistration($auditionRegistration));

            return response()->json($auditionRegistration, 201)->header('Location', route('audition_registration.show', [ 'auditionRegistration' => $auditionRegistration->id ]));
        } else {
            return response()->json(['message' => 'Payment verification failed.'], 400);
        }
    }

    private function getAccessToken()
    {
        $clientId = config('app.paypal_client_id');
        $clientSecret = config('app.paypal_client_secret');

        if (empty($clientId) || empty($clientSecret)) {
            throw new \Exception('PayPal client ID or secret is not set in the configuration.');
        }

        $response = \Illuminate\Support\Facades\Http::withBasicAuth($clientId, $clientSecret)
            ->post('https://api-m.paypal.com/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ]);
        
        return $response->ok() ? $response['access_token'] :  null;
    }

    private function validateAuditionRegistration(Request $request)
    {
        return $request->validate([
            'agreed_terms' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'age' => 'required|integer',
            'parent_name' => 'nullable|string',
            'instrument' => 'required|string',
            'audition_slot_id' => 'required|exists:audition_slots,id',
            'audition_id' => 'required|exists:auditions,id',
            'payment_order_id' => 'required'
        ]);
    }
}
