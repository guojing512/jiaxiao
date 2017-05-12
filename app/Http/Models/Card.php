<?php

namespace App\Http\Models;

use App\Helpers\SessionHelper;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = "card";
    protected $fillable  =  ['id','user_id','card_num','create_by'];

    //前台注册用户，为用户添加卡信息
    public function registerAdd(AdminUser $user)
    {
        $session_user = SessionHelper::getHomeUser();
        $card =  new self(['user_id'=>$user->id,'card_num'=>$user->card_num,'create_by'=>$session_user['id']]);
        return $card->save();
    }
}
