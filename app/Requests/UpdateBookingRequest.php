<?php

namespace App\Http\Requests;

use App\Models\boo;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBookingRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('booking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
