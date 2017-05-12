<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="{{@asset('plugins/zTree/css/metroStyle/metroStyle.css')}}" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        .ty_anniu{height:40px; line-height:40px; width:100%; margin:10px 0px; text-align:center;}
        .ty_anniu a{
            text-align: center;
            display: inline-block;
            width: 124px;
            height: 35px;
            line-height: 35px;
            margin: 20px 0px 0px 30px;
            color: #fff;
            background: #50b955;
            border-radius: 3px;
            text-decoration: none;
        }
    </style>
    <script src="{{@asset('plugins/zTree/js/jquery-1.4.4.min.js')}}"></script>
    <script src="{{@asset('plugins/zTree/js/jquery.ztree.core-3.5.js')}}"></script>
    <script src="{{@asset('plugins/zTree/js/jquery.ztree.excheck-3.5.js')}}"></script>
</head>
<body>
    <div class="yytsxt_ding_1">
        <div class="zTreeDemoBackground" style="width:100%" >
            <ul id="treeDemo" class="ztree" style="width:auto; margin-top:0px;"></ul>
            <div class="ty_anniu">
                <a id='submit' href="javascript:;" class="chen">提交</a>
                <a id='all_true' href="javascript:;" class="ty_yellow">全选</a>
                <a id='all_false' href="javascript:;"  class="ty_yellow">全不选</a>
            </div>
        </div>
    </div>
    <SCRIPT type="text/javascript">
        {{--配置属性--}}
  
        var setting = {
            check: {enable: true},
            data: {
                simpleData: {
                    enable: true,
                    idKey: "id",
                    pIdKey: "parent_id",
                    rootPId: 0
                }
            }
        };


        {{--配置节点数据--}}
        var zNodes = {!!$list_menu!!};
        console.log(zNodes);


        {{--初始化信息--}}
        var code;
        $(document).ready(function(){

          // 初始化
          var zTree = $.fn.zTree.init($("#treeDemo"), setting, zNodes);

          // 展开全部的
          zTree.expandAll(true);

          $("#submit").click(function(){
              var treeJson  = zTree.getCheckedNodes(true);
              var nodes = new Array();

              for(i=0;i<treeJson.length;i++){
                  nodes.push(treeJson[i]['id']);
              }

              //console.log(nodes);

              $.post("{{url('manage/group/setRole')}}", {menu_ids:nodes,group_id:{{$group_id}}},
                function(data){
                    console.log(data);
                    if(data=='success'){
                        if(confirm("修改成功！是否关闭授权窗口？")){
                            var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                            parent.layer.close(index);
                        }
                    }else{
                        alert('修改失败！');
                    }
                });

            });

          $("#all_true").click(function(){
              zTree.checkAllNodes(true);
          });
          $("#all_false").click(function(){
              zTree.checkAllNodes(false);
          });

        });
    </SCRIPT>
</body>
</html>
