@extends('home.common.layout')
@section('title', '管理员统计-超弦科技')
@section('content')
    
    <div id="main">
        <div class="bug">
            <h3>报修</h3>
            <form id="myForm" action="" method="">
                <div class="bug_con">
                    <p class="bug_text"><img src="{{@asset('home/images/not_select.png')}}"  is_select="0" val="1" src_1="{{@asset('home/images/not_select.png')}}" src_2="{{@asset('home/images/select.png')}}" /><span>自助终端无法启动硬件设备</span></p>
                    <p class="bug_text"><img src="{{@asset('home/images/not_select.png')}}"  is_select="0" val="2" src_1="{{@asset('home/images/not_select.png')}}" src_2="{{@asset('home/images/select.png')}}"/><span>硬件设备科目模拟无法进入</span></p>
                    <p class="bug_text"><img src="{{@asset('home/images/not_select.png')}}"  is_select="0" val="3" src_1="{{@asset('home/images/not_select.png')}}" src_2="{{@asset('home/images/select.png')}}"/><span>自助终端不能正常使用</span></p>
                    <p class="bug_text"><img src="{{@asset('home/images/not_select.png')}}"  is_select="0" val="4" src_1="{{@asset('home/images/not_select.png')}}" src_2="{{@asset('home/images/select.png')}}"/><span>硬件设备部件出现损坏</span></p>
                    <p class="bug_text"><img src="{{@asset('home/images/not_select.png')}}"  is_select="0" val="5" src_1="{{@asset('home/images/not_select.png')}}" src_2="{{@asset('home/images/select.png')}}"/><span>无法注册新用户</span></p>
                    <p class="bug_text"><img src="{{@asset('home/images/not_select.png')}}"  is_select="0" val="6" src_1="{{@asset('home/images/not_select.png')}}" src_2="{{@asset('home/images/select.png')}}"/><span>无法进行充值</span></p>
                    <p class="bug_text"><img src="{{@asset('home/images/not_select.png')}}"  is_select="0" val="7" src_1="{{@asset('home/images/not_select.png')}}" src_2="{{@asset('home/images/select.png')}}"/><span>其他问题</span></p>
                </div>
                <input type="hidden" name="bug_type" value="" />
                <p class="bug_msg"><textarea name="message" placeholder="请输入"></textarea></p>
                <div class="btn_bug">
                    <a href="{{url('admin')}}"><img src="{{@asset('home/images/282_fan1.png')}}" src_1="{{@asset('home/images/282_fan1.png')}}" src_2="{{@asset('home/images/282_fan2.png')}}"/></a>
                    <a href="javascript:{doSubmit();}" class="reg_info_submit"><img src="{{@asset('home/images/282_tj1.png')}}" src_1="{{@asset('home/images/282_tj1.png')}}" src_2="{{@asset('home/images/282_tj2.png')}}"/></a>
                </div>
            </form>
        </div>


        <!-- 弹窗 -->
        <div class="bug_tan">
            <p>已提交成功，我们会尽快处理</p>
            <p>温馨提示：成功提交后请停止设备的运营，以免造成不必要的损失</p>
            <p class="btn_bug_tan" onclick="success();"><img src="{{@asset('home/images/282_tj1.png')}}" src_1="{{@asset('home/images/282_qr1.png')}}" src_2="{{@asset('home/images/282_qr2.png')}}"/></p>
        </div>
    </div>


<script src="{{@asset('plugins/layer/layer.js')}}"></script>
<script src="{{@asset('plugins/layer/layer-myself.js')}}"></script>
<script type="text/javascript">
    function doSubmit(){
        if($("input[name='bug_type']").val() == ""){
            error({'mes':"请选择至少一项报修类型。",'time':3000});
        }else{
            $.ajax({
                type: "POST",
                url:"",
                data: $('#myForm').serialize(),
                dataType:'json',
                success: function(jsonData){
                    if(jsonData.flag == "success"){
                        showInfo();
                    }else{
                        error({'mes':jsonData.msg,'time':3000});
                    }
                }
            });
        }

    }

    function showInfo(){
        $(".bug").css({"display":"none"});
        $(".bug_tan").css({"display":"block"});
    }

    function success(){
        window.location.href = "{{url('admin')}}";
    }

    function setBug_type(){
        var val_arr = [];
        $(".bug_text img").each(function(){
            if($(this).attr('is_select') == '1'){
                val_arr.push($(this).attr('val'))
            }
        });
        $("input[name='bug_type']").attr("value",val_arr.join(","));
    }
    $(document).ready(function(){
        //返回 提交
        myself_hover(".btn_bug a img");
        myself_touch(".btn_bug a img");

        //弹窗按钮
        myself_hover(".bug_tan p img");
        myself_touch(".bug_tan p img");


        //报修条款勾选
        $(".bug_text img").on("click",function(){
            var is_select = $(this).attr("is_select");
            var src_1 = $(this).attr("src_1");
            var src_2 = $(this).attr("src_2");
            if(is_select == 0){
                $(this).attr("is_select","1");
                $(this).attr("src",src_2);
            }else{
                $(this).attr("is_select","0");
                $(this).attr("src",src_1);
            }
            setBug_type();
        });
    });
</script>
@endsection

