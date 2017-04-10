<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Course;
use App\Http\Common\Upload;


class CourseController extends BaseController
{

	protected $_model;

	public function __construct(){

		parent::__construct();

		$this->_model = new Course();

	}

	public function index(Request $request)
	{

		$list = DB::table('subject_course as c')
			->select('c.id','course_name','pic_cover','pic_detail','score','subject_name')
			->leftJoin('subject as s','c.subject_id','=','s.id')
			->paginate(10);
		return view('manage.course.index')->with('list',$list);
	}


	//添加
	public function add(Request $request)
	{

		if($request->isMethod('POST')){

			$data = $request->input();

			//Validator类验证 Validator是全局的
			$validator = \Validator::make($data,[
				'subject_id'=>'required|integer|not_in:0',
				//'score'=>'required|integer',
				'course_name'=>'required|min:1|max:50',
				'content'=>'required|min:1|max:2000',

			],[
				'required'=>':attribute为必填项',
				'integer'=>':attribute为整数',
				'image'=>':attribute为必传',
				'not_in'=>'请选择:attribute',

			],[
				'subject_id'=>'所属科目',
				'course_name'=>'课程名称',
				//'score'=>'分数',
				'content'=>'训练课程描述',
			]);

			if($validator->fails()){
				return redirect()->back()->withErrors($validator)->withInput();
			} 

			$this->_model->subject_id = $data['subject_id'];
			$this->_model->course_name = $data['course_name'];
			$this->_model->content = $data['content'];
			$this->_model->score = $data['score'];

			$pic_cover = Input::file('pic_cover');
			$pic_detail = Input::file('pic_detail');
			$upload = new Upload();
			$res = $upload->uploadOne($pic_cover);
			if($res['flag'] != 'success'){
				return redirect()->back()->with('error',$res['msg'])->withErrors($validator)->withInput();
			}else{
				$this->_model->pic_cover = $res['data']['file_path'];
			}

			$res = $upload->uploadOne($pic_detail);
			if($res['flag'] != 'success'){
				return redirect()->back()->with('error',$res['msg'])->withErrors($validator)->withInput();
			}else{
				$this->_model->pic_detail = $res['data']['file_path'];
			}

			$res = $this->_model->save();//返回布尔值
			if($res){
				return redirect('course/index')->with('success','添加成功');
			}else{
				return redirect()->back()->with('error','添加失败');
			}

		}else{

			$list_subject = DB::table('subject')->select('id','subject_name')->get();
			return view('manage.course.add')
				->with('list_subject',$list_subject);
		}

	}

	//修改
	public function edit(Request $request)
	{

		$id = $request->input('id');
		if(empty($id)){
			return redirect()->back()->with('error','请选择要修改的课程');
		}

		if($request->isMethod('POST')){

			$data = $request->input();

			//Validator类验证 Validator是全局的
			$validator = \Validator::make($data,[
				'subject_id'=>'required|integer|not_in:0',
				'score'=>'required|integer',
				'course_name'=>'required|min:1|max:50',
				'content'=>'required|min:1|max:2000',

			],[
				'required'=>':attribute为必填项',
				'integer'=>':attribute为整数',
				'image'=>':attribute为必传',
				'not_in'=>'请选择:attribute',

			],[
				'subject_id'=>'所属科目',
				'course_name'=>'课程名称',
				'score'=>'分数',
				'content'=>'训练课程描述',
			]);

			if($validator->fails()){
				return redirect()->back()->withErrors($validator)->withInput();
			} 

			$model = Course::find($id);
			$model->subject_id = $data['subject_id'];
			$model->course_name = $data['course_name'];
			$model->content = $data['content'];
			$model->score = $data['score'];

			$pic_cover = Input::file('pic_cover');
			$pic_detail = Input::file('pic_detail');
			if(!empty($pic_cover)){
				$upload = new Upload();
				$res = $upload->uploadOne($pic_cover);
				if($res['flag'] != 'success'){
					return redirect()->back()->with('error',$res['msg'])->withErrors($validator)->withInput();;
				}else{
					$model->pic_cover = $res['data']['file_path'];
				}
			}

			if(!empty($pic_detail)){
				$res = $upload->uploadOne($pic_detail);
				if($res['flag'] != 'success'){
					return redirect()->back()->with('error',$res['msg'])->withErrors($validator)->withInput();;
				}else{
					$model->pic_detail = $res['data']['file_path'];
				}
			}

			$res = $model->save();//返回布尔值

			if($res){
				return redirect('course/index')->with('success','更新成功');
			}else{
				return redirect()->back()->with('error','更新失败');
			}

		}else{
			$list_subject = DB::table('subject')->select('id','subject_name')->get();
			$info = DB::table('subject_course')->where('id',$id)->first();
			return view('manage.course.edit')
				->with('info',$info)
				->with('list_subject',$list_subject);
		}

	
	}

	public function del(Request $request)
	{
		//Session::put('test_a',['id','name']);
		//dump(Session::get('test_a'));
		//return redirect()->back();
	}

}
