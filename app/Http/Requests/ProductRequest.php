<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name'=>'required|min:3',
            'quantity'=>'required|integer',
            'category_id' => 'required|exists:categories,id',
            'sub_categories_id'=>'nullable|exists:sub_categories,id',
            'unit_price' => 'required|numeric',
            'cost_price_per_unit' => 'required|numeric',
            'is_active' => 'required|boolean',
            'images' => 'image|mimes:jpg,jpeg,png|max:2048',

        ];
    }
}
