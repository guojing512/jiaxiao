@extends('home.common.layout')
@section('title', '管理员统计-超弦科技')
@section('content')
    
<div id="main">
    <div class="tj_main">
        <div class="tj_table_title">学员科目三信息</div>

        <div class="tj_sub3">
            <table class="tj_sub3_table">
                <thead>
                <tr>
                    <!--加起来为1160-->
                    <th width="100">序号</th>
                    <th width="150">编号</th>
                    <th width="100">姓名</th>
                    <th width="150">科三测试次数</th>
                    <th width="150">通过率</th>
                    <th width="150">平均扣分</th>
                    <th width="150">平均违规</th>
                    <th width="210">总花费时长</th>
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
                <a href="{{url('admin/statistics/userList')}}"><li class="tj_i_li2">基<br/>础<br/>信<br/>息</li></a>
                <a href="{{url('admin/statistics/subject2List')}}"><li class="tj_i_li3">科<br/>目<br/>二</li></a>
                <a href=""><li class="tj_i_li4 bg_blue_tj">科<br/>目<br/>三</li></a>
            </ul>
        </div>
    </div>
</div>

<div class="goback" style="right:130px;bottom:60px;"><a href="javascript:history.back(-1);" ><img src="{{@asset('home/images/goback1.png')}}" src_1="{{@asset('home/images/goback1.png')}}" src_2="{{@asset('home/images/goback2.png')}}"/> </div>

<script type="text/javascript">
    var refresh = {};
    refresh.flag = true;
    refresh.page = 1;
    refresh.getData = function(callback){
        $.ajax({
            type: "POST",
            url:"{{url('admin/statistics/subject3List')}}",
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
            "<td width='100'>"+data.admin_user.id+"</td>"+
            "<td width='150'>"+data.admin_user.card_num+"</td>"+
            "<td width='100'>"+data.admin_user.real_name+"</td>"+
            "<td width='150'>"+data.train_num+"</td>"+
            "<td width='150'>"+data.format_pass_rate+"%</td>"+
            "<td width='150'>"+data.format_pass_score+"</td>"+
            "<td width='150'>"+data.format_pass_error_num+"</td>"+
            "<td width='210'>"+data.format_train_time+"小时</td>"+
            "</tr>";
        $(html_dom).append(str_html);
        var new_tr = $(html_dom).children("tr:last-child");
        $(new_tr).fadeIn((key+1)*300);
    }
    $(document).ready(function(){
        //返回按钮
        myself_hover(".goback img");
        myself_touch(".goback img");

        $(".tj_sub3").find('tbody').scroll(function(){
            var viewH =$(this).height(),//可见高度
                contentH =$(this).get(0).scrollHeight,//内容高度
                scrollTop =$(this).scrollTop();//滚动高度
            if((viewH + scrollTop) == contentH){ //到达底部时,加载新内容
                // 这里加载数据..
                refresh.loaded_data(this);
            }
        });
        refresh.loaded_data($(".tj_sub3").find('tbody'));
    });
</script>
@endsection

