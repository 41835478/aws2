<?php

namespace App\Http\Requests\Admin;

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
            'oldPwd'=>'required',
            'newPwd'=>'required|confirmed',
        ];
    }

    //规则的描述
    public function messages(){
        return[
            'oldPwd.required'=>'旧密码不能为空',
            'newPwd.required'=>'新密码不能为空',
            'newPwd.confirmed'=>'两次输入密码不一致',
        ];
    }
}
