$(function(){
    //加载扩展模块
    layer.config({
        extend: 'extend/layer.ext.js'
    });
});

function success(data){
    var mes_c = data['mes'] ? data['mes'] : '操作成功！'; 
    var fun_c = data['fun'] ? data['fun'] : function(){};
    var time_c = data['time'] ? data['time'] : 2000;
    var shade_c = data['shade'] ? data['shade'] : 0.3;
    var shadeClose_c = data['shadeClose']==false ? data['shadeClose'] : true;
    layer.msg(mes_c, {icon: 1, time:time_c, shade:shade_c, shadeClose:shadeClose_c}, fun_c);
}

function error(data){
    var mes_c = data['mes'] ? data['mes'] : '操作失败！'; 
    var fun_c = data['fun'] ? data['fun'] : function(){};
    var time_c = data['time'] ? data['time'] : 2000;
    var shade_c = data['shade'] ? data['shade'] : 0.3;
    var shadeClose_c = data['shadeClose']==false ? data['shadeClose'] : true;
    layer.msg(mes_c, {icon: 2, time:time_c, shade:shade_c, shadeClose:shadeClose_c}, fun_c);
}

function edit_ing(){
    var mes = arguments[0] ? arguments[0] : '正在修改……'; 
    return layer.msg(mes, {icon: 16, time:false, shade:0.3});
}

function confirmurl(url, name){
    layer.confirm("删除后不可恢复！<br/> 确定要删除【"+name+"】吗？", {
      btn: ['确定','取消'] //按钮
    }, function(){
        window.location.href = url; 
    }, function(){
    });
}
