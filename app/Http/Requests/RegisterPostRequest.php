<?php

namespace App\Http\Requests;

use App\Helpers\SessionHelper;
use App\Http\Models\AdminUser;
use App\Http\Models\Company;
use Illuminate\Support\Facades\Input;

class RegisterPostRequest extends Request
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
            $register_type = Input::get('register_type');
            $return_arr = [];
            if($register_type == "by_phone"){
                $session_user = SessionHelper::getHomeUser();
                $max_value = Input::get('give_time') - 1;
                $company = new Company();
                $company_count = $company->getByNumAndTime($session_user['company_id'],Input::get('give_time'));
                if($company_count > 0){
                    $max_value = Input::get('give_time') + 1;
                }
                $return_arr = [
                    'real_name' => 'required',
                    'phone_num' => 'required|unique:'.$tableName.',phone_num|regex:/^1[34578][0-9]{9}$/',
                    'identity_num' => 'required|unique:'.$tableName.',identity_num',
                    'give_time' => 'required_if:flag_give_time,1|integer|max:'.$max_value,
                    'is_valid' => 'required'
                ];
            }else{
                $return_arr = [
                    'user_name' => 'required|max:20|alpha_dash|unique:'.$tableName.',user_name',
                    'real_name' => 'required',
                    'phone_num' => 'required|unique:'.$tableName.',phone_num|regex:/^1[34578][0-9]{9}$/',
                    'identity_num' => 'required|unique:'.$tableName.',identity_num',
                    'company_id' => 'required',
                    'group_id' => 'required',
                    'password' => 'required|confirmed'
                ];
            }
            return $return_arr;
        }else{
            return [];
        }
    }

    public function messages()
    {
        $register_type = Input::get('register_type');
        if($register_type == "by_phone"){
            return [
                'real_name.required' => '*姓名不能为空',
                'phone_num.required' => '*手机号码不能为空',
                'phone_num.regex' => '*手机号码格式错误',
                'phone_num.unique' => '*手机号码已经存在',
                'identity_num.required' => '*证件号码不能为空',
                'identity_num.unique' => '*证件号码已经存在',
                'give_time.required_if' => '*赠送时长必填',
                'give_time.integer' => '*赠送时长必须为整数',
                'give_time.max' => '机构时长不足当前的扣除量',
                'is_valid.required' => 'success',
            ];
        }else{
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
                'password.required' => '密码不能为空',
                'password.confirmed' => '密码和确认密码不一致',
            ];
        }

    }
}
