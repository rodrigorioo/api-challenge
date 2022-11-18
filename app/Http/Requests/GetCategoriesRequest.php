<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetCategoriesRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'order' => ['nullable', 'string', Rule::in(['name_asc', 'name_desc'])],
            'per_page' => 'nullable|integer|max:500',
            'page' => 'nullable|integer',
        ];
    }

    public function prepareForValidation() {
        $this->mergeIfMissing([
            'order' => 'name_asc',
            'per_page' => 500,
            'page' => 1,
        ]);
    }
}
