<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable', 'exists:categories,id',
                function (string $attribute, $value, \Closure $fail) {
                    $category = Category::where('id', $value)->first();
                    $children = Category::getAllChildrenByParent($category);
                    // if (count($children) > 0) {
                    //     $fail('Parent category cannot have children.');
                    // }
                    $ids = array_map(fn ($c) => $c->id, $children);
                    if (in_array($value, $ids)) {
                        return $fail('Parent category cannot have children.');
                    }
                },
            ],
            'active' => ['required', 'boolean'],
        ];
    }
}
