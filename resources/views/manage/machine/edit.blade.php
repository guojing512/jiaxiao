@extends('manage.common.layout')
@section('content')
      <style type="text/css">
        .isshow_input .input{width:22px;height:15px;margin-top:10px;}
      </style>
    <form method="post">
      {{ csrf_field() }}
      <input type="hidden" name="id" value="{{$info['id']}}" />
        <div class="vr_keyg">
            <p><span  class="qian">设备编号</span>
                <i class="require">*</i>
                <input type="text" name="machine_num" value="{{ old('machine_num')?old('machine_num'):$info['machine_num'] }}" placeholder="请输入设备编号" />
                {{$errors->first('machine_num')}}
            </p>
            <p><span class="qian">设备类型</span>
                <i class="require">*</i>
                <select name="machine_type" style="width: 252px;height: 35px;margin-left: 7px;">
                    <option value="">请选择设备类型</option>
                    <option value="1" @if($info['machine_type'] =="1") selected @endif>汽车</option>
                    <option value="2" @if($info['machine_type'] =="2") selected @endif>货车</option>
                </select>
                {{$errors->first('machine_type')}}
            </p>

            <p><span class="qian">所属机构</span>
                <i class="require">*</i>
                <select name="company_id" style="width: 252px;height: 35px;margin-left: 7px;">
                    <option value="">选择所属机构</option>
                    @foreach($company as $key=>$item)
                        <option value="{{$item['id']}}" @if($info['company_id'] ==$item['id']) selected @endif>{{$item['company_name']}}</option>
                    @endforeach
                </select>
                {{$errors->first('company_id')}}
            </p>
            <p><span class="qian">状态</span>
                <span class="isshow_input"><input class="input" name="is_del" type="radio" value="1" @if($info['is_del'] == '1') checked="checked"@endif/>启用</span>
                <span class="isshow_input"><input class="input" name="is_del" type="radio" value="0" @if($info['is_del'] == '0') checked="checked"@endif/>冻结</span>
                <br/>
            </p>
            <div class="zy_keybutton">
                <input type="submit" class="btn1" value="修改" /><input type="reset" class="btn2" value="取消" />
            </div>
        </div>
    </form>
@stop

