<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
        if ($this->has('categoryname')) {
            $category = Category::where('name', $this->categoryname)->first();

            if ($category) {
                $this->merge([

                    'category_id' => $category->id,
                ]);
            }
        }
        if ($this->has('is_active')) {
            $this->merge([
                'is_active' => $this->boolean('is_active') ? 1 : 0,
            ]);
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
            'title' => 'required|string|max:100',
            'author' => 'required|string|max:50',
            'published_at' => 'date|required|date_format:Y-m-d',
            'is_active' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',

        ];
    }
}
