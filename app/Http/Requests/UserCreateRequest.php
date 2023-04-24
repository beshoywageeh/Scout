<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
    public function rules()
    {
        return [
            'first_name' => 'required',
            'second_name' => 'required',
        ];
    }

    public function messages()
    {
        return[
            'first_name.required' => 'الاسم الاول مطلوب',
            'second_name.required' => 'الاسم الثاني مطلوب',
        ];
    }
}
