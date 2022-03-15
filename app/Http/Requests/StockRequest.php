<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
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
            "product_id" => "required",
            "amount" => "required|min:1|numeric",
            "unit_type" => "required",
            "company_id" => "required",
            "purchase_price" => "required|min:1|numeric",
        ];
    }

    public function messages()
    {
        return [
            "product_id.required" => "Ürün seçilmek zorunda",
            "amount.required" => "Ürün miktarı doldurulmak zorunda",
            "amount.min" => "Ürün miktarı en az 1 olmak zorunda",
            "amount.numeric" => "Ürün miktarı rakam olmak zorunda",
            "unit_type.required" => "Birim tipi seçilmek zorunda",
            "company_id.required" => "Firma seçilmek zorunda",
            "purchase_price.required" => "Ürün alış fiyatı doldurulmak zorunda",
            "purchase_price.min" => "Ürün alış fiyatı en az 1 olmak zorunda",
            "purchase_price.numeric" => "Ürün alış fiyatı rakam olmak zorunda",
        ];
    }
}
