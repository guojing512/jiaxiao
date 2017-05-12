@extends('home.common.layout')
@section('title', '管理员统计-超弦科技')
@section('content')
    
    <div id="main">
        <div class="tj_jichu_edit"  >
            <form id="myForm" action="" method="post">
                <input type="hidden" name="id" value="{{$user->id}}" />
                <div>
                    <label for="real_name" class>编号</label>
                    <input type="text" id="card_num" value="{{$user->card_num}}" disabled="disabled" style="background: #e7e7e7;color: #c8c8c8;"/>
                </div>
                <div>
                    <label for="real_name" class>姓名</label>
                    <input type="text" name="real_name" id="real_name" value="{{$user->real_name}}"/>
                </div>
                <div>
                    <label for="sex" class>性别</label>
                    <select name="sex" style="width:200px;">
                        <option value="1" @if($user->sex == '1') selected @endif>男</option>
                        <option value="2" @if($user->sex == '2') selected @endif>女</option>
                    </select>

                </div>
                <div class="edit_user_iden">
                    <ul>
                        <li  val="1" @if($user->identity_type == '1') checked="checked" @endif >身份证</li>
                        <li  val="2" @if($user->identity_type == '2') checked="checked" @endif >军官证</li>
                        <li  val="3" @if($user->identity_type == '3') checked="checked" @endif >护照</li>
                    </ul>
                    <input type="hidden" id="u_identity" value="{{$user->identity_type}}" />
                </div>

                <div>
                    <label for="identity_num">证件号</label>
                    <input type="text"  id="identity_num" value="{{$user->identity_num}}" disabled="disabled" style="background: #e7e7e7;color: #c8c8c8;"/>
                </div>

                <div>
                    <label for="phone_num" class>手机号</label>
                    <input type="text" name="phone_num" id="phone_num" value="{{$user->phone_num}}"/>
                </div>
                <div id="error_message" style="display:none;">{{$errors->first('error_message')}}</div>
                <p class="btn_tj_edit_user">
                    <a href="{{url('/admin/statistics/userList')}}" ><img src="{{@asset('home/images/222_fan1.png')}}" src_1="{{@asset('home/images/222_fan1.png')}}" src_2="{{@asset('home/images/222_fan2.png')}}"/></a>
                    <a href="javascript:{doSubmit()};" ><img src="{{@asset('home/images/222_bcun1.png')}}" src_1="{{@asset('home/images/222_bcun1.png')}}" src_2="{{@asset('home/images/222_bcun2.png')}}"/></a>
                <p>
            </form>
        </div>
    </div>

<script src="{{@asset('plugins/layer/layer.js')}}"></script>
<script src="{{@asset('plugins/layer/layer-myself.js')}}"></script>
<script type="text/javascript">
    function doSubmit(){
        $("#myForm").submit();
    }

    $(document).ready(function(){
        myself_hover(".btn_tj_edit_user a img");
        myself_touch(".btn_tj_edit_user a img");

        if($("#error_message").html() != ""){
            layer.open({
                title:'错误',
                type: 1,
                area: ['600px', '360px'],
                shadeClose: true, //点击遮罩关闭
                content: '<div style="padding:20px;">'+$("#error_message").html()+'</div>'
            });
        }
    });
    $(function(){
//        $(".edit_user_iden ul li").on("click",function(){
//            var curr_val = $(this).attr("val");
//            $("#u_identity").val(curr_val);
//            $(this).css({"background":"#3393ed","color":"#fff"});
//            $(this).siblings().css({"background":"#fff","color":"#646464"});
//        });
        $(".edit_user_iden ul li").each(function () {
            if($(this).attr('checked') == "checked"){
                $(this).css({"background":"#3393ed","color":"#fff"});
                $(this).siblings().css({"background":"#fff","color":"#646464"});
            }
        });
    });

</script>
@endsection

