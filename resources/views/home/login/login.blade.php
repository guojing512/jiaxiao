
      <style type="text/css">
        .isshow_input .input{width:22px;height:15px;margin-top:10px;}
      </style>
    <form method="post">
      {{ csrf_field() }}
      <input type="hidden" name="onlyLogin" value="{{ $onlyLogin }}"/>{{$errors->first('onlyLogin')}}
      <div class="vr_keyg">
        <p><span  class="qian">手机号码</span>
          <i class="require">*</i>
          <input type="text" name="phone_num" value="{{ old('phone_num') }}" placeholder="请输入手机号" />
          {{$errors->first('phone_num')}}
        </p>
        <p><span  class="qian">证件号码</span>
          <i class="require">*</i>
          <input type="text" name="identity_num" value="{{ old('identity_num') }}" placeholder="请输入证件号码" />
          {{$errors->first('identity_num')}}
        </p>
        <div class="zy_keybutton">
          <input type="submit" class="btn1" value="登陆" /><input type="button" class="btn2" value="返回" />
        </div>
      </div>
    </form>