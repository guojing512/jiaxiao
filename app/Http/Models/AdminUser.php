<?php

namespace App\Http\Models;

use App\Helpers\SessionHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;

class AdminUser extends Model
{
    protected $table = "admin_user";
    protected $fillable  =  [
        'card_num','user_name','password','password_token','real_name','phone_num','sex',
        'identity_type','identity_num','user_icon','company_id','group_id','user_status',
        'last_login_time','last_login_ip','updated_at','created_at'];

    public function company()
    {
        return $this->hasOne('App\Http\Models\Company','id','company_id');
    }

    public function group()
    {
        return $this->hasOne('App\Http\Models\Group','id','group_id');
    }

    public function UserExt()
    {
        return $this->hasOne('App\Http\Models\UserExt','user_id','id');
    }

    /**
     * 用户名密码登陆.
     *$post['user_name','password']
     * @return array
     */
    public function loginByUserName(){
        $user = AdminUser::whereUser_name(Input::get('username'))->firstOrFail();
        if($user->user_status == '0'){
            return returnRes("error",'此用户已被冻结',['errorFiled'=>"user_name"]);
        }else if ($user->password != password(Input::get('password'),$user->password_token)) {
            return returnRes("error",'用户名或密码错误',['errorFiled'=>"password"]);
        }else{
            return returnRes("success",'ok',$user);
        }
    }
    /**
     * 手机号，身份证登陆.
     *$post['phone_num','identity_num']
     * @return array
     */
    public function loginByPhone(){
        try{
            $user = AdminUser::where("phone_num",Input::get('phone_num'))->first();
            if($user->user_status == '0'){
                return returnRes("error",'此用户已被冻结',['errorFiled'=>"phone_num"]);
            }
            if ($user->identity_num != Input::get('identity_num')) {
                return returnRes("error",'证件号与手机号不符，请重新输入',['errorFiled'=>"phone_num"]);
            }
            if ($user->group_id != "3") {
                return returnRes("error",'此用户没有查询权限',['errorFiled'=>"phone_num"]);
            }
            return returnRes("success",'ok',$user);
        }catch (\Exception $e){
            return returnRes("error","查询用户时出现未知错误");
        }



    }
    /**
     * 刷卡登陆.
     *$post['card_num']
     * @return array
     */
    public function loginByCard(){
        $card_num = Input::get('card_num');
        $cookie_machine_num = Cookie::get('machine_num');
        try{
            $machine = Machine::whereMachine_num($cookie_machine_num)->firstOrFail();
        }catch (\Exception $e){
            return returnRes("error","设备不存在");
        }
        try{
            $cardUser = Card::join('admin_user','card.user_id','=','admin_user.id')
                ->where('card.card_num',$card_num)
                ->where('admin_user.company_id',$machine->company_id)
                ->first(['card.user_id','card.card_num','card.is_del','admin_user.user_status']);
            if($cardUser){
                if($cardUser->is_del == '0'){
                    return returnRes("error","此卡已被冻结，请联系管理员。");
                }
                if($cardUser->user_status == '0'){
                    return returnRes("error","此卡用户已被冻结，请联系管理员。");
                }
                $user = AdminUser::where('card_num',$card_num)->where('company_id',$machine->company_id)->first();
                return returnRes("success",'ok',$user);
            }else{
                return returnRes("error","查无此卡信息，请联系管理员。");
            }
        }catch (\Exception $e){
            return returnRes("error","查无此卡信息，请联系管理员。");
        }
    }

