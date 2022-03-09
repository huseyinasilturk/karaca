<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ObjectiveRequest extends FormRequest
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
            'text1' => 'min:3|nullable',
            'text2' => 'min:3|nullable',
            'text3' => 'min:3|nullable',
            'number1' => 'min:3|nullable',
            'number2' => 'min:3|nullable',
            'number3' => 'min:3|nullable',
            'name' => 'required',
        ];
    }
    public function attributes()
    {
        return [
            'text1' => __("Metin 1"),
            'text2' => __("Metin 2"),
        ];
    }
}
