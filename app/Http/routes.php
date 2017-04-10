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

Route::get('/', function () {
    return view('welcome');
});
//验证码
Route::get('captcha', 'KitController@captcha');

Route::any('test', ['uses'=>'TestController@index']);

//api
Route::group(['prefix'=>'','namespace'=>'Api','domain' => 'api.jiaxiao.com'], function () {
    Route::post('setRunLog', ['uses'=>'DataMachineRunLogController@setRunLog']);
    Route::get('index', ['uses'=>'DataMachineRunLogController@index']);
});

//前台
Route::group(['prefix'=>'','namespace'=>'Home','domain' => 'qt.jiaxiao.com'], function () {
    Route::any('index', ['uses'=>'IndexController@index']);
});

//系统后台
Route::group(['prefix'=>'','namespace'=>'Manage','domain' => 'mp.jiaxiao.com'], function () {
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


