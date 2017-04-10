@extends('manage.common.layout')
@section('content')
      <style type="text/css">
        .isshow_input .input{width:22px;height:15px;margin-top:10px;}
      </style>
    <form method="post">
      {{ csrf_field() }}
      <input type="hidden" name="id" value="{{$info['id']}}" />
        <div class="vr_keyg">
            <p><span class="qian">课程</span>
                <i class="require">*</i>
                <select name="course_id" style="width: 252px;height: 35px;margin-left: 7px;">
                    <option value="">请选择课程</option>
                    @foreach($course as $key=>$item)
                        <option value="{{$item['id']}}" @if($info['course_id'] == $item['id']) selected @endif>{{$item['course_name']}}</option>
                    @endforeach
                </select>
                {{$errors->first('course_id')}}
            </p>
            <p><span  class="qian">建议内容</span>
                <i class="require">*</i>
                <textarea name="advice_content" placeholder="请输入建议内容" >{{ old('advice_content')?old('advice_content'):$info['advice_content'] }}</textarea>
                {{$errors->first('advice_content')}}
            </p>
            <p><span class="qian">排序</span>
                <input type="text" name="sort_num" value="{{ old('sort_num')?old('sort_num'):$info['sort_num'] }}" placeholder="请输入排序编号" />
                {{$errors->first('sort_num')}}
            </p>
            <div class="zy_keybutton">
                <input type="submit" class="btn1" value="修改" /><input type="reset" class="btn2" value="取消" />
            </div>
        </div>
    </form>
@stop

