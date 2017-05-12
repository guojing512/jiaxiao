<?php

namespace App\Http\Requests;

use App\Helpers\SessionHelper;
use App\Http\Models\AdminUser;
use App\Http\Models\Company;
use Illuminate\Support\Facades\Input;

class EditUserPostRequest extends Request
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
        if($this->isMethod('post')){
            $tableName = (new AdminUser())->getTable();
            $id = Input::get('id');
            return [
                'real_name' => 'required',
                'phone_num' => 'required|regex:/^1[34578][0-9]{9}$/|unique:'.$tableName.',phone_num,'.$id
            ];
        }else{
            return [];
        }
    }

    public function messages()
    {
        return [
            'real_name.required' => '*姓名不能为空',
            'phone_num.required' => '*手机号码不能为空',
            'phone_num.regex' => '*手机号码格式错误',
            'phone_num.unique' => '*手机号码已经存在'
        ];

    }
}
