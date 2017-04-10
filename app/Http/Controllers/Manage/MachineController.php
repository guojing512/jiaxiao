<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\BaseController;
use App\Http\Models\Machine;
use App\Http\Requests\MachinePostRequest;
use Illuminate\Http\Request;
use App\Http\Models\Company;

use Illuminate\Support\Facades\Input;

class MachineController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = Input::get('keyword');
        $machine = Machine::with(['company'])->where('id','>',0);
        if($keyword != ''){
            $machine = $machine->where('machine_num','like','%'.$keyword.'%');
        }
        $machine = $machine->paginate(10);
        //传给分页
        if($keyword != ''){
            $machine->appends(['keyword' => $keyword])->render();
        }
        $machine_arr = $machine->toArray();
        $pages = get_pages_html($machine_arr);
        $data = $machine_arr['data'];
        return view('manage.machine.index',compact(['data','pages','keyword']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $company = Company::where('is_del',1)->get()->toArray();
        return view('manage.machine.add',compact(['company']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\MachinePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MachinePostRequest $request)
    {
        $input = Input::all();
        $machine = new Machine($input);
        $result = $machine->save();
        if($result){
            return redirect('machine')->with('success','更新成功');
        }else{
            return redirect()->with('error','更新失败')->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $id = Input::get('id');
        $info = Machine::find($id)->toArray();
        $company = Company::where('is_del',1)->get()->toArray();
        return view('manage.machine.edit',compact(['company','info']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\MachinePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function doEdit(MachinePostRequest $request)
    {
        $input = Input::all();
        $machine = Machine::find($input['id']);
        $machine->machine_type = $input['machine_type'];
        $machine->machine_num = $input['machine_num'];
        $machine->company_id = $input['company_id'];
        $machine->is_del = $input['is_del'];
        $result = $machine->update();
        if($result){
            return redirect('machine')->with('success','更新成功');
        }else{
            return redirect()->with('error','更新失败')->back();
        }
    }

    /**
     * 修改状态，即删除操作
     * @return json
     */
    public function editStatus(){
        $return_arr = [];
        $input = Input::all();
        $machine = Machine::find($input['itemid']);
        $machine->is_del = $input['status'];
        $result = $machine->update();
        if($result){
            return response()->json(['status'=>true,'msg'=>'ok']);
        }else{
            return response()->json(['status'=>false,'msg'=>'error']);
        }
    }
}
