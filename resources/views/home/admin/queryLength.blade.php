@extends('home.common.layout')
@section('title', '管理员统计-超弦科技')
@section('content')
    
<div id="main">
    <div class="select_time">
        <div class="select_time_top">
            <div class="tt_left">
                <p class="tt_p1">管理员账号</p>
                <p class="tt_p2">{{$card_num}}</p>
            </div>
            <div class="tt_right">
                <p class="tt_p1">剩余时长</p>
                <p class="tt_p2">{{$available_time}}小时</p>
            </div>

            <div class="tiao"></div>

        </div>

        <div class="select_time_con">
            <table class="table_s_time">
                <thead>
                <tr>
                    <!--加起来为1160-->
                    <th width="100">序号</th>
                    <th width="200">编号</th>
                    <th width="150">姓名</th>
                    <th width="110">性别</th>
                    <th width="200">电话</th>
                    <th width="200">充值时间</th>
                    <th width="200">充值时长</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>


    </div>
</div>
<div class="goback" style="right:130px;bottom:60px;"><a href="{{url('admin')}}" ><img src="{{@asset('home/images/goback1.png')}}" src_1="{{@asset('home/images/goback1.png')}}" src_2="{{@asset('home/images/goback2.png')}}"/> </div>

<script type="text/javascript">
    var refresh = {};
    refresh.flag = true;
    refresh.page = 1;
    refresh.getData = function(callback){
        $.ajax({
            type: "POST",
            url:"{{url('admin/queryLength')}}",
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
            "<td width='100'>"+data.id+"</td>"+
            "<td width='200'>"+data.admin_user.card_num+"</td>"+
            "<td width='150'>"+data.admin_user.real_name+"</td>"+
            "<td width='110'>"+data.format_sex+"</td>"+
            "<td width='200'>"+data.admin_user.phone_num+"</td>"+
            "<td width='200'>"+data.format_created_at+"</td>"+
            "<td width='200'>"+data.format_give_time+"</td>"+
            "</tr>";
        $(html_dom).append(str_html);
        var new_tr = $(html_dom).children("tr:last-child");
        $(new_tr).fadeIn((key+1)*300);
    }
    $(document).ready(function(){
        //返回按钮
        myself_hover(".goback img");
        myself_touch(".goback img");

        $(".select_time_con").find('tbody').scroll(function(){
            var viewH =$(this).height(),//可见高度
                contentH =$(this).get(0).scrollHeight,//内容高度
                scrollTop =$(this).scrollTop();//滚动高度
            if((viewH + scrollTop) == contentH){ //到达底部时,加载新内容
                // 这里加载数据..
                refresh.loaded_data(this);
            }
        });
        refresh.loaded_data($(".select_time_con").find('tbody'));
    });
</script>
@endsection

