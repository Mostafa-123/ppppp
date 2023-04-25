<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\hallResource;
use Illuminate\Http\Request;
use App\Models\Admin;

use App\Http\Traits\GeneralTraits;

class AdminController extends Controller
{
    use GeneralTraits;



    public function confirmHallRequest($hall_id)
    {
        $hallreq = hallResource::findOrFail($hall_id);

        $hallreq->status = 'confirmed';
        $hallreq->save();

        return response()->json([
            'message' => 'Hall confirmed successfully',
            'data' => $hallreq
        ], 200);    }



    public function rejectHallRequest($hall_id)
    {
        $$hallreq = hallResource::findOrFail($hall_id);

        $booking->status = 'cancelled';
        $booking->save();

        return response()->json([
            'message' => 'Booking cancelled successfully',
            'data' => $$hallreq
        ], 200);    }







    }
