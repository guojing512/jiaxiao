<?php
/*
 * 菜单表模型
 * @author  zhanghegong
 */

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Menu extends Model
{
    
    protected $table = "menu";
    public $timestamps = false;


    /**
     * 获取左侧菜单
     */
	static public function public_get_menu(){
		$where = array();
    
		// 读取缓存
		// $parent_data = self::menu_cache('admin_meun_group_'.session('group_id'));
		// if(!empty($parent_data)){
		// 	return $parent_data;
		// }

		// 获取当前用户组所拥有权限的 menu_id 

		$s_user = Session::get('user');

		$group_id = $s_user['group_id'];
		$menu_ids = DB::table('group_role')
		->where('group_id',$group_id)
		->lists('menu_id');
		if(empty($menu_ids)){
			return array();
		}

		$menu_ids_str = implode(',', $menu_ids);

		// 获取改用户组所有拥有权限的一级菜单
		$menu_one = DB::table('menu')
			->whereRaw("parent_id = 33 and id in ($menu_ids_str)")
			->orderBy('sort_num','desc')
			->get();
			;
		//dump($menu_one);
		if(empty($menu_one)){
			return array();
		}

		$menu_one_ids = array_column($menu_one,'id');//(PHP 5 >= 5.5.0, PHP 7)
		$menu_one_ids_str = implode(',', $menu_one_ids);

		// 获取改用户组所有拥有权限的二级菜单
		$menu_two = DB::table('menu')
			->whereRaw("parent_id in ($menu_one_ids_str) and is_show = 1")
			->orderBy('sort_num','desc')
			->get();
			;

		if(empty($menu_two)){
			return array();
		}
		// 整合成二维数组

		foreach($menu_one as $key => $one){
			foreach ($menu_two as $k => $two) {
				if($one['id'] == $two['parent_id']){
					$menu_one[$key]['child'][] = $two;
				}
			}
		}

		// 存入缓存
		//self::menu_cache('admin_meun_group_'.session('group_id'), $menu_one);
		// 清除数据
		unset($menu_two);
		// 返回数据
		return $menu_one;
	}


	/**
     * 当前位置-面包屑导航
     * param string $route 当前路由
     */
	public static function public_get_position($route){	

		if(!$route){
			return array();
		}

		$res = Cache::get("menu_position_route_".$route);
		if($res){
			return $res;
		}

		$info = DB::table('menu')
			->where('route',$route)
			->first();

		//查询所有菜单，并做缓存
		// $menu_all = Cache::get('menu_all');
		// if(!$menu_all){
		// 	$menu_all = DB::table('menu')->get();
		// 	self::menu_cache('menu_all',$menu_all,1);
		// }

		$res = self::family_tree($info['id']);
		$res = array_reverse($res);

		//格式化路由
		foreach ($res as $key => &$value) {
			if(!preg_match('/^[a-zA-z]+/',$value['route'])){
				$value =  array("menu_name"=>$value['menu_name'], 'route'=>'javascript:;', 'id'=>$value['id']);
			}else{
				$value = array("menu_name"=>$value['menu_name'], 'route'=>$value['route'], 'id'=>$value['id']);
			}
		}

		// 将最后一个元素的route清空
		if(count($res)>1){
			$end_data = array_pop($res);
			$end_data['route']  = 'javascript:;';
			array_push($res, $end_data);
		}

		//面包屑导航进行缓存
		self::menu_cache("menu_position_route_".$route, $res,1);
		return $res;
	}

    /**
     * 获取下拉菜单
     * @param integer  $current_id  默认选中
     * @param array  $disabled_list  默认 不让选中的ID 
     * @return string 
     */
    public function get_option_tree($current_id = false, $disabled_list = false){
        
        $_tree = new \App\Http\Common\Tree();

        // 获取缓存
        $option = self::menu_cache("menu_option_".$current_id);

        if(empty($option)){
            $result =  self::menu_cache('menu_option_result');

            if(empty($result)){
            	$result = DB::table('menu')->where('is_show',1)->get();
                self::menu_cache('menu_option_result', $result);
            }

            if(!empty($current_id)  &&  empty($disabled_list)){
                
                foreach($result as $key => &$r) {
                    $r['selected'] = $current_id && $r['id'] == $current_id ? 'selected' : '';
                }
                $str  = "<option value='\$id' \$selected>\$spacer \$menu_name</option>";
            

            }elseif( empty($current_id) && !empty($disabled_list) && is_array($disabled_list)  ){

            	foreach($result as $key => &$r) {
                    $r['disabled'] = in_array($r['id'], $disabled_list) ? 'disabled' : '';
                }
                $str  = "<option value='\$id' \$disabled >\$spacer \$menu_name</option>";

            }elseif( !empty($current_id)  &&  !empty($disabled_list) && is_array($disabled_list) ){

            	foreach($result as $key => &$r) {
                    $r['selected'] = $current_id && $r['id'] == $current_id ? 'selected' : '';
                    $r['disabled'] = in_array($r['id'], $disabled_list) ? 'disabled' : '';
                }
                $str  = "<option value='\$id' \$selected  \$disabled >\$spacer \$menu_name</option>";

           }else{

                $str  = "<option value='\$id' >\$spacer \$menu_name</option>";
            }
            //return $result;
            $_tree->init($result);
            $option = $_tree->get_tree(0, $str);

            self::menu_cache("menu_option_".$current_id, $option);
        }
        return $option;
    }


    /**
	 * 设置菜单缓存
	 * @param string $key  下标
	 * @param array|string.. $data  缓存数据
	 * @return boolean
	 */
    public static function menu_cache($key, $data=false,$time = 1){
		// 获取数据
		if($data===false){

			return Cache::get($key);

		// 清除数据
		}else if($data===null){

			Cache::forget($key);

		// 缓存数据
		}else{
			// 缓存 列表
			Cache::put($key, $data, $time);//设置缓存时间
			// 执行缓存
			return Cache::get($key);
		}
	}


	/**
     * 获取指定分类id的所有下级的id的集合
     * param int $id 为分类id  为0时即查询所有栏目
     */
	public function get_child_node($id = 0)
	{
		$list_menu_ids = DB::table('menu')->where('parent_id', $id)->lists('id');
		$tree = array();//声明一个空数组用来储存按条件找到的数组
		foreach ($list_menu_ids as $v) {
			if ($v['parent_id'] == $id) {
				$tree[] = $v;
				$tree = array_merge($tree,tree($list_menu_ids,$v['id']));
			}
		}
		return $tree;
	}

	/*
	 * 迭代查询一个菜单的家谱树
	 * @param  int $id-菜单主键id
	 * @return array 返回的是自己和自己上面菜单的一个数组
	 */
	public static function family_tree($id=0) {
		$arr = DB::table('menu')->get();
		$tree = array();
		while($id>0) {
			foreach($arr as $v) {
				if($v['id'] == $id) {
					$tree[] = $v;
					$id = $v['parent_id'];
					break;
				}
			}
		}

		return $tree;
	}

}