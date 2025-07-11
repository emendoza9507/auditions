<?php

namespace App\Http\Controllers;

use App\Models\AuditionRegistration;
use Illuminate\Http\Request;

class AuditionRegistrationController extends Controller
{
    public function show(AuditionRegistration $auditionRegistration)
    {
        return view('audition_registrations.show', compact('auditionRegistration'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'agreed_terms' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'age' => 'required|integer',
            'parent_name' => 'nullable|string',
            'instrument' => 'required|string',
            'audition_slot_id' => 'required|exists:audition_slots,id',
            'audition_id' => 'required|exists:auditions,id',
        ]);

        $auditionRegistration = AuditionRegistration::create($validatedData);

        return redirect()->route('audition_registration.show', $auditionRegistration->id)->with('success', 'Registration successful. Please make the payment to confirm your audition.');
    }
}
