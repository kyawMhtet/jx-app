<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'item_id'           => 'required|integer|max:225',
            'is_campaign'       => 'required|integer|max:10',
            'customer_id'       => 'required|integer|max:225',
            'name'              => 'required|string|max:225',
            'payment_method'    => 'required|string|max:225',
            'phone'             => 'required|string|max:225',
            'address'           => 'required|string|max:500',
            'quantity'          => 'required|integer|max:100'
        ];
    }
}
