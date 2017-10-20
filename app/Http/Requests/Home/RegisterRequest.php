<?php

namespace App\Http\Requests\Home;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'phone' => ['required', 'unique:user', 'regex:/^1[34578]\d{9}$/'],
            'pwd' => 'required|confirmed',
            'pwd_confirmation' => 'required',
            'paypwd'=>'required',
            'code'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'phone.required'=>'手机号不能为空',
            'phone.unique'=>'该手机号已经被注册',
            'phone.regex'=>'手机号格式不正确',
            'pwd.required'=>'登录密码不能为空',
            'pwd_confirmation.required'=>'确认登录密码不能为空',
            'pwd.confirmed'=>'两次密码输入不一致',
            'paypwd.required'=>'支付密码不能为空',
            'code.required'=>'验证码不能为空'
        ];
    }
}
