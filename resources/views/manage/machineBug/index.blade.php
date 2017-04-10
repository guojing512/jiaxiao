@extends('manage.common.layout')
@section('content')
  <div class="vr_dl_1">
    <div class="vr_mu"><span>关键字</span>
      <input name="keyword" class="vr_wen" value="" placeholder="设备编号" type="text" />
      <input type="button" onclick="search();" value="搜索" class="vr_an_1 ju">
    </div>
    <div class="vr_szxx">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th width="9%" height="68" align="center" valign="middle">设备类型</th>
          <th width="9%" height="68" align="center" valign="middle">设备编号</th>
          <th width="9%" height="68" align="center" valign="middle">bug类型</th>
          <th width="9%" height="68" align="center" valign="middle">设备状态</th>
          <th width="9%" height="68" align="center" valign="middle">所属机构</th>
          <th width="9%" height="68" align="center" valign="middle">省</th>
          <th width="9%" height="68" align="center" valign="middle">市</th>
          <th width="9%" height="68" align="center" valign="middle">区/县</th>
          <th width="9%" height="68" align="center" valign="middle">报修时间</th>
        </tr>
        @foreach($data as $key=>$item)
          <tr>
              <td height="68">@if($item['machine']['machine_type'] == '1') 汽车 @elseif($item['machine']['machine_type'] == '2') 货车 @endif</td>
              <td height="68">{{$item['machine_num']}}</td>
              <td height="68">{{$item['bug_type']}}</td>
              <td height="68">{{$item['machine_status']}}</td>
              <td height="68">{{$item['machine']['company']['company_name']}}</td>
              <td height="68">{{$item['machine']['company']['province']['city_name']}}</td>
              <td height="68">{{$item['machine']['company']['city']['city_name']}}</td>
              <td height="68">{{$item['machine']['company']['county']['city_name']}}</td>
              <td height="68">{{$item['created_at']}}</td>
          </tr>
        @endforeach
      </table>
    </div>
      {!! $pages !!}
    </div>
  </div>
@stop

