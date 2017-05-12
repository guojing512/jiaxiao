<?php

namespace App\Http\Controllers\Home;

use App\Helpers\SessionHelper;
use App\Http\Controllers\BaseHomeController;
use App\Http\Models\AdminUser;
use App\Http\Models\Card;
use App\Http\Models\Company;
use App\Http\Models\CompanyConsume;
use App\Http\Models\MachineBug;
use App\Http\Requests\EditUserPostRequest;
use App\Http\Requests\LoginByPhonePostRequest;
use App\Http\Requests\RegisterPostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AdminController extends BaseHomeController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('home.admin.index');
    }

    /**
     * 机构管理员普通注册新用户
     */
    public function register(RegisterPostRequest $request)
    {
        if($request->isMethod("post")){
            $user = new AdminUser();
            $result = $user->register_qt();
            if($result && $result['status']){
                return redirect('/admin')->with('success','添加成功');
            }else{
                $validator = Validator::make($request->all(), []);
                $validator->after(function($validator) use($result) {
                    $validator->errors()->add("is_valid", $result['message']);
                });
                if ($validator->fails()) {
                    $this->throwValidationException($request, $validator);
                }
            }
        }else{
            return view('home.admin.register');
        }
    }


    /**
     * 机构管理员给用户补卡
     */
    public function fillCard(LoginByPhonePostRequest $request){
        if($request->isMethod("post")){
            $adminUser = new AdminUser();
            $loginUser = $adminUser->loginByPhone();
            if($loginUser['flag'] == "error"){
                $validator = Validator::make($request->all(), []);
                $validator->after(function($validator) use($loginUser) {
                    $validator->errors()->add($loginUser['data']['errorFiled'], $loginUser['msg']);
                });
                if ($validator->fails()) {
                    $this->throwValidationException($request, $validator);
                }
            }else{
                $user = $loginUser['data'];
                $user->machine_num = Cookie::get('machine_num');
                if(Input::get('card_num') == ""){
                    $user = $loginUser['data'];
                    $user->machine_num = Cookie::get('machine_num');
                    return view('home.admin.fillCard',compact(['user']));
                }else{
                    DB::beginTransaction();
                    try{
                        $updateCard = Card::where("user_id",$user->id)
                            ->update(['is_del' => 0,]);
                        if(!$updateCard){
                            throw new \Exception('修改用户卡信息表出现未知错误');
                        }
                        $session_user = SessionHelper::getHomeUser();
                        $saveCard = (new Card(['user_id'=>$user->id,'card_num'=>Input::get('card_num'),'create_by'=>$session_user['id']]))->save();
                        if(!$saveCard){
                            throw new \Exception('添加用户卡信息表出现未知错误');
                        }
                        $updateUser = AdminUser::where("id",$user->id)
                            ->update(['card_num'=>Input::get('card_num')]);
                        if(!$updateUser){
                            throw new \Exception('修改用户信息表出现未知错误');
                        }
                        DB::commit();
                        return response()->json(returnRes('success','ok'));
                    }catch (\Exception $exception){
                        DB::rollBack();
                        return response()->json(returnRes('error',$exception->getMessage()));
                    }

                }

            }
        }else{
            return view('home.admin.fillCard');
        }
    }

    /**
     * 修改状态，即删除操作
     * @return json
     */
    public function delUser(){
        $updateAdminUser = (new AdminUser())->where('id',Input::get('user_id'))
            ->update([
                'user_status' => 0,
            ]);
        if($updateAdminUser){
            return response()->json(returnRes('success','ok'));
        }else{
            return response()->json(returnRes('error','error'));
        }
    }
    /**
     * 机构管理员修改用户信息
     */
    public function editUser($id,EditUserPostRequest $request){
        if($request->isMethod("post")){
            $input = Input::all();
            $saveAdminUser = AdminUser::where('id',$input['id'])->update(['real_name'=>$input['real_name'],'sex'=>$input['sex'],'phone_num'=>$input['phone_num']]);

            DB::beginTransaction();
            try{
                if(!$saveAdminUser){
                    throw new \Exception('未知错误');
                }
                return redirect('admin/statistics/userList');
                DB::commit();
            }catch (\Exception $exception){
                DB::rollBack();
                $validator = Validator::make($request->all(), []);
                $validator->after(function($validator) use($exception) {
                    $validator->errors()->add("error_message",$exception->getMessage());
                });
                if ($validator->fails()) {
                    $this->throwValidationException($request, $validator);
                }
            }
        }else{
            $user = AdminUser::where('id',$id)->first();
            $user->identity_type = 2;
            return view('home.admin.editUser',compact(['user']));
        }
    }

    /**
     * 查询时长
     */
    public function queryLength()
    {
        $session_user = SessionHelper::getHomeUser();
        if(Input::get('data_flag') != ""){
            $companyConsume = CompanyConsume::where('company_id',$session_user['company_id'])
                ->with('adminUser')
                ->paginate(30);
            $companyConsumeList = $companyConsume->toArray();
            foreach ($companyConsumeList['data'] as $key=>$consume){
                $companyConsumeList['data'][$key]['format_give_time'] = getFriendTime($consume['give_time'],'h','c');
                $companyConsumeList['data'][$key]['format_created_at'] = date("Y-m-d H:i",strtotime($consume['created_at']));
                $companyConsumeList['data'][$key]['format_sex'] = $consume['admin_user']['sex']==1?'男':'女';
            }
            return response()->json($companyConsumeList);
        }else{
            $company = Company::where('id',$session_user['company_id'])->first(['available_time']);
            $available_time = getFriendTime($company->available_time,'h','c');
            $card_num = $session_user['card_num'];
            return view('home.admin.queryLength',compact(['user','card_num','available_time']));
        }
    }

    /**
     * 报修
     */
    public function repair(Request $request)
    {
        if($request->isMethod("post")){
            $input = Input::except('_url');
            $input['machine_id'] = Cookie::get('machine_id');
            $input['machine_num'] = Cookie::get('machine_num');
            DB::beginTransaction();
            try{
                $re = MachineBug::create($input);
                if(!$re){
                    throw new \Exception('添加数据失败，请稍后重试');
                }
                DB::commit();
                return response()->json(returnRes('success','ok'));
            }catch (\Exception $exception){
                DB::rollBack();
                return response()->json(returnRes('error',$exception->getMessage()));
            }
        }else{
            return view('home.admin.repair');
        }

    }

    /**
     * 获取卡片号码
     * @return json
     */
    public function getCardNum()
    {
        $cardNumber = getCardNumber();
        return response()->json(returnRes('success','ok',['card_num'=>$cardNumber]));
    }
}
