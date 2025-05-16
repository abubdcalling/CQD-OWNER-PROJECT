<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SubscribeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'company_name' => 'required|string|max:255',
            'package_id' => 'required|exists:packages,id',
            'email' => 'required|string|email|max:255|unique:customers,email',
            'phone' => 'required|phone|string|max:255|unique:customers,phone',
            'zip_code' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.phone' => 'The phone number is invalid.',
        ];
    }
}
