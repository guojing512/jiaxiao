@extends('manage.common.layout')
@section('content')

<style type="text/css">
    .isshow_input .input{width:22px;height:15px;}
</style>
<div class="vr_keyg">
<form method="post" action="{{url('menu/add')}}">
    <p><span class="qian">父级菜单：</span>
        <select name="parent_id" style="width: 252px;height: 35px;margin-left: 7px;">
            <option value="0">顶级菜单</option>
            {!!$menu_tree!!}
        </select>
    </p>
    <p>
        <span class="qian">菜单名称：</span><input type="text" name="menu_name" value="{{old('menu_name')}}" />
        {{$errors->first('menu_name')}}
    </p>
    <p><span class="qian">路由：</span><input type="text" name="route" value="{{old('route')}}"/>{{$errors->first('route')}}</p>
    <p><span class="qian">模块名称：</span><input type="text"  name="m_name" value="{{old('m_name')}}"/>{{$errors->first('m_name')}}</p>
    <p><span class="qian">控制器名：</span><input type="text"  name="c_name" value="{{old('c_name')}}"/>{{$errors->first('c_name')}}</p>
    <p><span class="qian">方法名称：</span><input type="text" name="a_name" value="{{old('a_name')}}"/>{{$errors->first('a_name')}}</p>

    <p><span class="qian">是否显示：</span>
        <span class="isshow_input"><input class="input" name="is_show" type="radio" value="1" checked="checked"/>显示</span>
        <span class="isshow_input"><input class="input" name="is_show" type="radio" value="0"/>隐藏</span>
        <br/>
    </p>
    <div class="keybutton">
        <input type="submit" class="an_1 lan" value="添加" />
    </div>
    
    {{csrf_field()}}
</form>
</div>
@stop