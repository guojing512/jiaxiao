@extends('manage.common.layout')
@section('content')
<style type="text/css">
    .isshow_input .input{width:22px;height:15px;}
</style>
<div class="vr_keyg">
<form method="post" action="{{url('manage/group/edit')}}">
    <p><span class="qian">组名称：</span>
        <input type="text" name="group_name" value="{{old('group_name')?old('group_name'):$info['group_name']}}"/>
        {{$errors->first('group_name')}}</p>
    <p style="height:auto;">
        <span class="qian">组描述：</span>
        <textarea style="height:100px;width:260px;" size="100" maxlength="100" name="group_desc">{{old('group_desc')?old('group_desc'):$info['group_desc']}}</textarea>
        &nbsp;&nbsp;&nbsp;{{$errors->first('group_desc')}}
    </p>
    <p><span class="qian">组状态：</span>
        <span class="isshow_input"><input class="input" name="flag" type="radio" value="1" {{$info['flag']==1?'checked':''}}/>启用</span>
        <span class="isshow_input"><input class="input" name="flag" type="radio" value="0" {{$info['flag']==0?'checked':''}}/>禁用</span>
        <br/>
    </p>
    <div class="keybutton">
        <input type="hidden" name="id" value="{{$info['id']}}" />
        <input type="submit" class="an_1 lan" value="确定" />
    </div>
    {{csrf_field()}}
</form>
</div>
@stop