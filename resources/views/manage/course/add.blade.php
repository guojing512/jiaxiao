@extends('manage.common.layout')
@section('content')

<style type="text/css">
    select{width:22px;height:15px;}
</style>
<div class="vr_keyg">
<form method="post" action="{{url('course/add')}}"  enctype="multipart/form-data">
    <p><span class="qian">课程名称：</span>
        <input type="text" name="course_name" value="{{old('course_name')}}" />
        {{$errors->first('course_name')}}
    </p>
    <p>
        <span class="qian">所属科目：</span>
        <select name="subject_id">
            <option value="0">==请选择==</option>
            @foreach($list_subject as $v)
            <option value="{{$v['id']}}" {{$v['id'] == old('subject_id')?'selected':''}}>{{$v['subject_name']}}</option>
            @endforeach
        </select>
        {{$errors->first('subject_id')}}
    </p>
    <p>
        <span class="qian">分数：</span>
        <input type="text" name="score" value="{{old('score')}}" />
        {{$errors->first('score')}}
    </p>
    <p>
        <span class="qian">封面图：</span>
        <input type="file" name="pic_cover" />
        {{$errors->first('pic_cover')}}
    </p>
    <p>
        <span class="qian">详情图：</span>
        <input type="file" name="pic_detail" />
        {{$errors->first('pic_detail')}}

    </p>


    <p style="height:auto;">
        <span class="qian">内容：</span>
        <textarea id="editor" size="100" name="content" style="width: 800px; height: 400px;margin-left:98px;">{{old('content')}}</textarea>
        &nbsp;&nbsp;&nbsp;{{$errors->first('content')}}
    </p>
    <div class="keybutton">
        <input type="submit" class="an_1 lan" value="添加" />
    </div>

</form>
</div>

<!-- 编辑器控制开始 -->
<script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/plugins/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
    var ue = UE.getEditor('editor',{textarea:'cms_content'});
</script>
<!-- 编辑器控制结束 -->

@stop