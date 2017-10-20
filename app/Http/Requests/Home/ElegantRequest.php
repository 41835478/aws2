<?php

namespace App\Http\Requests\Home;

use Illuminate\Foundation\Http\FormRequest;

class ElegantRequest extends FormRequest
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
            'name'=>'required',
            'sex'=>'required',
            'mobile'=>['required','unique:elegant', 'regex:/^1[34578]\d{9}$/'],
            'ID_code'=>['required','unique:elegant'],
            'agent_name'=>'required',
            'address'=>'required',
            'bank_name'=>'required',
            'account_name'=>'required',
            'bank_code'=>['required','unique:elegant'],
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'输入的姓名不能为空',
            'sex.required'=>'输入的性别不能为空',
            'mobile.required'=>'手机号不能为空',
            'mobile.unique'=>'该手机号已经被注册',
            'mobile.regex'=>'输入的手机号格式错误',
            'ID_code.required'=>'输入的身份证号不能为空',
            'ID_code.unique'=>'该身份证号已经存在',
            'agent_name.required'=>'输入的经纪人名称不能为空',
            'address.required'=>'输入的地址不能为空',
            'bank_name.required'=>'输入的所属银行名称不能为空',
            'account_name.required'=>'输入的开户行名称不能为空',
            'bank_code.required'=>'输入的银行卡号不能为空',
            'bank_code.unique'=>'该银行卡号已经存在',
        ];
    }
}
