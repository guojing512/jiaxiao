<?php

namespace App\Http\Controllers\Api;

use App\Http\Models\Machine;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;

class MachineController extends Controller
{
    /**
     * 获取设备信息根据物理mac地址
     *post['mac']
     * @return \Illuminate\Http\Response
     */
    public function getMachineByMac()
    {
        try{
            $machine = Machine::whereMac(Input::get('mac'))->first();
            if(!$machine){
                throw new \Exception('没有获取到编号为：'.Input::get('mac').'的设备信息');
            }
            Cookie::queue('machine_num',$machine->machine_num,24*60,$path = null, $domain = null, $secure = false, $httpOnly = false);
            Cookie::queue('machine_mac',$machine->mac, 24*60,$path = null, $domain = null, $secure = false, $httpOnly = false);
            Cookie::queue('machine_id',$machine->id, 24*60,$path = null, $domain = null, $secure = false, $httpOnly = false);
            return response()->json(returnRes("success",'ok',$machine));
        }catch (\Exception $exception){
            return response()->json(returnRes("error",$exception->getMessage()));
        }
    }
}
