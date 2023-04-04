<?php

namespace App\Http\Requests;

use App\Models\Hall;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

use Illuminate\Support\Arr;

class StoreHallRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('ride_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'address' => [
                'string',
                'required',
            ],
            'rooms' => [
                [
                    'required',
                    'integer',
                ],
            ],
            'chairs' => [
                [
                    'required',
                    'integer',
                ],
            ],
            'price' => [
                [
                    'required',
                    'double',
                ],
            ],
            'hours' => [
                [
                    'required',
                    'double',
                ],
            ],
            'tables' => [
                [
                    'required',
                    'integer',
                ],
            ],
            'address' => [
                'string',
                'required',
            ],
            'capacity' => [
                [
                    'required',
                    'integer',
                ],
            ],
            'avilable' => [
                'boolean',
            ],
            'start_party' => [
                'date_format:' . config('project.datetime_format'),
                'required',
            ],
            'end_party' => [
                'date_format:' . config('project.datetime_format'),
                'required',
            ],
        ];
    }
}
