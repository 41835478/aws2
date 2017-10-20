<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'mobile'=>['required', 'regex:/^1[34578]\d{9}$/'],
            'pwd'=>'required',
            'captcha'=>'required',
        ];
    }

    //规则的描述
    public function messages(){
        return[
            'mobile.required'=>"管理员登录账号不能为空",
            'mobile.regex'=>'管理员账号格式错误',
            'pwd.required'=>'管理员密码不能为空',
            'captcha.required'=>'验证码不能为空',
        ];
    }
}
