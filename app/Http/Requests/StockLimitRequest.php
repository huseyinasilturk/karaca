<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockLimitRequest extends FormRequest
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
            "company_id" => "required",
            "limit" => "required",
        ];
    }

    public function messages()
    {
        return [
            "product_id.required" => "Ürün seçmek zorundasınız",
            "company_id.required" => "Firma seçmek zorundasınız",
            "limit.required" => "Limit belirtmek zorundasınız",
        ];
    }
}
