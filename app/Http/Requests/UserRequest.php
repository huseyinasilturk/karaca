<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'min:3|required',
            'surname' => 'min:3|required',
            'user_name' => 'min:3|required',
            'email' => 'min:3|required',
        ];
    }

    public function messages()
    {
        return [
            "name.min" => "Ad en az 3 karakterden oluşmalıdır",
            "name.required" => "Ad doldurmak zorundasınız",
            "surname.min" => "Soyad en az 3 karakterden oluşmalıdır",
            "surname.required" => "Soyad doldurmak zorundasınız",
            "user_name.min" => "Kullanıcı adı en az 3 karakterden oluşmalıdır",
            "user_name.required" => "Kullanıcı adı doldurmak zorundasınız",
            "email.min" => "Email en az 3 karakterden oluşmalıdır",
            "email.required" => "Email doldurmak zorundasınız",
        ];
    }

    public function attributes()
    {
        return [
            'name' => __("Adı"),
            'surname' => __("Soyadı"),
            'user_name' => __("Kullanıcı Adı"),
            'email' => __("Mail Adresi"),
        ];
    }
}
