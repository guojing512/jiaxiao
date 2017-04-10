<?php

namespace App\Http\Requests;

use App\Http\Models\AdminUser;
use App\Http\Requests\Request;

class UserPostRequest extends Request
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
        $id = $this->get('id');
        return [
            'user_name' => 'required|max:20|alpha_dash|unique:'.$tableName.',user_name,'.$id,
            'real_name' => 'required',
            'phone_num' => 'required',
            'phone_num' => 'regex:/^1[34578][0-9]{9}$/',
            'phone_num' => 'unique:'.$tableName.',phone_num,'.$id,
            'identity_num' => 'required|unique:'.$tableName.',identity_num,'.$id,
            'company_id' => 'required',
            'group_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'user_name.required' => '用户名不能为空',
            'user_name.max' => '用户名长度不能超过20个字符',
            'user_name.alpha_dash' => '用户名必须由字母、数字、中划线或下划线字符构成',
            'user_name.unique' => '用户名已经存在',
            'real_name.required' => '真实姓名不能为空',
            'phone_num.required' => '手机号码不能为空',
            'phone_num.regex' => '手机号码格式错误',
            'phone_num.unique' => '手机号码已经存在',
            'identity_num.required' => '证件号码不能为空',
            'identity_num.unique' => '证件号码已经存在',
            'company_id.required' => '请为用户分配则主职机构',
            'group_id.required' => '请为用户分配用户组',
        ];
    }
}
