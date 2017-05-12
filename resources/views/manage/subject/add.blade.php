@extends('manage.common.layout')
@section('content')

<style type="text/css">
    .isshow_input .input{width:22px;height:15px;}
</style>
<div class="vr_keyg">
<form method="post" action="{{url('manage/subject/add')}}">
    <p><span class="qian">科目名称：</span>
        <input type="text" name="subject_name" value="{{old('subject_name')}}" />
        {{$errors->first('subject_name')}}</p>
    <p style="height:auto;">
        <span class="qian">科目描述：</span>
        <textarea style="height:100px;width:260px;" size="100" maxlength="100" name="subject_desc">{{old('subject_desc')}}</textarea>
        &nbsp;&nbsp;&nbsp;{{$errors->first('subject_desc')}}
    </p>
    <div class="keybutton">
        <input type="submit" class="an_1 lan" value="添加" />
    </div>

</form>
</div>
@stop