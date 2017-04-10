<?php

namespace App\Http\Requests;

use App\Http\Models\AdminUser;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class LoginPostRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected $user;
    public function getUser()
    {
        return $this->user;
    }

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
        $captcha = $this->session()->get('milkcaptcha');
        $tableName = (new AdminUser())->getTable();
        return [
            'username' => 'required|exists:'.$tableName.',user_name',
            'password' => 'required',
//            'captcha' => 'required|in:'.$captcha
        ];
    }

    public function messages()
    {
        return [
            'username.required' => '用户名不能为空',
            'username.exists' => '用户名不存在',
            'password.required' => '密码不能为空',
            'captcha.required' => '验证码不能为空',
            'captcha.in' => '验证码错误',
        ];
    }
}
