<?php

namespace App\Http\Requests\Process;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'columns.*.uuid' => ['uuid', 'exists:process_columns,uuid'],
            'columns.*.name' => ['required', 'string', 'max:255'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'columns' => collect($this->input('columns'))
                ->map(function ($column) {
                    if (isset($column['id'])) {
                        $column['uuid'] = (string) $column['id']; // Cast to string
                    }

                    return $column;
                })
                ->toArray(),
        ]);
    }
}
