<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:categories,name,' . $this->category->id,
            'parent_id' => 'nullable|integer|exists:categories,id',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $this->category->id,
        ];
    }
}
