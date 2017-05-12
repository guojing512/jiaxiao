<?php

namespace App\Http\Controllers\Api;

use App\Http\Models\DataMachineRun;
use App\Http\Models\DataMachineRunLog;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class DataMachineRunLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setRunLog()
    {
        $dataMachineRunLog = new DataMachineRunLog();
        $return_arr = $dataMachineRunLog->setRunLog();
        return response()->json($return_arr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('api.index');
    }
}
