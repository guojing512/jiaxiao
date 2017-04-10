  <div class="vr_logo"><a href="{{url('index')}}"><img src="{{@asset('static/images/logo.png')}}" /></a></div>
  <div class="vr_dl" style="display:inline;">
    <h2 style="float:left;width:auto;">
      <a href="javascript:;">
        <img width="58" height="58" src="{{@asset('static/images/top_03.png')}}"/>
      </a>
    </h2>
    <dl style="width: auto;display:inline;float:left; ">
      <dt style="height: 50px; line-height: 50px;width:auto;display:inline;">
        <a href="javascript" style="color:#fff;"><?php echo session("user_name"); ?></a>
      </dt>
    </dl>
    <h3 style="width:100px;float:left;display:inline;margin-left: 15px;margin-top: 5px;">
      <a href="{{url('logout')}}">
        <img src="{{@asset('static/images/logout.jpg')}}"/>
      </a>
    </h3>
  </div>