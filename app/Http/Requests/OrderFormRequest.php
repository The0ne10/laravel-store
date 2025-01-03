<?php

namespace App\Http\Requests;

use Domain\Order\Rules\PhoneRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class OrderFormRequest extends FormRequest
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
            'customer.first_name' => 'required|string|max:255',
            'customer.last_name' => 'required|string|max:255',
            'customer.email' => 'required|string|email:dns|max:255',
            'customer.phone' => ['required', new PhoneRule()],
            'customer.city' => 'sometimes',
            'customer.address' => 'sometimes',
            'create_account' => 'bool',
            'password' => request()->boolean('create_account')
                ? ['required', 'confirmed', Password::defaults()]
                : 'sometimes',
            'delivery_type_id' => 'required|exists:delivery_types,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ];
    }
}
