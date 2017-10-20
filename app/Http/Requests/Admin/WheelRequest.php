<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WheelRequest extends FormRequest
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
            'prize_1'=>'required',
            'angel_1'=>'required|integer|min:1',
            'prize_2'=>'required',
            'angel_2'=>'required|integer|min:1',
            'prize_3'=>'required',
            'angel_3'=>'required|integer|min:1',
            'prize_4'=>'required',
            'angel_4'=>'required|integer|min:1',
            'prize_5'=>'required',
            'angel_5'=>'required|integer|min:1',
            'prize_6'=>'required',
            'angel_6'=>'required|integer|min:1',
        ];
    }

    //规则的描述
    public function messages(){
        return[
            'prize_1.required'=>'第一块奖项不能为空',
            'angel_1.required'=>'第一块奖项比率不能为空',
            'angel_1.integer'=>'第一块奖项比率必须为整数',
            'angel_1.min'=>'第一块奖项比率必须大于0',
            'prize_2.required'=>'第二块奖项不能为空',
            'angel_2.required'=>'第二块奖项比率不能为空',
            'angel_2.integer'=>'第二块奖项比率必须为整数',
            'angel_2.min'=>'第二块奖项比率必须大于0',
            'prize_3.required'=>'第三块奖项不能为空',
            'angel_3.required'=>'第三块奖项比率不能为空',
            'angel_3.integer'=>'第三块奖项比率必须为整数',
            'angel_3.min'=>'第三块奖项比率必须大于0',
            'prize_4.required'=>'第四块奖项不能为空',
            'angel_4.required'=>'第四块奖项比率不能为空',
            'angel_4.integer'=>'第四块奖项比率必须为整数',
            'angel_4.min'=>'第四块奖项比率必须大于0',
            'prize_5.required'=>'第五块奖项不能为空',
            'angel_5.required'=>'第五块奖项比率不能为空',
            'angel_5.integer'=>'第五块奖项比率必须为整数',
            'angel_5.min'=>'第五块奖项比率必须大于0',
            'prize_6.required'=>'第六块奖项不能为空',
            'angel_6.required'=>'第六块奖项比率不能为空',
            'angel_6.integer'=>'第六块奖项比率必须为整数',
            'angel_6.min'=>'第六块奖项比率必须大于0',
        ];
    }
}
