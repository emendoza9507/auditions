<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AuditionSlot;
use Illuminate\Http\JsonResponse;

class AuditionSlotController extends Controller
{
    public function available(): JsonResponse
    {
        $slots = AuditionSlot::query()->withCount('registrations')
            ->get()
            ->map(function ($slot) {
                $remaining = $slot->max_participants - $slot->registrations_count;

                return [
                    'id' => $slot->id,
                    'time' => $slot->time->format('h:i A'),
                    'available' => $remaining > 0,
                    'remaining' => $remaining
                ];
            });

        return response()->json($slots);
    }
}
