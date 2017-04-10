<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CompanyPostRequest extends Request
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
            'company_name' => 'required|max:50',
            'company_type' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'county_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'company_name.required' => '机构名称不能为空',
            'company_name.max' => '机构名称长度不能超过50个字符',
            'company_type.required' => '机构类型不能为空',
            'province_id.required' => '省份不能为空',
            'city_id.required' => '城市不能为空',
            'county_id.required' => '区县不能为空',
        ];
    }
}
