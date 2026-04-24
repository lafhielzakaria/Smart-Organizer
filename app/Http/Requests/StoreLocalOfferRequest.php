<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocalOfferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'startTime' => 'required|date|after:now',
            'endTime' => 'required|date|after:startTime',
            'totalPrice' => 'required|integer|min:1|max:1000000',
            'maxParticipants' => 'required|integer|min:1|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'startTime.required' => 'Start time is required',
            'startTime.after' => 'Start time must be in the future',
            'endTime.required' => 'End time is required',
            'endTime.after' => 'End time must be after start time',
            'totalPrice.required' => 'Total price is required',
            'totalPrice.min' => 'Total price must be at least 1 point',
            'totalPrice.max' => 'Total price cannot exceed 1,000,000 points',
            'maxParticipants.required' => 'Max participants is required',
            'maxParticipants.min' => 'At least 1 participant is required',
            'maxParticipants.max' => 'Max participants cannot exceed 1,000',
        ];
    }
}
