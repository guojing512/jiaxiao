@extends('manage.common.layout')
@section('content')

<style type="text/css">
    .vr_szxx td a{color:#1D8BD8;}
</style>

<div class="vr_szxx">
    <a href="{{url('menu/add')}}" class="public_btn">添加新菜单</a>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
     <form action="" method="post">
        <tr>
            <th width="10%" align="center" valign="middle">排序</th>
            <th width="12%" height="68" align="center" valign="middle">菜单名称</th>
            <th width="12%" height="68" align="center" valign="middle">路由</th>
            <th width="12%" height="68" align="center" valign="middle">模块</th>
            <th width="12%" height="68" align="center" valign="middle">控制器</th>
            <th width="12%" height="68" align="center" valign="middle">方法</th>
            <th width="8%" height="68" align="center" valign="middle">状态</th>
            <th width="20%" height="68" align="center" valign="middle">管理操作</th>
        </tr>

        <tr>
            {!!$list_menu!!}
        </tr>

        <tr>
            <th height="30"><input type="submit" value="排序" class="ty_yellow" /></th>
            <th colspan="7"></th>
        </tr>


    </form>
    </table>
</div>
@stop