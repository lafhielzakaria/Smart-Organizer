<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchasePointsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pack_points' => 'required|integer|in:100,550,1400,3000,6000,15000',
            'pack_price' => 'required|numeric|min:0.99|max:49.99',
            'pack_label' => 'required|string|in:Starter,Rookie,Pro,Elite,Legend,Ultimate',
        ];
    }

    public function messages(): array
    {
        return [
            'pack_points.required' => 'Please select a points pack',
            'pack_points.in' => 'Invalid points pack selected',
            'pack_price.required' => 'Pack price is required',
            'pack_price.min' => 'Invalid pack price',
            'pack_label.required' => 'Pack label is required',
            'pack_label.in' => 'Invalid pack type',
        ];
    }
}
