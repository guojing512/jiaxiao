@extends('manage.common.layout')
@section('content')
  <div class="vr_dl_1">
    <div class="vr_mu"><span>关键字</span>
      <input name="keyword" class="vr_wen" value="" placeholder="机构名称" type="text" />
      <input type="button" onclick="search();" value="搜索" class="vr_an_1 ju">
    </div>
    <div class="vr_szxx">
      <a href="{{url('machine/add')}}" class="public_btn">添加设备</a>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th width="9%" height="68" align="center" valign="middle">设备类型</th>
          <th width="9%" height="68" align="center" valign="middle">设备编号</th>
          <th width="9%" height="68" align="center" valign="middle">所属机构</th>
          <th width="9%" height="68" align="center" valign="middle">创建时间</th>
          <th width="9%" height="68" align="center" valign="middle">状态</th>
          <th width="10%" height="68" align="center" valign="middle">操作</th>
        </tr>
        @foreach($data as $key=>$item)
          <tr>
              <td height="68">@if($item['machine_type'] == '1') 汽车 @elseif($item['machine_type'] == '2') 货车 @endif</td>
              <td height="68">{{$item['machine_num']}}</td>
              <td height="68">{{$item['company']['company_name']}}</td>
              <td height="68">{{$item['created_at']}}</td>
              @if($item['is_del'])
                  <td height="50" align="center" valign="middle">正常</td>
                  <td height="50" align="center" valign="middle"><a href="{{url('/machine/edit?id='.$item['id'])}}">修改</a> | <a href="javascript:{};" onclick="updateStatus(this);" itemid="{{$item['id']}}" status="{{$item['is_del']}}" class="lan_1 ry_zs_tj">冻结</a></td>
              @else
                  <td height="50" align="center" valign="middle" class="lan_1">冻结</td>
                  <td height="50" align="center" valign="middle"><a href="{{url('/machine/edit?id='.$item['id'])}}">修改</a> | <a href="javascript:{};" onclick="updateStatus(this);" itemid="{{$item['id']}}" status="{{$item['is_del']}}" class="lv ry_zs_gai">开启</a></td>
              @endif
          </tr>
        @endforeach
      </table>
    </div>
      {!! $pages !!}
    </div>
  </div>
  <script>

    function updateStatus(o){
        layer.confirm('您是确定要修改此用户状态吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            layer.closeAll();
            var status = $(o).attr('status');
            var itemid = $(o).attr('itemid');
            var data_str = '';
            if(status == '1'){
                data_str = 'itemid=' + itemid + '&status=0';
            }else{
                data_str = 'itemid=' + itemid + '&status=1';
            }
            $.ajax({
                type: "POST",
                url:'{{url('machine/editStatus')}}',
                data: data_str,
                dataType:'json',
                success: function(serverJson){
                    if(status == '1') {
                        $(o).html('开启').attr('class','lv ry_zs_gai').attr('status','0');
                        $(o).parent().prev().html("冻结").attr('class','lan_1');
                    }else{
                        $(o).html('冻结').attr('class','lan_1 ry_zs_tj').attr('status','1');
                        $(o).parent().prev().html("正常").attr('class','');
                    }
                }
            });
        });
    }

    function search(){
        var keyword = $("input[name='keyword']").val();
        if(keyword){
            window.location.href = '?keyword='+$("input[name='keyword']").val();
        }else{
            layer.alert('请输入搜索关键词', {
                icon: 2,
                skin: 'layer-ext-moon'
            })
        }
    }
  </script>
@stop

