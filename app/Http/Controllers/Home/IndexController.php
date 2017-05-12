<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Common\Extend\Alipay\Alipay;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
	public function index(Request $request)
	{
	    return response()->view('home.index.index');
	}
}
