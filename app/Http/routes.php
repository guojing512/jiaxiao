<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Event::listen('illuminate.query',function($query){
//     echo $query;
//     echo "<br/>";
// });

Route::any('/', ['uses'=>'Home\IndexController@index']);
//验证码
Route::get('captcha', 'KitController@captcha');

Route::get('test/{action}', function(App\Http\Controllers\TestController $index, $action){
    return $index->$action();
});

//api
Route::group(['prefix'=>'api','namespace'=>'Api'], function () {
    Route::post('setRunLog', ['uses'=>'DataMachineRunLogController@setRunLog']);
    Route::post('getMachineByMac', ['uses'=>'MachineController@getMachineByMac']);
    Route::get('index', ['uses'=>'DataMachineRunLogController@index']);
});

//前台
Route::group(['prefix'=>'','namespace'=>'Home','domain' => ''], function () {
    Route::get('index', ['uses'=>'IndexController@index']);
    Route::get('login', ['uses'=>'LoginController@login']);
    Route::post('login', ['uses'=>'LoginController@doLogin']);
    Route::get('logout', ['uses'=>'LoginController@logout']);
    Route::post('loginByCard', ['uses'=>'LoginController@doLoginByCard']);
    Route::any('loginPhone', ['uses'=>'LoginController@loginByPhone']);
    Route::get('course', ['uses'=>'SubjectCourse@index']);
    Route::get('course/detail/{id}', ['uses'=>'SubjectCourse@detail']);

    Route::any('noCard', ['uses'=>'NoCardQueryController@index']);
    Route::get('user', ['uses'=>'UserController@index']);
    Route::get('user/helpShangji', ['uses'=>'UserController@helpShangji']);
    Route::get('user/helpShebei', ['uses'=>'UserController@helpShebei']);
    Route::get('user/helpXunlian', ['uses'=>'UserController@helpXunlian']);
    Route::get('user/helpQita', ['uses'=>'UserController@helpQita']);
    Route::post('user/getRemainingTime', ['uses'=>'UserController@getRemainingTime']);

    Route::get('main', ['uses'=>'LoginController@main']);
    Route::get('admin', ['uses'=>'AdminController@index']);
    Route::post('admin/getCardNum', ['uses'=>'AdminController@getCardNum']);
    Route::any('admin/register', ['uses'=>'AdminController@register']);
    Route::any('admin/fillCard', ['uses'=>'AdminController@fillCard']);
    Route::post('admin/delUser', ['uses'=>'AdminController@delUser']);
    Route::any('admin/editUser/{id}', ['uses'=>'AdminController@editUser']);
    Route::any('admin/queryLength', ['uses'=>'AdminController@queryLength']);
    Route::any('admin/repair', ['uses'=>'AdminController@repair']);


    Route::get('admin/statistics', ['uses'=>'AdminStatisticsController@index']);
    Route::any('admin/statistics/userList', ['uses'=>'AdminStatisticsController@userList']);
    Route::any('admin/statistics/subject2List', ['uses'=>'AdminStatisticsController@subject2List']);
    Route::any('admin/statistics/subject3List', ['uses'=>'AdminStatisticsController@subject3List']);

    Route::any('admin/register', ['uses'=>'AdminController@register']);

    //充值相关
    Route::any('recharge', ['uses'=>'RechargeController@index']);//用户充值显示页面
    Route::any('rechQrCode', ['uses'=>'RechargeController@createQrCode']);//用户创建订单
    Route::any('rechStatue', ['uses'=>'RechargeController@rechStatus']);//查询订单状态

    Route::any('rechAdmin', ['uses'=>'RechargeAdminController@index']);//管理员充值显示页面
    Route::any('rechQrCodeAdmin', ['uses'=>'RechargeAdminController@createQrCode']);//管理员创建订单
    Route::any('rechStatueAdmin', ['uses'=>'RechargeAdminController@rechStatus']);//查询订单状态

    Route::any('aliRecharge', ['uses'=>'PayCallbackController@aliRecharge']);//充值回调
    Route::any('wxRecharge', ['uses'=>'PayCallbackController@wxRecharge']);//充值回调
    Route::any('aliRechAdmin', ['uses'=>'PayCallbackController@aliRechAdmin']);//管理员充值回调
    Route::any('wxRechAdmin', ['uses'=>'PayCallbackController@wxRechAdmin']);//管理员充值回调

    
});


//系统后台
Route::group(['prefix'=>'manage','namespace'=>'Manage','domain' => ''], function () {

    Route::get('/',function(){return 'manage';});

    //后台主页
    Route::any('index', ['uses'=>'IndexController@index']);

    //登陆
    Route::get('login', ['uses'=>'LoginController@index']);
    Route::post('login', ['uses'=>'LoginController@login']);
    //退出
    Route::get('logout', ['uses'=>'LoginController@logout']);
    //注册
    Route::get('register', ['uses'=>'LoginController@register']);
    Route::post('register', ['uses'=>'LoginController@doRegister']);

    //菜单管理
    Route::any('menu', ['uses'=>'MenuController@index']);
    Route::any('menu/add', ['uses'=>'MenuController@add']);
    Route::any('menu/edit', ['uses'=>'MenuController@edit']);
    Route::any('menu/del', ['uses'=>'MenuController@del']);

    //用户组
    Route::any('group', ['uses'=>'GroupController@index']);
    Route::any('group/add', ['uses'=>'GroupController@add']);
    Route::any('group/edit', ['uses'=>'GroupController@edit']);
    Route::any('group/setRole', ['uses'=>'GroupController@setRole']);

    //用户管理
    Route::get('user/index', ['uses'=>'UserController@index']);
    Route::get('user/edit', ['uses'=>'UserController@edit']);
    Route::post('user/edit', ['uses'=>'UserController@doEdit']);
    Route::post('user/editStatus', ['uses'=>'UserController@editStatus']);

    //商家管理
    Route::get('company', ['uses'=>'CompanyController@index']);
    Route::get('company/add', ['uses'=>'CompanyController@add']);
    Route::post('company/add', ['uses'=>'CompanyController@store']);
    Route::get('company/edit', ['uses'=>'CompanyController@edit']);
    Route::post('company/edit', ['uses'=>'CompanyController@doEdit']);
    Route::post('company/getCityOption', ['uses'=>'CompanyController@getCityOption']);
    Route::post('company/editStatus', ['uses'=>'CompanyController@editStatus']);

    //设备管理
    Route::get('machine', ['uses'=>'MachineController@index']);
    Route::get('machine/add', ['uses'=>'MachineController@add']);
    Route::post('machine/add', ['uses'=>'MachineController@store']);
    Route::get('machine/edit', ['uses'=>'MachineController@edit']);
    Route::post('machine/edit', ['uses'=>'MachineController@doEdit']);
    Route::post('machine/editStatus', ['uses'=>'MachineController@editStatus']);

    //科目管理
    Route::any('subject/index', ['uses'=>'SubjectController@index']);
    Route::any('subject/add', ['uses'=>'SubjectController@add']);
    Route::any('subject/edit', ['uses'=>'SubjectController@edit']);
    Route::any('subject/del', ['uses'=>'SubjectController@del']);

    //课程管理
    Route::any('course/index', ['uses'=>'CourseController@index']);
    Route::any('course/add', ['uses'=>'CourseController@add']);
    Route::any('course/edit', ['uses'=>'CourseController@edit']);
    Route::any('course/del', ['uses'=>'CourseController@del']);

    //课程建议管理
    Route::get('courseAdvice', ['uses'=>'CourseAdviceController@index']);
    Route::get('courseAdvice/add', ['uses'=>'CourseAdviceController@add']);
    Route::post('courseAdvice/add', ['uses'=>'CourseAdviceController@store']);
    Route::get('courseAdvice/edit', ['uses'=>'CourseAdviceController@edit']);
    Route::post('courseAdvice/edit', ['uses'=>'CourseAdviceController@doEdit']);

    //设备报修
    Route::get('machineBug', ['uses'=>'MachineBugController@index']);

});


