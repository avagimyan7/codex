<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category')?->id;

        $parentRules = ['nullable', 'exists:categories,id', 'different:id'];
        if ($categoryId !== null) {
            $parentRules[] = Rule::notIn([$categoryId]);
        }

        return [
            'name' => ['sometimes', 'required', 'string', 'max:191', Rule::unique('categories', 'name')->ignore($categoryId)],
            'slug' => ['nullable', 'string', 'max:191', Rule::unique('categories', 'slug')->ignore($categoryId)],
            'parent_id' => $parentRules,
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
