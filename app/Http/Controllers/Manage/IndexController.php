<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class IndexController extends BaseController
{

	public function index(Request $request)
	{
	    
		return view('manage.index.index');
	}


}
