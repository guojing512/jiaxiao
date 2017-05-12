<div class="user_foot">
    <ul>
        <li>
            <div><div id="total_train_time" class="u_canvas"></div><span id="train_time_val">{{$userExt['format_used_time']}}</span></div>
            <p>总训练时长</p>
        </li>
        <li>
            <div id="remaining_time" class="u_canvas"><span id="remaining_time_val">{{$userExt['format_remaining_time']}}</span></div>
            <p>剩余时长</p>
        </li>
        <li>
            <div><a href="{{url('recharge')}}"> <img src="{{@asset('home/images/u_cz.png')}}"/></a></div>
            <p>充值时长</p>
        </li>
        <li>
            <div><a href="{{url('user/helpShangji')}}"><img src="{{@asset('home/images/u_help.png')}}"/></a></div>
            <p>帮助</p>
        </li>
    </ul>
    <div id="start_train"><a href="javascript:{start();}"><img src="{{@asset('home/images/178_ksxl1.png')}}" src_1="{{@asset('home/images/178_ksxl1.png')}}" src_2="{{@asset('home/images/178_ksxl2.png')}}" width="178" height="178"></a></div>
</div>