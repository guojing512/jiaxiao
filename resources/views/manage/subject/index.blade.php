@extends('manage.common.layout')
@section('content')
<style type="text/css">
    .vr_szxx td{height:35px;text-align: center;}
    .vr_szxx th{height:35px;text-align: center;}
    .vr_szxx td a{color:#1D8BD8;}
    .vr_szxx td a{color:#1D8BD8;}
</style>

<div class="vr_szxx">
    <a href="{{url('subject/add')}}" class="public_btn">添加科目</a>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <th width="5%" align="center" valign="middle">id</th>
            <th width="12%" align="center" valign="middle">科目名</th>
            <th width="22%" align="center" valign="middle">描述</th>
            <th width="20%" align="center" valign="middle">管理操作</th>
        </tr>
        
        @foreach($list as $v)
            <tr>
                <td>{{$v['id']}}</td>
                <td>{{$v['subject_name']}}</td>
                <td>{{$v['subject_desc']}}</td>
                <td><a href="{{url('subject/edit').'?id='.$v['id']}}">修改</a></td>
            </tr>
        @endforeach
    </table>
</div>

<div class="vr_fen">
{!! $list->render() !!}
</div>
@stop