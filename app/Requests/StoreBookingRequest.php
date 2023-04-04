<?php

namespace App\Http\Requests;

use App\Models\Booking;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBookingRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('booking_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'halls_id' => [
                'integer',
                'exists:halls,id',
                'nullable',
            ],
            'name'    => [
                [
                    'string',
                    'required',
                ],
            ],
            'email'   => [
                [
                    'required',
                ],
            ],
            'status'  => [
                [
                    'required',
                ],
            ],
        ];
    }
}
