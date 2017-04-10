<!-- <div class="vr_hei"></div>
<div class="vr_tian">
  <div class="vr_close close"><img src="images/close_03.jpg" /></div>
  <div class="vr_tian_1">添加成功！</div>
  <div class="vr_tian_2">
    <input name="" class="vr_an_1 close" value="确定" type="button" />
    <input name="" value="取消" class="vr_an_1 lan close" type="button" />
  </div>
</div>
<div class="vr_xiu">
  <div class="vr_close close"><img src="images/close_03.jpg" /></div>
  <div class="vr_tian_1">修改成功！</div>
  <div class="vr_tian_2">
    <input name="" class="vr_an_1 close" value="确定" type="button" />
    <input name="" value="取消" class="vr_an_1 lan close" type="button" />
  </div>
</div> -->
<!-- 成功提示框 -->
@if(Session::get('success'))
<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <strong>OK！</strong> {{Session::get('success')}}
</div>
@endif

<!-- 失败提示框 -->
@if(Session::get('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <strong>Sorry！</strong> {{Session::get('error')}}
</div>
@endif  


