<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GoodsRequest extends FormRequest
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
            'type'=>'required',
            'class_id'=>'required',
            'name'=>'required',
            'title'=>'required',
            'sale'=>'required|integer',
            'storage'=>'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'type.required'=>'分类类型不能为空',
            'class_id.required'=>'下级分类不能为空',
            'name.required'=>'商品名称不能为空',
            'title.required'=>'商品描述不能为空',
            'sale.required'=>'商品销量不能为空',
            'sale.integer'=>'商品销量必须为正整数',
            'storage.required'=>'商品库存不能为空',
            'storage.integer'=>'商品库存必须为正整数',
        ];
    }
}
