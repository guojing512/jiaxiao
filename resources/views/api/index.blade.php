<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>VR驾校后台_登陆</title>
<link href="{{@asset('static/css/common.css')}}" rel="stylesheet" type="text/css" media="all" />
<link href="{{@asset('static/css/layout01.css')}}" rel="stylesheet" type="text/css" media="all" />
</head>
<style>
    .error{
        font-size: 12px;
        color: red;
        width:auto;
        height: 20px;
    }
</style>
<body>
<div class="vr_header01"><a href=""><img src="{{@asset('static/images/logo.png')}}" width="200" height="34" alt=""/></a></div>
<div class="clear"></div>
<form method="post">
    {{ csrf_field() }}
    <div class="vr_land">
        <div class="land_main">
            <div>
                <input name="" type="button" onclick="start();" class="land_in03" value="开始api测试" style="margin-top:20px;" />
                <input name="" type="button" onclick="stop();" class="land_in03" value="结束api测试" style="margin-top:20px;" />
            </div>
        </div>
    </div>
</form>
<div class="clear"></div>
<div class="vr_footer">版权所有:2016-2020&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;超弦科技有限公司&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;京ICP备16051556号-1</div>
<div class="clear"></div>

<script src="{{@asset('static/js/jquery.js')}}"></script>
<script>
    Date.prototype.Format = function (fmt) { //author: meizz
        var o = {
            "M+": this.getMonth() + 1, //月份
            "d+": this.getDate(), //日
            "h+": this.getHours(), //小时
            "m+": this.getMinutes(), //分
            "s+": this.getSeconds(), //秒
            "q+": Math.floor((this.getMonth() + 3) / 3), //季度
            "S": this.getMilliseconds() //毫秒
        };
        if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
        for (var k in o)
            if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
        return fmt;
    }


    var run = {};

    run.setOption = function(){
        this.date = new Date(1137075575000);
        this.start_flag = true;
        this.callApi = [];
        this.sb_arr = {'2':[14,15,19,20,21],'3':[16,17,18,22,23,24,25,26,27,28,29]};
        this.option = {};
        this.option.mac = Math.ceil(Math.random()*1000000000000000);                 //设备物理地址
        this.option.end_mode = '1';                                                  //1为正常 2为异常
        this.option.src_type = '2';                                                  //数据来源类型，1为设备上报  2为测试数据
        this.option.log_type = '';                                                   //日志类型：1为设备开启；  2为设备关闭； 3为课程完美通过；  4为一次错误通过；5为多次错误通过；6为放弃；7为错误；
        this.option.run_id = Math.ceil(Math.random()*1000000000000000);              //设备开启运行的识别标识，必填,唯一
        this.option.machine_num = Math.ceil(Math.random()*1000000000000000);         //设备编号
        this.option.user_id = Math.ceil(Math.random()*10000000);                     //用户id
        this.option.subject_id = "";                                                 //科目id
        this.option.course_id = "";                                                  //课程id
        this.option.start_time = this.date.Format("yyyy-MM-dd hh:mm:ss");                 //课程练习开启时间
        this.option.end_time = '';                                                   //课程练习结束时间
        this.option.error_type = Math.ceil(Math.random()*10);                        //错误类型 0为正常 错误关闭关联课程建议表ds_course_advice
    }

    run.resetOption = function(){
        this.date = new Date(Date.parse(new Date(this.date.Format("yyyy-MM-dd hh:mm:ss"))) + 60 * 1000);
        this.option.start_time = this.date.Format("yyyy-MM-dd hh:mm:ss");
        this.option.error_type = Math.ceil(Math.random()*10);
    }

    run.getDataStr = function(){
        this.resetOption();
        var data_arr = [];
        for(var name in this.option){
            data_arr.push(name+"="+this.option[name]);
        }
        return data_arr.join("&");
    }

    run.send = function(){
        var s_run = this;
        console.log(this.callApi.length);
        if(this.start_flag){
            if(this.callApi.length > 0){
                $.ajax({
                    type: "POST",
                    url:'{{url('setRunLog')}}',
                    data: this.callApi.shift(),
                    dataType:'json',
                    success: function(jsonData){
                        console.log(s_run);
                        s_run.send();
                    }
                });
            }else{
                this.stop();
                console.log("-----------------有人来练车了-----------------");
                this.start();
            }
        }

    }

    run.start = function(){
        console.log("-----------------开启设备-----------------");
        this.setOption();
        this.option.log_type = 1;
        this.callApi.push(this.getDataStr());
        this.runing();
    }

    run.random = function(){
        var i = Math.ceil(Math.random()*10);
        while (i)
        {
            if(i < 6){
                this.option.log_type = 7;
                this.callApi.push(this.getDataStr());
            }else if(i >= 6 && i < 10){
                this.option.log_type = 8;
                this.callApi.push(this.getDataStr());
                break;
            }else{
                this.option.log_type = 6;
                this.callApi.push(this.getDataStr());
                break;
            }
            i = Math.ceil(Math.random()*10);
        }
    }

    run.runing = function(){
        $.each(this.sb_arr, function (subject_id,item) {
            item.forEach(function(course_id){
                this.option.subject_id = subject_id;
                this.option.course_id = course_id;
                this.random();
            }.bind(this));
        }.bind(this));
       this.send();
    }

    run.stop = function(){
        this.option.log_type = 2;
        this.option.end_time = this.date.Format("yyyy-MM-dd hh:mm:ss");
        $.ajax({
            type: "POST",
            url:'{{url('setRunLog')}}',
            data: this.getDataStr(),
            dataType:'json',
            success: function(jsonData){
                console.log(jsonData);
            }
        });
    }


    function start(){
        run.start();
    }

    function stop(){
        run.stop();
        run.start_flag = false;
    }
</script>
</body>
</html>
