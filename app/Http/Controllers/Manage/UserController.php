<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\BaseController;
use App\Http\Models\AdminUser;
use App\Http\Models\Company;
use App\Http\Models\Group;
use App\Http\Requests\UserPostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class UserController extends BaseController
{

	public function index(Request $request)
	{
	    $keyword = Input::get('keyword');
        $users = AdminUser::with(['company','group'])->where('id','>',0);
        if($keyword != ''){
            $users = $users->where('user_name','like','%'.$keyword.'%');
        }
        $users = $users->paginate(10);
        if($keyword != ''){
            $users->appends(['keyword' => $keyword])->render();
        }
        $users_arr = $users->toArray();
        $pages = get_pages_html($users_arr);
        $data = $users_arr['data'];
		return view('manage.user.index',compact(['data','pages','keyword']));
	}

    public function edit()
    {
            $input = Input::all();
            $id = $input['id'];
            $company = Company::where('is_del',1)->get()->toArray();
            $group = Group::where('flag',1)->get()->toArray();
            $user = AdminUser::find($id)->toArray();
            return view('manage.user.edit',compact(['company','group','user']));
	}

    public function doEdit(UserPostRequest $request){
        $input = Input::all();
        $user = AdminUser::find($input['id']);
        $user->user_name = $input['user_name'];
        $user->real_name = $input['real_name'];
        $user->phone_num = $input['phone_num'];
        $user->card_id = $input['card_id'];
        $user->identity_type = $input['identity_type'];
        $user->identity_num = $input['identity_num'];
        $user->company_id = $input['company_id'];
        $user->group_id = $input['group_id'];
        $user->user_status = $input['user_status'];
        $result = $user->update();
        if($result){
            return redirect('manage//index');
        }
    }

    public function editStatus(){
        $return_arr = [];
        $input = Input::all();
        $user = AdminUser::find($input['user_id']);
        $user->user_status = $input['user_status'];
        $result = $user->update();
        if($result){
            return response()->json(returnRes('success','ok'));
        }else{
            return response()->json(returnRes('error','error'));
        }
    }

}
