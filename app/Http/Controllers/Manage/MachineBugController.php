<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\BaseController;
use App\Http\Models\Company;
use App\Http\Models\MachineBug;
use Illuminate\Support\Facades\Input;

class MachineBugController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = Input::get('keyword');
        $machineBug = MachineBug::with(['machine.company.province','machine.company.city','machine.company.county'])->where('id','>',0);
        if($keyword != ''){
            $machineBug = $machineBug->where('machine_num','like','%'.$keyword.'%');
        }
        $machineBug = $machineBug->paginate(10);
        //传给分页
        if($keyword != ''){
            $machineBug->appends(['keyword' => $keyword])->render();
        }
        $machineBug_arr = $machineBug->toArray();
        $pages = get_pages_html($machineBug_arr);
        $data = $machineBug_arr['data'];
        return view('manage.machineBug.index',compact(['data','pages','keyword']));
    }
}
