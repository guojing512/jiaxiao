@extends('manage.common.layout')
@section('content')
<style type="text/css">
    .vr_szxx td{height:35px;text-align: center;}
    .vr_szxx th{height:35px;text-align: center;}
    .vr_szxx td a{color:#1D8BD8;}
    .vr_szxx td a{color:#1D8BD8;}
</style>

<div class="vr_szxx">
    <a href="{{url('manage/course/add')}}" class="public_btn">添加课程</a>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <th width="5%" align="center" valign="middle">id</th>
            <th width="10%" align="center" valign="middle">训练课程</th>
            <th width="10%" align="center" valign="middle">所属科目</th>
            <th width="15%" align="center" valign="middle">封面图</th>
            <th width="15%" align="center" valign="middle">详情图</th>
            <th width="5%" align="center" valign="middle">分数</th>
            <th width="15%" align="center" valign="middle">管理操作</th>
        </tr>
        
        @foreach($list as $v)
            <tr>
                <td>{{$v['id']}}</td>
                <td>{{$v['course_name']}}</td>
                <td>{{$v['subject_name']}}</td>
                <td><img src="{{$v['pic_cover']}}" width="100" height="100" /></td>
                <td><img src="{{$v['pic_detail']}}" width="100" height="100" /></td>
                <td>{{$v['score']}}</td>
                <td><a href="{{url('manage/course/edit').'?id='.$v['id']}}">修改</a></td>
            </tr>
        @endforeach
    </table>
</div>

<div class="vr_fen">
{!! $list->render() !!}
</div>
@stop