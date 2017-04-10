<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\BaseController;
use App\Http\Models\AdminUser;
use App\Http\Models\Company;
use App\Http\Models\Group;
use App\Http\Requests\LoginPostRequest;
use App\Http\Requests\RegisterPostRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class LoginController extends BaseController
{

	public function index(Request $request)
	{
        return view('manage.login.index');
	}

	public function login(LoginPostRequest $request){
        if($input = Input::all()){
            if(isset($input['username']) && !empty($input['username']) && isset($input['password']) && !empty($input['password'])){
                $user = AdminUser::whereUser_name(Input::get('username'))->firstOrFail();
                if ($user->password != password($input['password'],$user->password_token)) {
                    $validator = Validator::make($request->all(), []);
                    $validator->after(function($validator) {
                        $validator->errors()->add('password', '密码错误');
                    });
                    if ($validator->fails()) {
                        $this->throwValidationException($request, $validator);
                    }
                }else{
                    session(['user'=>$user->getAttributes()]);
                    //session()->put('user',$user->getAttributes());
                    return redirect('/index');
                }
            }

        }else {
            return view('admin.login');
        }
    }

    public function logout(){
        session(['user'=>null]);
        return redirect('/login');
    }

    public function register(){
        $company = Company::where('is_del',1)->get()->toArray();
        $group = Group::where('flag',1)->get()->toArray();
        return view('manage.login.register',compact(['company','group']));
    }

    public function doRegister(RegisterPostRequest $request)
    {

        $input = Input::all();
        $password_token = create_randomstr();
        $user = new AdminUser();
        $user->user_name = $input['user_name'];
        $user->real_name = $input['real_name'];
        $user->phone_num = $input['phone_num'];
        $user->card_id = $input['card_id'];
        $user->identity_type = $input['identity_type'];
        $user->identity_num = $input['identity_num'];
        $user->company_id = $input['company_id'];
        $user->group_id = $input['group_id'];
        $user->password_token = $password_token;
        $user->password = password($input['password'],$password_token);
        $user->user_name = $input['user_name'];
        $result = $user->save();
        if($result){
            return redirect('/index');
        }
    }
}
