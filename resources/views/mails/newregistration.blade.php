@component('mail::message')
# Registration Confirmed

Hello {{ $registration->name }},

Thank you for successfully registering for the audition.

**Instrument:** {{ $registration->instrument }}  
**Age:** {{ $registration->age }} 
@if ($registration->age < 18)    
**Parent/Guardian Name:** {{ $registration->parent_name }}
@endif  
**Phone:** {{ $registration->phone }}  
**Audition:** {{ $registration->audition->title ?? '---' }}  
**Selected Time Slot:** {{ $registration->slot->time->format('g:i A') ?? '---' }}

**Payment ID:** {{ $registration->payment_order_id }}  

@component('mail::button', ['url' => route('audition_registration.show', $registration->audition_id)])
View Details
@endcomponent

If you have any questions, feel free to reply to this email.

Thanks,<br>
{{ config('app.name') }}
@endcomponent