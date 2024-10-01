<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        if ($this->has('is_active')) {
            $this->merge([

                'is_active' => $this->boolean('is_active') ? 1 : 0
            ]);
        }
        if ($this->has('categoryname')) {
            $category = Category::where('name', $this->categoryname)->first();
            if ($category) {
                $this->merge([
                    'category_id' => $category->id,
                ]);
            }
        }
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:100',
            'author' => 'nullable|string|max:50',
            'published_at' => 'date|nullable|date_format:Y-m-d',
            'is_active' => 'nullable|boolean',
            'category_id' => 'nullable|exists:categories,id',
        ];
    }
}
