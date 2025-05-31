<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
    public function rules(){
        return [
            'product_name' => 'required|string|max:255',
            'company_id' => 'required|integer|exists:companies,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'img_path' => 'nullable|image',
        ];
    }

    public function attributes(){
        return [
            'product_name' => '商品名',
            'company_id' => 'メーカー',
            'price' => '価格',
            'stock' => '在庫数',
            'img_path' => '商品画像',
        ];
    }

    public function messages(){
        return [
            'product_name.required' => ':attributeは必須項目です。',
            'product_name.max' => ':attributeは:max字以内で入力してください。',
            'company_id.required' => ':attributeは必須項目です。',
            'company_id.exists' => '選択された:attributeが無効です。',
            'price.required' => ':attributeは必須項目です。',
            'stock.required' => ':attributeは必須項目です。',

        ];
    }
}