<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Subject;


class SubjectController extends BaseController
{

	protected $_model;

	public function __construct(){

		parent::__construct();

		$this->_model = new Subject();

	}

	public function index(Request $request)
	{

		$list = Subject::paginate(10);
		return view('manage.subject.index')->with('list',$list);
	}


	//添加
	public function add(Request $request)
	{
		if($request->isMethod('POST')){
			//Validator类验证 Validator是全局的
			$validator = \Validator::make($request->input(),[
				'subject_name'=>'required|min:1|max:20',
				'subject_desc'=>'required|min:1|max:2000',
			],[
				'required'=>':attribute为必填项',

			],[
				'subject_name'=>'科目名称',
				'subject_desc'=>'科目描述',
			]);

			if($validator->fails()){
				return redirect()->back()->withErrors($validator)->withInput();//withErrors把错误信息返回去   withInputs()是数据保持
			}

			$data = $request->input();
			$model = new subject();
			$model->subject_name = $data['subject_name'];
			$model->subject_desc = $data['subject_desc'];
			$res = $model->save();//返回布尔值

			if($res)
			{
				return redirect('manage/subject/index')->with('success','添加成功');
			}
			else
			{
				return redirect()->back()->with('error','添加失败');
			}

		}else{

			return view('manage.subject.add');
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
				'subject_name'=>'required|min:1|max:20',
				'subject_desc'=>'required|min:1|max:2000',
			],[
				'required'=>':attribute为必填项',

			],[
				'subject_name'=>'科目名称',
				'subject_desc'=>'科目描述',
			]);

			if($validator->fails()){
				return redirect()->back()->withErrors($validator)->withInput();//withErrors把错误信息返回去   withInputs()是数据保持
			}

			$model = Subject::find($id);
			$data = $request->input();
			$model->subject_name = $data['subject_name'];
			$model->subject_desc = $data['subject_desc'];
			$res = $model->save();//返回布尔值

			if($res)
			{
				return redirect('manage/subject/index')->with('success','更新成功');
			}
			else
			{
				return redirect()->back()->with('error','更新失败');
			}

		}else{

			$info = DB::table('subject')->where('id',$id)->select('id','subject_name','subject_desc')->first();
			return view('manage.subject.edit')->with('info',$info);
		}

	
	}

	public function del(Request $request)
	{
		return true;
	}


}
