<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DayOffRequest extends FormRequest
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
            "personal_id" => "required|min:1",
            "start_date" => "date|required",
            "end_date" => "date|required",
            "detail" => "nullable",
        ];
    }

    public function messages()
    {
        return [
            "personal_id.required" => "Personel seçmelisiniz.    ",
            "personal_id.min" => "Personel seçmelisiniz.    ",
            "start_date.required" => "Başlangıç tarihi doldurmalısınız.    ",
            "start_date.date" => "Uygun bir tarih formatı girmelisiniz.    ",
            "end_date.required" => "Bitiş tarihi doldurmalısınız.    ",
            "end_date.date" => "Uygun bir tarih formatı girmelisiniz.   ",
        ];
    }
}
