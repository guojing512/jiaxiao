@extends('home.common.layout')
@section('title', '管理员统计-超弦科技')
@section('content')
    
<div id="main">
    <div class="tj_main">
        <div class="tj_table_title">学员基础信息</div>

        <div class="user_list">
            <table class="table_user_list">
                <thead>
                <tr>
                    <!--加起来为1160-->
                    <th width="70">序号</th>
                    <th width="240">编号</th>
                    <th width="80">姓名</th>
                    <th width="50">性别</th>
                    <th width="200">身份证</th>
                    <th width="110">手机号</th>
                    <th width="100">使用时长</th>
                    <th width="100">剩余时长</th>
                    <th width="100">刷卡次数</th>
                    <th width="110"></th>
                </tr>
                </thead>
                <tbody>

                </tbody>

            </table>
        </div>
        <!-- 右侧导航条 -->
        <div class="tj_item">
            <ul>
                <a href="{{url('admin/statistics')}}"><li class="tj_i_li1">总<br/><br/>计</li></a>
                <a href=""><li class="tj_i_li2 bg_blue_tj">基<br/>础<br/>信<br/>息</li></a>
                <a href="{{url('admin/statistics/subject2List')}}"><li class="tj_i_li3">科<br/>目<br/>二</li></a>
                <a href="{{url('admin/statistics/subject3List')}}"><li class="tj_i_li4">科<br/>目<br/>三</li></a>
            </ul>
        </div>
    </div>
    <!-- 信息确认 -->
    <div class="reg_info" style="display:none;">
        <div class="reg_info_verify">
            <div class="reg_head_icon"><img src="{{@asset('home/images/head_icon.png')}}"/></div>
            <div class="reg_text">

            </div>
        </div>

        <div class="reg_info_button">
            <a href="javascript:{hideInfo()};" style="float:right;margin-right:200px;"><img src="{{@asset('home/images/282_fan1.png')}}" src_1="{{@asset('home/images/282_fan1.png')}}" src_2="{{@asset('home/images/282_fan2.png')}}"/></a>

            <!--<a href="javascript:{submit1()};" class="reg_info_submit"><img src="{{@asset('home/images/282_tijiao1.png')}}" src_1="{{@asset('home/images/282_tijiao1.png')}}" src_2="{{@asset('home/images/282_tijiao2.png')}}"/></a>-->
        </div>
        <input type="button" onclick="pay_card()" value="点击模拟刷卡">
    </div>
</div>

<div class="goback" style="right:130px;bottom:60px;"><a href="javascript:history.back(-1);" ><img src="{{@asset('home/images/goback1.png')}}" src_1="{{@asset('home/images/goback1.png')}}" src_2="{{@asset('home/images/goback2.png')}}"/> </div>
<script src="{{@asset('plugins/layer/layer.js')}}"></script>
<script src="{{@asset('plugins/layer/layer-myself.js')}}"></script>
<script type="text/javascript">
    var delete_tr = null;
    var refresh = {};
    refresh.flag = true;
    refresh.page = 1;
    refresh.getData = function(callback){
        $.ajax({
            type: "POST",
            url:"{{url('admin/statistics/userList')}}",
            data: "page="+this.page+"&data_flag=1",
            dataType:'json',
            success: function(jsonData){
                if(typeof(callback) == 'function'){
                    callback(jsonData);
                }
            }
        });
    }
    refresh.loaded_data = function(table){
        if(refresh.flag){
            refresh.flag = false;
            refresh.getData(function(data){
                console.log(data);
                if(data.data){
                    $.each(data.data, function (id,item) {
                        refresh.insertHtml(id,this,item);
                    }.bind(this));
                }

                if(data && data.to < data.total){
                    refresh.flag = true;
                    refresh.page = data.current_page + 1;
                }
            }.bind(table));
        }
    }
    refresh.insertHtml = function(key,html_dom,data){
        var str_html = "<tr style='display:none;'>"+
            "<td width='70'>"+data.id+"</td>"+
            "<td width='240'>"+data.card_num+"</td>"+
            "<td width='80'>"+data.real_name+"</td>"+
            "<td width='50'>"+data.format_sex+"</td>"+
            "<td width='200'>"+data.identity_num+"</td>"+
            "<td width='110'>"+data.phone_num+"</td>"+
            "<td width='100'>"+data.format_used_time+"</td>"+
            "<td width='100'>"+data.format_remaining_time+"</td>"+
            "<td width='100'>"+data.user_ext.card_login_num+"</td>"+
            "<td width='110'><a href='javascript:{};' onclick='deleteUser(this,"+data.id+")' >删除</a>&nbsp;<a href=\"{{url('admin/editUser')}}/"+data.id+"\">修改</a></td>"+
            "</tr>";
        $(html_dom).append(str_html);
        var new_tr = $(html_dom).children("tr:last-child");
        $(new_tr).fadeIn((key+1)*300);
    }

    function hideInfo(){
        $(".reg_info").fadeOut(400);
        $(".tj_main").fadeIn(800);
        $(".goback").fadeIn(800);
    }

    function showInfo(){
        $(".tj_main").fadeOut(400);
        $(".goback").fadeOut(400);
        $(".reg_info").fadeIn(800);
    }
    function show_info(obj,user_id){
        showInfo();
        var tr_d = $(obj).parent().parent();
        delete_tr = tr_d;
        var card_num = $(tr_d).children().eq(1).html();
        var real_name = $(tr_d).children().eq(2).html();
        var sex = $(tr_d).children().eq(3).html();
        var identity_num = $(tr_d).children().eq(4).html();
        var phone_num = $(tr_d).children().eq(5).html();
        var info_html = "<p><span>编号</span><span>"+card_num+"</span></p>"+
            "<p><span>姓名</span><span>"+real_name+"</span></p>"+
            "<p><span>性别</span><span>"+sex+"</span></p>"+
            "<p><span>证件号</span><span>"+identity_num+"</span></p>"+
            "<p><span>手机号</span><span>"+phone_num+"</span></p>"+
            "<p style='color: red;margin-top: 20px;'>如需删除请管理员再次刷卡确认</p>";
        $(".reg_info").find("div[class='reg_text']").html(info_html);
    }

    function deleteUser(obj,user_id){
        show_info(obj,user_id);
    }

    function pay_card(){
        if(delete_tr){
            var user_id = $(delete_tr).children().eq(0).html();
            $.ajax({
                type: "POST",
                url:"{{url('admin/delUser')}}",
                data: "user_id="+user_id,
                dataType:'json',
                success: function(json_data){
                    if(json_data.flag == 'success'){
                        hideInfo();
                        $(delete_tr).fadeOut((800),function(){
                            $(this).remove();
                        }.bind(delete_tr));
                    }
                }
            });
        }else{
            layer.confirm('请重新选中要删除的用户', {
                btn: ['确定'] //按钮
            }, function(){
                layer.closeAll();
                hideInfo();
            });
        }
    }

    $(document).ready(function(){
        //返回按钮
        myself_hover(".goback img");
        myself_touch(".goback img");

        $(".table_user_list").find('tbody').scroll(function(){
            var viewH =$(this).height(),//可见高度
                contentH =$(this).get(0).scrollHeight,//内容高度
                scrollTop =$(this).scrollTop();//滚动高度
            if((viewH + scrollTop) == contentH){ //到达底部时,加载新内容
                // 这里加载数据..
                refresh.loaded_data(this);
            }
        });
        refresh.loaded_data($(".table_user_list").find('tbody'));
    });


</script>
@endsection

