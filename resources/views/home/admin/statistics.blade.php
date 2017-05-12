@extends('home.common.layout')
@section('title', '管理员统计-超弦科技')
@section('content')
    
<div id="main">
    <div class="tj_main">
        <div class="tj_sb">
            <ul>
                <li>
                    <div id="total_time"><span>{{$dataMachine->h_total_run_time}}</span></div>
                    <p>设备运营总时间</p>
                </li>
                <li>
                    <div id="total_start_num"><span>{{$dataMachine->total_start_num}}</span></div>
                    <p>设备启动次数</p>
                </li>
                <li>
                    <div id="total_train_num"><span>{{$dataMachine->total_train_num}}</span></div>
                    <p>设备总训练次数</p>
                </li>
                <li>
                    <div id="total_login_num"><span>{{$dataMachine->total_login_num}}</span></div>
                    <p>刷卡次数</p>
                </li>
            </ul>
        </div>
        <div class="tj_all_sub2">
            <h2>科目二训练</h2><span>总次数：{{$dataMachine->subject2_train_num}}次</span>
            <table class="all_sub2_table">
                <thead>
                <tr>
                    <th>科目</th>
                    <th>次数</th>
                    <th>时间</th>
                </tr>
                </thead>

                <tbody>
                @foreach($courses as $key => $course)
                    <tr>
                        <td>{{ $course['course_name'] }}</td>
                        <td>{{ $course['train_num'] }}</td>
                        <td>{{ $course['train_time'] }} 小时</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="tj_all_sub3">
            <h2>科目三训练</h2><span>总次数：{{$dataMachine->subject3_train_num}}次</span>
            <table class="all_sub3_table">
                <thead>
                <tr>
                    <th>通过率</th>
                    <th>平均扣分</th>
                    <th>违规操作</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td>{{$dataMachine->h_subject3_pass_rate}}%</td>
                    <td>{{$dataMachine->subject3_error_num}}分</td>
                    <td>{{$dataMachine->h_subject3_average_score}}次</td>
                </tr>
                </tbody>
            </table>
        </div>


        <!-- 右侧导航条 -->
        <div class="tj_item">
            <ul>
                <a href=""><li class="tj_i_li1 bg_blue_tj">总<br/><br/>计</li></a>
                <a href="{{url('admin/statistics/userList')}}"><li class="tj_i_li2">基<br/>础<br/>信<br/>息</li></a>
                <a href="{{url('admin/statistics/subject2List')}}"><li class="tj_i_li3">科<br/>目<br/>二</li></a>
                <a href="{{url('admin/statistics/subject3List')}}"><li class="tj_i_li4">科<br/>目<br/>三</li></a>
            </ul>
        </div>

    </div>
</div>
<script type="text/javascript" src="{{@asset('home/js/radialIndicator.js')}}"></script>
<script type="text/javascript">
    //设备运营总时间
    var total_time_num = parseInt($("#total_time span").html());
    var total_time = radialIndicator('#total_time', {
        radius : 64,
        barWidth : 7,
        barBgColor : '#fff',
        barColor : '#64D4A8',
        fontColor : '#38a179',
        fontSize : 16,
        fontStyle : 'italic',
        fontFamily:'微软雅黑',
        displayNumber: true,
        initValue:0,
        maxValue:total_time_num,
        frameTime:1,
        frameNum:100
    });
    total_time.animate(total_time_num);

    //设备启动次数
    var total_time_num = parseInt($("#total_start_num span").html());
    var total_time = radialIndicator('#total_start_num', {
        radius : 64,
        barWidth : 7,
        barBgColor : '#fff',
        barColor : '#D5B266',
        fontColor : '#bf9843',
        fontSize : 16,
        fontStyle : 'italic',
        fontFamily:'微软雅黑',
        displayNumber: true,
        initValue:0,
        maxValue:total_time_num,
        frameTime:1,
        frameNum:100
    });
    total_time.animate(total_time_num);

    //设备训练次数
    var total_time_num = parseInt($("#total_train_num span").html());
    var total_time = radialIndicator('#total_train_num', {
        radius : 64,
        barWidth : 7,
        barBgColor : '#fff',
        barColor : '#D58E72',
        fontColor : '#bf7050',
        fontSize : 16,
        fontStyle : 'italic',
        fontFamily:'微软雅黑',
        displayNumber: true,
        initValue:0,
        maxValue:total_time_num,
        frameTime:1,
        frameNum:100
    });
    total_time.animate(total_time_num);

    //刷卡次数(记录登录)
    var total_login_num = parseInt($("#total_login_num span").html());
    var total_login = radialIndicator('#total_login_num', {
        radius : 64,
        barWidth : 7,
        barBgColor : '#fff',
        barColor : '#61C6CF',
        fontColor : '#429fa6',
        fontSize : 16,
        fontStyle : 'italic',
        fontFamily:'微软雅黑',
        displayNumber: true,
        initValue:0,
        maxValue:total_login_num,
        frameTime:1,
        frameNum:100
    });
    total_login.animate(total_login_num);
</script>
@endsection

