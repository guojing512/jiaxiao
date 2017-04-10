<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\BaseController;
use App\Http\Models\City;
use App\Http\Models\Company;

use App\Http\Requests\CompanyPostRequest;
use Illuminate\Support\Facades\Input;

class CompanyController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = Input::get('keyword');
        $company = Company::with(['province','city','county'])->where('id','>',0);
        if($keyword != ''){
            $company = $company->where('company_name','like','%'.$keyword.'%');
        }
        $company = $company->paginate(10);
        //传给分页
        if($keyword != ''){
            $company->appends(['keyword' => $keyword])->render();
        }
        $company_arr = $company->toArray();
        $pages = get_pages_html($company_arr);
        $data = $company_arr['data'];
        return view('manage.company.index',compact(['data','pages','keyword']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $province = City::where('flag',1)->where('parent_id',0)->get()->toArray();
        return view('manage.company.add',compact(['province']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CompanyPostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyPostRequest $request)
    {
        $input = Input::all();
        $company = new Company($input);
        $result = $company->save();
        if($result){
            return redirect('company')->with('success','更新成功');
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
        $info = Company::find($id)->toArray();
        $province = City::where('flag',1)->where('parent_id',0)->get()->toArray();
        $city = City::where('flag',1)->where('parent_id',$info['province_id'])->get()->toArray();
        $county = City::where('flag',1)->where('parent_id',$info['city_id'])->get()->toArray();
        return view('manage.company.edit',compact(['province','city','county','info']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CompanyPostRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function doEdit(CompanyPostRequest $request)
    {
        $input = Input::all();
        $company = Company::find($input['id']);
        $company->company_type = $input['company_type'];
        $company->company_name = $input['company_name'];
        $company->province_id = $input['province_id'];
        $company->city_id = $input['city_id'];
        $company->county_id = $input['county_id'];
        $company->address = $input['address'];
        $company->is_del = $input['is_del'];
        $result = $company->update();
        if($result){
            return redirect('company')->with('success','更新成功');
        }else{
            return redirect()->with('error','更新失败')->back();
        }
    }

    /**
     * 获取城市列表
     * @return json
     */
    public function getCityOption()
    {
        $parent_id = Input::get('parent_id');
        $city = City::where('flag',1)->where('parent_id',$parent_id)->get()->toArray();
        if(!empty($city)){
            return response()->json(['status' => true , 'msg' => 'ok','data'=>$city]);
        }else{
            return response()->json(['status' => false, 'msg' => 'error','data'=>$city]);
        }
    }

    /**
     * 修改状态，即删除操作
     * @return json
     */
    public function editStatus(){
        $return_arr = [];
        $input = Input::all();
        $company = Company::find($input['itemid']);
        $company->is_del = $input['status'];
        $result = $company->update();
        if($result){
            return response()->json(['status'=>true,'msg'=>'ok']);
        }else{
            return response()->json(['status'=>false,'msg'=>'error']);
        }
    }
}
