<?php

namespace App\Http\Requests;

use App\Http\Models\AdminUser;

class LoginByPhonePostRequest extends Request
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
        $tableName = (new AdminUser())->getTable();
        if($this->isMethod('post')){
            return [
                    'phone_num' => 'required|exists:'.$tableName.',phone_num|regex:/^1[34578][0-9]{9}$/',
                    'identity_num' => 'required|exists:'.$tableName.',identity_num',
                ];
        }else{
            return [];
        }
    }

    public function messages()
    {
        return [
            'phone_num.required' => '*手机号码不能为空',
            'phone_num.regex' => '*手机号码格式错误',
            'phone_num.exists' => '*手机号码不存在',
            'identity_num.required' => '*证件号码不能为空',
            'identity_num.exists' => '*证件号码不存在',
        ];
    }
}
