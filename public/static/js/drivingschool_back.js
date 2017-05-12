/**
 * Created by gj on 2017/4/14.
 */

var ds = {};

/** *
 * @call_api 调用的api
 * @mac 设备物理地址
 * @end_mode 结束方式，1为正常 2为异常
 * @src_type 数据来源类型，1为设备上报  2为测试数据
 * @log_type 日志类型：当为科目二时（1为设备开启；  2为设备关闭；6为放弃；7为错误；8为通过；9为科目二开始；10为科目二结束）
 *                      当为科目三时（1是科三开始（即选中科三训练开始,开始时就同步更新科目三的训练次数）；2是本科目结束时间；3是训练出错（为3时error_type需要对应错误id））
 * @run_id 设备开启运行的识别标识，必填,唯一
 * @machine_num 设备编号
 * @user_id 用户id
 * @subject_id 科目id
 * @course_id 课程id
 * @start_time 课程练习开启时间
 * @end_time 课程练习结束时间
 * @error_type 错误类型 0为正常 错误关闭关联课程建议表ds_course_advices
 * */
ds.option = {};
/** *
 * 设置参数验证当required包含log_type时执行验证
 * @  subject2{'call_api':{'required':[],'msg':'api不能为空'}........}
 * @subject2为科目，call_api为参数名，required为验证条件，msg为错误提示。
 */
ds.validatorOption = {
    subject2:{
        'call_api':{'required':[],'msg':'api不能为空'},'mac':{'required':[],'msg':'mac不能为空'},'log_type':{'required':[],'msg':'日志类型不能为空'},
        'run_id':{'required':[],'msg':'run_id不能为空'},'machine_num':{'required':[],'msg':'设备编号不能为空'},'user_id':{'required':[],'msg':'用户id不能为空'},
        'subject_id':{'required':[1,2,9,10],'msg':'科目id不能为空'},'course_id':{'required':[1,2,9,10],'msg':'课程id不能为空'},'start_time':{'required':[2,10],'msg':'开始时间不能为空'},
        'end_time':{'required':[1,9],'msg':'结束不能为空'}, 'error_type':{'required':[1,2,6,8,9,10],'msg':'错误类型不能为空'}
    },
    subject3:{
        'call_api':{'required':[],'msg':'api不能为空'},'mac':{'required':[],'msg':'mac不能为空'},'log_type':{'required':[],'msg':'日志类型不能为空'},
        'run_id':{'required':[],'msg':'run_id不能为空'},'machine_num':{'required':[],'msg':'设备编号不能为空'},'user_id':{'required':[],'msg':'用户id不能为空'},
        'subject_id':{'required':[1,2,3],'msg':'科目id不能为空'},'course_id':{'required':[3],'msg':'课程id不能为空'},'start_time':{'required':[],'msg':'开始时间不能为空'},
        'error_type':{'required':[3],'msg':'错误类型不能为空'}
    },
};

ds.message = {};

/** *
 * 发送数据
 * */
ds.subject2_send = function(option,call_back){
    var option_data = this.setOptionSubject2(option);
    if(option_data.status){
        $.ajax({
            type: "POST",
            url:this.option.call_api,
            data: this.getDataStr(),
            dataType:'json',
            success: function(jsonData){
                if(typeof(call_back) ==  'function'){
                    call_back(jsonData);
                }
            }
        });
    }
    return option_data;
}

ds.subject3_send = function(option,call_back){
    var option_data = this.setOptionSubject3(option);
    this.message.valid =  option_data;
    if(option_data.status){
        $.ajax({
            type: "POST",
            url:this.option.call_api,
            data: this.getDataStr(),
            dataType:'json',
            success: function(jsonData){
                this.message.send =  jsonData;
                if(typeof(call_back) ==  'function'){
                    call_back(jsonData);
                }
            }.bind(this),
        });
    }else{
        if(typeof(call_back) ==  'function'){
            call_back(option_data);
        }
    }
}
/** *
 * 设置参数科目二，以及参数验证
 * */
ds.setOptionSubject2 = function(option){
    option.subject_id = "2";
    if(typeof(option) != 'object'){
        return {'status':false,'msg':'参数类型错误'}
    }else if(option.log_type && option.log_type != ""){
        for(var key in this.validatorOption.subject2){
            var required_arr = eval("this.validatorOption.subject2."+key+".required");
            var log_type = parseInt($.trim(option.log_type));
            var required_index = $.inArray(log_type,required_arr);
            if((eval("typeof(option."+key+")") == "undefined" || eval("option."+key) == "") && required_index == "-1"){
                return {'status':false,'code':101,'msg':eval("this.validatorOption.subject2."+key+".msg")}
            }else{
                eval('this.option.' + key + " = " + "option." + key);
            }
        }
        return {'status':true,'code':0,'msg':'ok'}
    }else{
        return {'status':false,'code':101,'msg':this.validatorOption.subject2.log_type.msg}
    }
}

/** *
 * 设置参数科目三，以及参数验证
 * */
ds.setOptionSubject3 = function(option){
    option.subject_id = "3";
    if(typeof(option) != 'object'){
        return {'status':false,'msg':'参数类型错误'}
    }else if(option.log_type && option.log_type != ""){
        for(var key in this.validatorOption.subject3){
            var required_arr = eval("this.validatorOption.subject3."+key+".required");
            var log_type = parseInt($.trim(option.log_type));
            var required_index = $.inArray(log_type,required_arr);
            if((eval("typeof(option."+key+")") == "undefined" || eval("option."+key) == "") && required_index == "-1"){
                return {'status':false,'code':101,'msg':eval("this.validatorOption.subject3."+key+".msg")}
            }else{
                eval('this.option.' + key + " = " + "option." + key);
            }
        }
        return {'status':true,'code':0,'msg':'ok'}
    }else{
        return {'status':false,'code':101,'msg':this.validatorOption.subject3.log_type.msg}
    }
}
/** *
 * 拼接post数据
 * */
ds.getDataStr = function(){
    var data_arr = [];
    for(var name in this.option){
        data_arr.push(name+"="+this.option[name]);
    }
    return data_arr.join("&");
}