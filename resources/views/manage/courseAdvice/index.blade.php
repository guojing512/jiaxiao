@extends('manage.common.layout')
@section('content')
  <div class="vr_dl_1">
    <div class="vr_mu"><span>关键字</span>
      <input name="keyword" class="vr_wen" value="" placeholder="机构名称" type="text" />
      <input type="button" onclick="search();" value="搜索" class="vr_an_1 ju">
    </div>
    <div class="vr_szxx">
      <a href="{{url('manage/courseAdvice/add')}}" class="public_btn">添加课程</a>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th width="10%" height="68" align="center" valign="middle">课程</th>
          <th width="60%" height="68" align="center" valign="middle">建议内容</th>
          <th width="10%" height="68" align="center" valign="middle">排序</th>
          <th width="10%" height="68" align="center" valign="middle">创建时间</th>
          <th width="10%" height="68" align="center" valign="middle">操作</th>
        </tr>
        @foreach($data as $key=>$item)
          <tr>
              <td height="68">{{$item['course']['course_name']}}</td>
              <td height="68">{{$item['advice_content']}}</td>
              <td height="68">{{$item['sort_num']}}</td>
              <td height="68">{{$item['created_at']}}</td>
              <td height="50" align="center" valign="middle"><a href="{{url('manage//courseAdvice/edit?id='.$item['id'])}}">修改</a> </td>
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
                url:'{{url('manage/machine/editStatus')}}',
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

