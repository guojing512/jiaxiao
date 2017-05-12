@extends('manage.common.layout')
@section('content')
  <div class="vr_dl_1">
    <div class="vr_mu"><span>关键字</span>
      <input name="keyword" class="vr_wen" value="{{$keyword}}" placeholder="登录名/公司名称/品牌名称" type="text" />
      <input type="button" onclick="search();" value="搜索" class="vr_an_1 ju">
    </div>
    <div class="vr_szxx">
        <a href="{{url('manage/register')}}" class="public_btn">添加用户</a>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th width="15%" height="68" align="center" valign="middle">用户名称</th>
          <th width="25%" height="68" align="center" valign="middle">组织机构</th>
          <th width="10%" height="68" align="center" valign="middle">用户组</th>
          <th width="10%" height="68" align="center" valign="middle">证件号码</th>
          <th width="10%" height="68" align="center" valign="middle">手机号码</th>
          <th width="10%" height="68" align="center" valign="middle">状态</th>
          <th width="20%" height="68" align="center" valign="middle">操作</th>
        </tr>
        @foreach($data as $key=>$item)
          <tr>
            <td height="50" align="center" valign="middle">{{$item['user_name']}}</td>
            <td height="50" align="center" valign="middle">{{$item['company']['company_name']}}</td>
            <td height="50" align="center" valign="middle">{{$item['group']['group_name']}}</td>
            <td height="50" align="center" valign="middle">{{$item['identity_num']}}</td>
            <td height="50" align="center" valign="middle">{{$item['phone_num']}}</td>
            @if($item['user_status'])
              <td height="50" align="center" valign="middle">正常</td>
              <td height="50" align="center" valign="middle"><a href="{{url('manage//user/edit?id='.$item['id'])}}">修改</a> | <a href="javascript:{};" onclick="updateStatus(this);" userid="{{$item['id']}}" status="{{$item['user_status']}}" class="lan_1 ry_zs_tj">冻结</a></td>
            @else
              <td height="50" align="center" valign="middle" class="lan_1">冻结</td>
              <td height="50" align="center" valign="middle"><a href="{{url('manage//user/edit?id='.$item['id'])}}">修改</a> | <a href="javascript:{};" onclick="updateStatus(this);" userid="{{$item['id']}}" status="{{$item['user_status']}}" class="lv ry_zs_gai">开启</a></td>
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
            var userid = $(o).attr('userid');
            var data_str = '';
            if(status == '1'){
                data_str = 'user_id=' + userid + '&user_status=0';
            }else{
                data_str = 'user_id=' + userid + '&user_status=1';
            }
            $.ajax({
                type: "POST",
                url:'{{url('manage/user/editStatus')}}',
                data: data_str,
                dataType:'json',
                success: function(serverJson){
                    if(serverJson.flag == 'success'){
                        if(status == '1') {
                            $(o).html('开启').attr('class','lv ry_zs_gai').attr('status','0');
                            $(o).parent().prev().html("冻结").attr('class','lan_1');
                        }else{
                            $(o).html('冻结').attr('class','lan_1 ry_zs_tj').attr('status','1');
                            $(o).parent().prev().html("正常").attr('class','');
                        }
                    }else{
                        alert(serverJson.msg);
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

