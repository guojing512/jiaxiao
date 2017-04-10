 @section('left')

<?php
  $menus = \App\Http\Models\Menu::public_get_menu();
  // echo '<pre>';
  // print_r($menus);exit;
?>


<div class="vr_list">
  <ul class="vr_yiji" id="left_menu" curr_route="{{Request::path()}}">
    @foreach($menus as $menu_one)
    <li class="curr_menu_id" menu_id="{{$menu_one['id']}}">
      <a href="javascript:;" class="inactive">
      <!-- <img src="images/left_03.jpg" /> -->
        {{$menu_one['menu_name']}}
      </a>
      <ul style="display:none;">
        @if(!empty($menu_one['child']))
        @foreach($menu_one['child'] as $menu_two)
          <li><a target="_top" href="{{url($menu_two['route'])}}">{{$menu_two['menu_name']}}</a></li>
        @endforeach
        @endif
      </ul>
    </li>
    @endforeach
  </ul>
</div>
@stop