@extends('manage.common.layout')
@section('content')
<style type="text/css">
    .vr_szxx td{height:35px;text-align: center;}
    .vr_szxx th{height:35px;text-align: center;}
    .vr_szxx td a{color:#1D8BD8;}
    .vr_szxx td a{color:#1D8BD8;}
</style>

<div class="vr_szxx">
    <a href="{{url('manage/group/add')}}" class="public_btn">添加用户组</a>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
     <form action="{{url('manage/group/rank')}}" method="post">
        <tr>
            <th width="10%" align="center" valign="middle">ID</th>
            <th width="12%" align="center" valign="middle">名称</th>
            <th width="22%" align="center" valign="middle">描述</th>
            <th width="12%" align="center" valign="middle">状态</th>
            <th width="20%" align="center" valign="middle">管理操作</th>
        </tr>
        
        @foreach($list as $v)
            <tr>
                <td>{{$v['id']}}</td>
                <td>{{$v['group_name']}}</td>
                <td>{{$v['group_desc']}}</td>
                <td>{{$v['flag']==1?'启用':'禁用'}}</td>
                <td>
                    <?php 
                        //if( ($v['id'] == ADMIN_GROUP_ID && session('user_id') == ADMIN_USER_ID) or $v['id'] != ADMIN_GROUP_ID  ){
                        if(1){    
                            echo '<a href="'. url('manage/group/edit') .'?id='.$v['id'].'">修改</a>';
                            echo "&nbsp;&nbsp;|&nbsp;&nbsp;";
                            echo '<a href="javascript:;" class="set_role" title="设置【'. $v['group_name'] .'】所属用户的权限"';
                            echo 'myhref="'. url('manage/group/setRole') .'?group_id='.$v['id'].'">权限</a>';
                        }else{
                            echo '<span>修改</span>&nbsp;&nbsp;|&nbsp;&nbsp;<span>权限</span>';
                        }
                    ?>
                </td>
            </tr>
        @endforeach
    </form>
    </table>
</div>
<!-- <div class="vr_fen"><a href="#">首页</a> <a href="#" class="a1">上一页</a> <span>1</span> <a href="#">2   </a> <a href="#">3</a> .. <a href="#">152</a> <a href="#" class="a1">下一页</a> <a href="#" class="a1">尾页</a></div> -->

<div class="vr_fen">
{!! $list->render() !!}
</div>


<!-- 权限设置 弹框处理 -->
<script type="text/javascript">
    $(function(){
        //加载扩展模块
        layer.config({
            extend: 'extend/layer.ext.js'
        });

        $(".set_role").on("click",function(){
           var href =  $(this).attr("myhref");
           var title =  $(this).attr("title");
            layer.open({
                type: 2,
                title: title,
                fix: false,
                shadeClose: true,
                area: ['1000px', '500px'],
                content: href,      
                maxmin: true
            });
        });
    });

</script>
<!-- 权限设置结束 -->

@stop