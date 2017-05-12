<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Menu;


class MenuController extends BaseController
{

	protected $m_menu;

	public function __construct(){

		parent::__construct();

		$this->m_menu = new Menu();
		//dump($m_menu);exit;
	}


	public function index(Request $request)
	{


		$list_menu = DB::table('menu')->orderBy('sort_num','desc')->orderBy('id','asc')->get();
		// echo '<pre>';
		// print_r($list_menu);exit;
		$_tree = new \App\Http\Common\Tree();
        $_tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
        $_tree->nbsp = '&nbsp;&nbsp;&nbsp;';

        //
        foreach($list_menu as $r) {
            $r['is_show'] = $r['is_show'] ? '显示' : '隐藏';
            $r['str_manage'] = '<a href="'.url('manage/menu/add'.'?id='.$r['id']).'">添加子菜单</a> | <a href="'.url('manage/menu/edit'.'?id='.$r['id']).'">修改</a> | <a href="javascript:alert(\'暂时不支持删除\')">删除</a> ';

            //<a href="javascript:confirmurl(\''.url('menu/del'.'?id='.$r['id']).'\',\''.$r['menu_name'].'\')">删除</a>
            $array[] = $r;
        }
        $str  = "<tr>
                    <td align='center' valign='middle'><input name='listorders[\$id]' type='text' size='3' style='text-aling:center;' value='\$sort_num' class='chen_table_input_orderBy'></td>
                    <td align='left' valign='middle'>&nbsp;&nbsp;&nbsp;\$spacer\$menu_name</td>
                    <td align='center' valign='middle'>\$route</td>
                    <td align='center' valign='middle'>\$m_name</td>
                    <td align='center' valign='middle'>\$c_name</td>
                    <td align='center' valign='middle'>\$a_name</td>
                    <td align='center' valign='middle'>\$is_show</td>
                    <td align='center' valign='middle'>\$str_manage</td>
                </tr>";
        
        $_tree->init($array);

        $list_menu = $_tree->get_tree(0, $str);

		return view('manage.menu.index')->with('list_menu',$list_menu);

	}


	//添加菜单
	public function add(Request $request)
	{
		if($request->isMethod('POST')){
			//Validator类验证 Validator是全局的
			$validator = \Validator::make($request->input(),[
				'menu_name'=>'required|min:1|max:50',
				'route'=>'required|unique:menu,route',
				'm_name'=>'required|min:1|max:30',
				'c_name'=>'required|min:1|max:30',
				'a_name'=>'required|min:1|max:30',

			],[

				'required'=>':attribute为必填项',
				'unique'=>':attribute已经存在',

			],[
				'menu_name'=>'菜单名称',
				'route'=>'路由',
				'm_name'=>'模块名',
				'c_name'=>'控制器名',
				'a_name'=>'方法名',
			]);

			if($validator->fails()){
				return redirect()->back()->withErrors($validator)->withInput();//withErrors把错误信息返回去   withInputs()是数据保持
			}

			$data = $request->input();
			$menu = new Menu();
			$menu->menu_name = $data['menu_name'];
			$menu->route = $data['route'];
			$menu->m_name = $data['m_name'];
			$menu->c_name = $data['c_name'];
			$menu->a_name = $data['a_name'];
			$menu->parent_id = isset($data['parent_id'])?$data['parent_id']:0;
			$menu->is_show = isset($data['is_show'])?$data['is_show']:1;

			$res = $menu->save();//返回布尔值

			if($res)
			{
				return redirect('manage/menu')->with('success','添加成功');
			}
			else
			{
				return redirect()->back()->with('error','添加失败');
			}

		}else{

			$menu_tree = $this->m_menu->get_option_tree();
			$menu = new menu();
			return view('manage.menu.add',[
				'menu'=>$menu
			])->with('menu_tree',$menu_tree);
		}

	}

	//修改菜单
	public function edit(Request $request)
	{

		$id = $request->input('id');
		if(empty($id)){
			return redirect()->back()->with('error','请选择要修改的菜单');
		}

		if($request->isMethod('POST')){


			//dump($request->input());exit;

			//查找当前父级菜单的家谱树（返回值包含自己）
			$pid = $request->input('parent_id');
			$family_menu = Menu::family_tree($pid);
			$family_menu_ids = return_array_column($family_menu,'id');
			
			$p_ids = implode(',', $family_menu_ids);
			// dump($family_menu);
			// dump($family_menu_ids);
			// dump($p_ids);
			// dump($request->input('parent_id'));
			// exit;

			$validator = \Validator::make($request->input(),[
				'id'=>"required|integer|not_in:$p_ids",//当前id不在当前父级的家谱树种，如果在说明当前父级就是自己或自己子级
				'menu_name'=>'required|min:1|max:50',
				'route'=>"required|unique:menu,route,$id,id",
				// 'route'=>"required|unique:menu",
				'm_name'=>'required|min:1|max:30',
				'c_name'=>'required|min:1|max:30',
				'a_name'=>'required|min:1|max:30',

			],[

				'required'=>':attribute为必填项',
				'unique'=>':attribute已经存在',
				'integer'=>':attribute必须是整数',
				'not_in'=>':attribute不能选择自己和自己子级',

			],[
				'id'=>'父级菜单',
				'menu_name'=>'菜单名称',
				'route'=>'路由',
				'm_name'=>'模块名',
				'c_name'=>'控制器名',
				'a_name'=>'方法名',
			]);

			if($validator->fails()){
				return redirect()->back()->withErrors($validator)->withInput();//withErrors把错误信息返回去   withInputs()是数据保持
			}



			$menu = Menu::find($id);
			$data = $request->input();
			$menu->menu_name = $data['menu_name'];
			$menu->route = $data['route'];
			$menu->m_name = $data['m_name'];
			$menu->c_name = $data['c_name'];
			$menu->a_name = $data['a_name'];
			$menu->parent_id = isset($data['parent_id'])?$data['parent_id']:0;
			$menu->is_show = isset($data['is_show'])?$data['is_show']:1;
			$res = $menu->save();//返回布尔值

			if($res)
			{
				return redirect('manage/menu')->with('success','更新成功');
			}
			else
			{
				return redirect()->back()->with('error','更新失败');
			}

		}else{


			$info_menu = DB::table('menu')->where('id',$id)->first();
			// echo '<pre>';
			// print_r($info_menu);exit;
			$child_data = $this->m_menu->get_child_node($id);

            if(!empty($child_data)){
                $child_data = explode(",", $child_data);
            }else{
                $child_data = array();
            }

            $option = $this->m_menu->get_option_tree($info_menu['parent_id'], $child_data);

			return view('manage.menu.edit')->with('info',$info_menu)->with('option',$option);
		}

		

	}

	public function del(Request $request)
	{

		echo "<script>alert('暂时不支持删除')</script>";
		return redirect()->back();
		//return view('manage.menu.del');

	}

}
