<?php

namespace App\Http\Requests\Home;

use Illuminate\Foundation\Http\FormRequest;

class EditPwdRequest extends FormRequest
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
            'phone'=>['required', 'regex:/^1[34578]\d{9}$/'],
            'newpwd'=>'required|confirmed',
            'newpwd_confirmation'=>'required',
            'code'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'phone.required'=>'手机号不能为空',
            'phone.regex'=>'手机号格式有误',
            'newpwd.required'=>'新密码不能为空',
            'newpwd_confirmation.required'=>'确认密码不能为空',
            'newpwd.confirmed'=>'两次输入密码不一致',
            'code.required'=>'验证码不能为空',
        ];
    }
}
