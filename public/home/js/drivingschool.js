/**
 * Created by gj on 2017/4/14.
 */

var ds = {};
/** option 参数说明
 * @call_api 调用的api
 * @mac 设备物理地址
 * @end_mode 结束方式，1为正常 2为异常
 * @src_type 数据来源类型，1为设备上报  2为测试数据
 * @log_type 日志类型：当为科目二时（1为设备开启；  2为设备关闭；6为放弃；7为错误；8为通过；9为科目二开始；10为科目二结束）
 *                       当为科目三时（11是科三开始（即选中科三训练开始,开始时就同步更新科目三的训练次数）；12是本科目结束时间；13是训练出错（为3时error_type需要对应错误id））
 * @run_id 设备开启运行的识别标识，必填,唯一
 * @course_id 课程id
 * @start_time 课程练习开启时间
 * @error_type 错误类型 0为正常 错误关联课程建议表ds_course_advices
 * */
ds.option = {};
/** *
 * 设置参数验证当required包含log_type时执行验证
 * @  subject2{'call_api':{'required':[],'msg':'api不能为空'}........}
 * @subject2为科目，call_api为参数名，required为根据log_type的验证条件，msg为错误提示。
 */
ds.validatorOption = {
    'call_api':{'required':[],'msg':'call_api不能为空'},'log_type':{'required':[],'msg':'日志类型不能为空'},
    'run_id':{'required':[],'msg':'run_id不能为空'},'course_id':{'required':[1,2,11,12],'msg':'课程id不能为空'},
    'start_time':{'required':[],'msg':'开始时间不能为空'},'error_type':{'required':[],'msg':'错误类型不能为空'}
};
ds.message = {};

/** *
 * 发送数据
 * */
ds.send = function(option,call_back){
    var option_data = this.setOption(option);
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
    }else{
        if(typeof(call_back) ==  'function'){
            call_back(option_data);
        }
    }
}

ds.setOption = function(option){
    if(typeof(option) != 'object'){
        return {'status':false,'msg':'参数类型错误'}
    }else if(option.log_type && option.log_type != ""){
        if(option.log_type > 10){
            this.option.subject_id = "3";
        }else{
            this.option.subject_id = "2";
        }
        for(var key in this.validatorOption){
            var required_arr = eval("this.validatorOption."+key+".required");
            var log_type = parseInt($.trim(option.log_type));
            var required_index = $.inArray(log_type,required_arr);
            if((eval("typeof(option."+key+")") == "undefined" || eval("option."+key) == "") && required_index == "-1"){
                return {'status':false,'code':101,'msg':eval("this.validatorOption."+key+".msg")};
            }else{
                if(key == 'log_type' && eval("option." + key + " > 10")){
                    eval('this.option.' + key + " = " + "option." + key + " - 10");
                }else{
                    eval('this.option.' + key + " = " + "option." + key);
                }
            }
        }
        return {'status':true,'code':0,'msg':'ok'};
    }else{
        return {'status':false,'code':101,'msg':this.validatorOption.log_type.msg};
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

/** *
 * @card_num 卡片id
 * @call_back 回掉方法
 * */
ds.loginByCard = function(card_num,call_back){
    if(typeof(card_num) == 'undefined' || card_num == ''){
        var valid_data = {'status':false,'code':101,'msg':'卡片id不能为空'};
        this.message.valid =  valid_data;
        if(typeof(call_back) ==  'function'){
            call_back(valid_data);
        }
    }else{
        console.log(card_num);
        $.ajax({
            type: "POST",
            url:'loginByCard',
            data: 'card_num='+card_num,
            dataType:'json',
            success: function(jsonData){
                this.message.send =  jsonData;
                if(typeof(call_back) ==  'function'){
                    call_back(jsonData);
                }
            }.bind(this),
        });
    }
}