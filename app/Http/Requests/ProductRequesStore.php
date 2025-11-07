<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequesStore extends FormRequest
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
            'name' => 'required|string',
            'product_type_id'=>'required|integer',
            'product_photo'=>'required',
            'price'=>'required',
            'discount_price'=>'required',
            'content'=>'required|string',
            'category_id'=>'required|integer',
            'sub_category_id'=>'required|integer',
        ];
    }
}
