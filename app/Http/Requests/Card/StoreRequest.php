<?php

namespace App\Http\Requests\Card;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'title'         => ['required', 'string', 'max:255'],
            'description'   => ['string', 'max:255'],
            'column_uuid'   => ['uuid', 'exists:process_columns,uuid'],
            'process_uuid'  => ['uuid', 'exists:processes,uuid', 'required_with:column_uuid'],
            'customer_uuid' => ['uuid', 'exists:customers,uuid'],
        ];
    }
}
