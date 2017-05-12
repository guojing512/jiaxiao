<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Group;


class GroupController extends BaseController
{

	protected $m_menu;

	public function __construct(){

		parent::__construct();

		$this->m_group = new Group();

	}

	public function index(Request $request)
	{

		//$list = DB::table('group')->orderBy('id','asc')->get();

		$list = Group::paginate(10);
		return view('manage.group.index')->with('list',$list);
	}


	//添加
	public function add(Request $request)
	{
		if($request->isMethod('POST')){
			//Validator类验证 Validator是全局的
			$validator = \Validator::make($request->input(),[
				'group_name'=>'required|min:1|max:50',
				'group_desc'=>'required|min:1|max:255',
			],[
				'required'=>':attribute为必填项',

			],[
				'group_name'=>'组名称',
				'group_desc'=>'组描述',
			]);

			if($validator->fails()){
				return redirect()->back()->withErrors($validator)->withInput();//withErrors把错误信息返回去   withInputs()是数据保持
			}

			$data = $request->input();
			$model = new Group();
			$model->group_name = $data['group_name'];
			$model->group_desc = $data['group_desc'];
			$model->flag = isset($data['flag'])?$data['flag']:1;

			$res = $model->save();//返回布尔值

			if($res)
			{
				return redirect('manage/group')->with('success','添加成功');
			}
			else
			{
				return redirect()->back()->with('error','添加失败');
			}

		}else{

			return view('manage.group.add');
		}

	}

	//修改
	public function edit(Request $request)
	{

		$id = $request->input('id');
		if(empty($id)){
			return redirect()->back()->with('error','请选择要修改的内容');
		}

		if($request->isMethod('POST')){

			$validator = \Validator::make($request->input(),[
				'group_name'=>'required|min:1|max:50',
				'group_desc'=>'required|min:1|max:255',
			],[
				'required'=>':attribute为必填项',

			],[
				'group_name'=>'组名称',
				'group_desc'=>'组描述',
			]);

			if($validator->fails()){
				return redirect()->back()->withErrors($validator)->withInput();//withErrors把错误信息返回去   withInputs()是数据保持
			}

			$model = Group::find($id);
			$data = $request->input();
			//dump($data);exit;
			$model->group_name = $data['group_name'];
			$model->group_desc = $data['group_desc'];
			$model->flag = isset($data['flag'])?$data['flag']:1;
			$res = $model->save();//返回布尔值

			if($res)
			{
				return redirect('manage/group')->with('success','更新成功');
			}
			else
			{
				return redirect()->back()->with('error','更新失败');
			}

		}else{

			$info = DB::table('group')->where('id',$id)->select('id','group_name','group_desc','flag')->first();
			return view('manage.group.edit')->with('info',$info);
		}

	
	}

	public function del(Request $request)
	{
		//Session::put('test_a',['id','name']);
		//dump(Session::get('test_a'));
		//return redirect()->back();
	}

	/**
	 * 权限设置
	 */
	public function setRole(Request $request)
	{

		$group_id = $request->input('group_id');

		if(empty($group_id)){
			return redirect()->back();
		}

		// //if($group_id == ADMIN_GROUP_ID && session('user_id') != ADMIN_USER_ID){
		// if(false){
			//return redirect()->with('error','没有权限进行此操作！')->back();
		// }

		if($request->isMethod('POST')){

			$menu_ids = $request->input('menu_ids');//选中的菜单ids

			if(empty($menu_ids)){
				$menu_ids = array();
			}

			//删除现在的,先没有走事物处理
			$res = DB::table('group_role')->where('group_id',$group_id)->delete();

			//批量添加新的权限
			$data = array();
			foreach ($menu_ids as $k=>$v) {
				$data[$k]['group_id'] = $group_id;
				$data[$k]['menu_id'] = $v;
			}

			//dump($data);exit;

			$res = DB::table('group_role')->insert($data);
			if($res >= 0){
				exit('success');
			}else{
				exit('error');
			}



		}else{

			// 获取全部的菜单信息
           	$list_menu = DB::table('menu')
           	->orderBy('id','asc')
           	->select('id','parent_id','menu_name as name')
           	->get();

           	//dump($list_menu);

           	// 获取当前的组的权限信息
           	$curr_menu_ids = DB::table('group_role')
           		->where(array('group_id'=>$group_id))
           		->orderBy('id','asc')
           		->lists('menu_id');

           	foreach ($list_menu as $key => $value) {
           		if(in_array($value['id'], $curr_menu_ids) ){
           			$list_menu[$key]['checked'] = 'true';
           		}
           	}

           	$list_menu = json_encode($list_menu);
           	//dump($list_menu);exit;

           	return view('manage.group.set_role')
           		->with('list_menu',$list_menu)
           		->with('group_id',$group_id)
           		;
		}
	}


}