    /**
     * 前台用户注册用户注册.
     *$post['real_name','sex','phone_num','identity_type','identity_num','card_num','give_time']
     * @return array
     */
    public function register_qt()
    {
        $input = Input::all();
        $session_user = SessionHelper::getHomeUser();
        $password_token = create_randomstr();
        $user = new self($input);
        $user->user_name = $user->phone_num;//用户名为手机号
        $user->company_id = $session_user['company_id'];//所属机构为注册人所属的机构，即：session['user']['company_id']
        $user->group_id = config('other.GROUP_ID_SCHOOL_USER');//此时注册的用户为普通学员
        $user->password_token = $password_token;//获取password_token
        $user->password = password("111111",$password_token);//默认密码111111
        DB::beginTransaction();
        try{
            //添加用户表信息
            $saveUser = $user->save();
            if (!$saveUser) {
                throw new \Exception("添加用户出现错误",1);
            }

            //添加卡片表信息
            $card = new Card();
            $saveCard = $card->registerAdd($user);
            if (!$saveCard) {
                throw new \Exception("添加用户卡片表信息出现错误",2);
            }

            //添加用户钱包表信息
            $userExt = new UserExt();
            $saveUserExt = $userExt->registerAdd($user->id);
            if (!$saveUserExt) {
                throw new \Exception("添加用户附加信息出现错误",3);
            }
            //添加用户科目二统计表信息
            $dataUserSubject2 = new DataUserSubject2();
            $saveDataUserSubject2 = $dataUserSubject2->registerAdd($user->id,$user->company_id);
            if (!$saveDataUserSubject2) {
                throw new \Exception("添加用户附加信息出现错误",4);
            }

            //添加用户科目三统计表信息
            $dataUserSubject3 = new DataUserSubject3();
            $saveDataUserSubject3 = $dataUserSubject3->registerAdd($user->id,$user->company_id);
            if (!$saveDataUserSubject3) {
                throw new \Exception("添加用户附加信息出现错误",5);
            }

            //驾校分配时常
            if($input['give_time'] != ""){
                //添加用户机构分配时常信息
                $companyConsume = new CompanyConsume();
                $saveCompanyConsume = $companyConsume->registerAdd($user);
                if (!$saveCompanyConsume) {
                    throw new \Exception("添加用户机构分配时常信息出现错误",6);
                }

                //跟新机构分配时常
                $company = new Company();
                $updateCompany = $company->registerUpdateAvailable_time();
                if (!$updateCompany) {
                    throw new \Exception("跟新机构分配时常信息出现错误",7);
                }
            }
            DB::commit();
            return ['status'=>true,'code'=>'8','message'=>'注册成功'];
        }catch (\Exception $e){
            DB::rollback();
            return ['status'=>false,'code'=>$e->getCode(),'message'=>$e->getMessage()];
        }
    }

    /**
     * 用户注册.
     *$post['Card_num']
     * @return array
     */
    public function register()
    {
        $input = Input::all();
        $password_token = create_randomstr();
        $user = new self($input);
        $user->card_num = getCardNumber();
        $user->password_token = $password_token;
        $user->password = password($user->password,$password_token);
        DB::beginTransaction();
        try{
            //添加用户表信息
            $saveUser = $user->save();
            if (!$saveUser) {
                throw new \Exception("添加用户出现错误",1);
            }
            //添加用户钱包表信息
            $userExt = new UserExt();
            $saveUserExt = $userExt->registerAdd($user->id);
            if (!$saveUserExt) {
                throw new \Exception("添加用户附加信息出现错误",2);
            }
            //添加用户统计表信息
            $dataUserSubject2 = new DataUserSubject2();
            $saveDataUserSubject2 = $dataUserSubject2->registerAdd($user->id,$user->company_id);
            if (!$saveDataUserSubject2) {
                throw new \Exception("添加用户附加信息出现错误",3);
            }

            //添加用户统计表信息
            $dataUserSubject3 = new DataUserSubject3();
            $saveDataUserSubject3 = $dataUserSubject3->registerAdd($user->id,$user->company_id);
            if (!$saveDataUserSubject3) {
                throw new \Exception("添加用户附加信息出现错误",3);
            }

            DB::commit();
            return ['status'=>true,'code'=>'8','message'=>'注册成功'];
        }catch (\Exception $e){
            DB::rollback();
            return ['status'=>false,'code'=>$e->getCode(),'message'=>$e->getMessage()];
        }
    }
}
