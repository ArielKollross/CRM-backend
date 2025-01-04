<?php

namespace App\Http\Requests\Process;

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
            'name'           => ['required', 'string', 'max:25'],
            'description'    => ['required', 'string', 'max:255'],
            'columns'        => ['required', 'array'],
            'columns.*.name' => ['string'],
        ];
    }
}