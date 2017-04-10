
<?php
  $route = Request::path();
  $data = \App\Http\Models\Menu::public_get_position($route);
  $position_ids = return_array_column($data,'id');
  $position_ids = implode(',', $position_ids);
?>

<a href="/index">首页</a> >
@if(!empty($data))
  <div class="position" curr_menu_ids="{{$position_ids}}" style="display:none;"></div>
  @foreach($data as $v)
  <a href="{{url($v['route'])}}">{{$v['menu_name']}}</a> >
  @endforeach
@else
  <a href="javascript:;">后台主页</a> 
  <div class="position" curr_menu_ids="0" style="display:none;"></div>
@endif
