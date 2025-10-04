<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191', Rule::unique('categories', 'name')],
            'slug' => ['nullable', 'string', 'max:191', Rule::unique('categories', 'slug')],
            'parent_id' => ['nullable', 'exists:categories,id', 'different:id'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
