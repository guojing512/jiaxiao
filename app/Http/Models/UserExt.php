<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class UserExt extends Model
{
    protected $table = "user_ext";
    protected $fillable  =  ['user_id','remaining_time','used_time','used_recharge_time','used_recharge_money'];

    public function registerAdd($user_id)
    {
        $remaining_time = 0;
        $give_time = Input::get('give_time');
        if($give_time != ""){
            $remaining_time = $give_time * 60 * 60;
        }
        $userWallet =  new self(['user_id'=>$user_id,'remaining_time'=>$remaining_time]);
        return $userWallet->save();
    }

    public static function runLogSendUpdate($run_id,$user_id)
    {
        $DataMachineRun = DataMachineRun::where("run_id", $run_id)->first();
        $this_time = $DataMachineRun->end_time - $DataMachineRun->start_time;
        $updateUserExt = UserExt::where('user_id', $user_id)->update([
            'remaining_time' => DB::raw('remaining_time-' . $this_time),
            'used_time' => DB::raw('used_time+' . $this_time)
        ]);
        return $updateUserExt;
    }

    public function loginUpdate($user_id)
    {
        return UserExt::where('user_id',$user_id)->update(['card_login_num'=>DB::raw('card_login_num+1')]);
    }
}
