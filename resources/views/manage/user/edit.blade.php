@extends('manage.common.layout')
@section('content')
      <style type="text/css">
        .isshow_input .input{width:22px;height:15px;margin-top:10px;}
      </style>
    <form method="post">
      {{ csrf_field() }}
      <input type="hidden" name="id" value="{{ $user['id'] }}"/>
      <div class="vr_keyg">
        <p><span  class="qian">用户名</span>
          <i class="require">*</i>
          <input type="text" name="user_name" value="{{ $user['user_name'] }}" placeholder="请输入用户名" />
          {{$errors->first('user_name')}}
        </p>
        <p><span  class="qian">真实姓名</span>
          <i class="require">*</i>
          <input type="text" name="real_name" value="{{ $user['real_name'] }}" placeholder="请输入真实姓名" />
          {{$errors->first('real_name')}}
        </p>
        <p><span  class="qian">手机号码</span>
          <i class="require">*</i>
          <input type="text" name="phone_num" value="{{ $user['phone_num'] }}" placeholder="请输入手机号" />
          {{$errors->first('phone_num')}}
        </p>
        <p><span  class="qian">卡片id</span>
          <i class="require">*</i>
          <input type="text" name="card_id" value="{{ $user['card_id'] }}" placeholder="请输入卡片id" />
          {{$errors->first('card_id')}}
        </p>
        <p><span class="qian">证件类型</span>
          <span class="isshow_input"><input class="input" name="identity_type" type="radio" value="1" @if($user['identity_type'] == "1") checked="checked"@endif/>身份证</span>
          <span class="isshow_input"><input class="input" name="identity_type" type="radio" value="2" @if($user['identity_type'] == "2") checked="checked"@endif/>军官证</span>
          <span class="isshow_input"><input class="input" name="identity_type" type="radio" value="3" @if($user['identity_type'] == "3") checked="checked"@endif/>护照</span>
          <br/>
        </p>
        <p><span  class="qian">证件号码</span>
          <i class="require">*</i>
          <input type="text" name="identity_num" value="{{ $user['identity_num'] }}" placeholder="请输入证件号码" />
          {{$errors->first('identity_num')}}
        </p>
        {{--<p><span  class="qian">上传头像</span>--}}
          {{--<input type="file" name="user_icon"  />--}}
        {{--</p>--}}

        <p><span class="qian">组织机构</span>
          <i class="require">*</i>
          <select name="company_id" style="width: 252px;height: 35px;margin-left: 7px;">
            <option value="">请选择机构</option>
            @foreach($company as $key=>$item)
              <option value="{{$item['id']}}" @if($item['id'] == $user['company_id']) selected @endif>{{$item['company_name']}}</option>
            @endforeach
          </select>
          {{$errors->first('company_id')}}
        </p>

        <p><span class="qian">用户组</span>
          <i class="require">*</i>
          <select name="group_id"  style="width: 252px;height: 35px;margin-left: 7px;">
            <option value="">请选择用户组</option>
            @foreach($group as $key=>$item)
              <option value="{{$item['id']}}" @if($item['id'] == $user['group_id']) selected @endif>{{$item['group_name']}}</option>
            @endforeach
          </select>
          {{$errors->first('group_id')}}
        </p>

        <p><span class="qian">状态</span>
          <span class="isshow_input"><input class="input" name="user_status" type="radio" value="1" @if($user['user_status'] == '1') checked="checked"@endif/>启用</span>
          <span class="isshow_input"><input class="input" name="user_status" type="radio" value="2" @if($user['user_status'] == '0') checked="checked"@endif/>冻结</span>

          <br/>
        </p>


        <div class="zy_keybutton">
          <input type="submit" class="btn1" value="修改账号" /><input type="reset" class="btn2" value="取消" />
        </div>
      </div>
    </form>
@stop

