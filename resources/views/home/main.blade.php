<input type="button" onclick="login();" value="登陆" />
<input type="button" onclick="retister();" value="注册" />
<script src="{{@asset('static/js/jquery.js')}}"></script>
<script src="{{@asset('home/js/drivingschool.js')}}"></script>

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
    run.date = new Date({{time()}}000);
    var run_id = Math.ceil(Math.random()*1000000000000000);
    run.option = {
        'call_api':"{{action('Api\DataMachineRunLogController@setRunLog')}}",//调用接口
        'log_type':'1',                                  //(1为设备开启；2为设备关闭)科二：(6为放弃；7为错误；8为通过；9为课程开始；10为课程结束)科三：(11为开始，12为结束，13为错误)
        'run_id':run_id,                                 //设备开启运行的识别标识，必填,唯一(必传)
        'course_id':"",                                  //课程id(设备开启和关闭时不用传)
        'start_time':'2017-04-17 10:34:39',              //课程练习开始时间(设备关闭时不用传)
        'error_type':'4'                                 //错误类型 0为正常 错误关闭关联课程建议表ds_course_advice(必传)
//        'mac':'9d-er-9o-dd-4r',                        //设备物理地址(必传)
//        'machine_num':'1234',                          //设备编号(必传)
//        'user_id':'143',                               //用户id(必传)
//        'end_time':'2017-04-17 10:39:14',              //课程练习结束时间(设备开启时不用传)
    }

    run.data_arr = [];
    run.get_data_arr = function (){
        var sbc = {'2':[1,2,3,4,5],'3':[11,12,13,14,15,16,17,18,19,20,21]};
        this.data_arr.push({'subject_id':2,'course_id':0,'log_type':1});
        $.each(sbc, function (subject_id,item) {
            if(subject_id == '2'){
                item.forEach(function(course_id){
                    var log_type_arr = this.suiji([]);
                    log_type_arr.forEach(function(log_type){
                        this.data_arr.push({'subject_id':subject_id,'course_id':course_id,'log_type':log_type});
                    }.bind(this));
                }.bind(this));
            }else{
                var i = 0;
                while (i<6)
                {
                    this.data_arr.push({'subject_id':subject_id,'course_id':'','log_type':11});
                    if(this.suiji3()){
                        item.forEach(function(course_id){
                            if(this.suiji3()) {
                                this.data_arr.push({'subject_id': subject_id, 'course_id': course_id, 'log_type': 13});
                            }
                        }.bind(this));
                    }
                    this.data_arr.push({'subject_id':subject_id,'course_id':'','log_type':12});
                    i = Math.ceil(Math.random()*10);
                }
            }
        }.bind(this));
        this.data_arr.push({'subject_id':2,'course_id':0,'log_type':2});
    }

    run.send = function(){
        var s_run = this;
        if(this.data_arr.length > 0){
            var op = this.data_arr.shift()
            console.log("subject_id:"+op.subject_id+"--------course_id:"+op.course_id+"---------log_type:"+op.log_type+"--------->"+this.data_arr.length);
//            console.log(op);
//            s_run.send();
            this.option.log_type = op.log_type;
            this.option.course_id = op.course_id;
            this.date = new Date(Date.parse(new Date(this.date.Format("yyyy-MM-dd hh:mm:ss"))) + 3 * 60 * 1000);
            this.option.start_time= this.date.Format("yyyy-MM-dd hh:mm:ss");
            this.option.error_type = this.suiji_error_type();
            ds.send(this.option,function(data){
                console.log(data);
                if(data.status){
                    setTimeout(function(){
                        s_run.send();
                    },1000);
                }
            });

        }
    }
    run.simulation = function (){
        this.get_data_arr();
        this.send();
    }
    run.single = function (){
        this.option.run_id = '523184006187954'
        this.option.log_type = 1;
        this.option.course_id = "";
        this.date = new Date(Date.parse(new Date(this.date.Format("yyyy-MM-dd hh:mm:ss"))) + 5 * 60 * 1000);
        this.option.start_time = this.date.Format("yyyy-MM-dd hh:mm:ss");
        ds.send(this.option,function(data){
            console.log(data);
        });
    }

    run.suiji = function(prev_arr){
        var return_arr = [9];
        var i = Math.ceil(Math.random()*10);
        while (i)
        {
            if(i < 6){
                return_arr.push(7);
            }else if(i >= 6 && i < 10){
                return_arr.push(8);
                return_arr.push(10);
                break;
            }else{
                return_arr.push(6);
                return_arr.push(10);
                break;
            }
            i = Math.ceil(Math.random()*10);
        }
        var j = Math.ceil(Math.random()*10);

        if(j > 4){
            return_arr = return_arr.concat(this.suiji([]));
        }
        return_arr = prev_arr.concat(return_arr);
        return return_arr;
    }

    run.suiji3 = function(){
        var j = Math.ceil(Math.random()*10);
        if(j > 6){
            return true;
        }else{
            return false;
        }
    }

    run.suiji_error_type = function(){
        var return_str = "";
        var i = Math.ceil(Math.random()*100);
        while (i){
            if(i < 65){
                return_str = i
                break;
            }
            i = Math.ceil(Math.random()*100);
        }
        return return_str;
    }


//    run.single();
    run.simulation();

</script>