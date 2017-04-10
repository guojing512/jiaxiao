<?php

namespace App\Http\Controllers;

use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class KitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function captcha()
    {
        $builder = new CaptchaBuilder();
        $builder->build($width=100,$height=40,$font=null);
        $phrase = $builder->getPhrase();

        Session::flash('milkcaptcha',$phrase);
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-Type: image/jpeg');
        $builder->output();
    }

}
