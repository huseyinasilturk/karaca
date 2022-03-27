<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            "name" => "required",
            "customer_type_id" => "required|min:1|numeric"
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Müşteri ismi doldurulmak zorundadır",
            "customer_type_id.required" => "Müşteri tipi doldurulmak zorundadır",
            "customer_type_id.min" => "Müşteri tipi 1'den fazla olmalıdır",
            "customer_type_id.numeric" => "Müşteri tipi rakam olmak zorundadır",
        ];
    }
}
