<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|in:restaurant,café,club,bar,lounge',
            'capacity' => 'required|integer|min:1|max:10000',
            'city' => 'required|string|max:100',
            'andreas' => 'required|string|max:500',
            'price' => 'required|integer|min:1',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Local name is required',
            'type.required' => 'Local type is required',
            'type.in' => 'Invalid local type selected',
            'capacity.required' => 'Capacity is required',
            'capacity.min' => 'Capacity must be at least 1',
            'capacity.max' => 'Capacity cannot exceed 10,000',
            'city.required' => 'City is required',
            'andreas.required' => 'Address is required',
            'price.required' => 'Price is required',
            'price.min' => 'Price must be at least 1 point',
            'image.image' => 'File must be an image',
            'image.mimes' => 'Image must be jpeg, png, jpg, or gif',
            'image.max' => 'Image size cannot exceed 2MB',
        ];
    }
}
