<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'currency' => ['required', 'string', 'min:3', 'max:3'],
            'description' => ['nullable', 'string'],
            'properties' => ['nullable', 'json'],
            'category_id' => ['required', 'integer', 'exists:App\Models\Category,id'],
        ];
    }
}
