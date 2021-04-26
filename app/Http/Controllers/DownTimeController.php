<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class DownTimeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        if(!Session::has('mnuDowntimeAnalysis'))
        {
            return view('errors.403');
        }

        else {

            return view('layouts.DowntimeAnalysis');


        }

    }

    public function chartDownTime(Request $request){

        $mill = $request->mill;
        $division = $request->division;
        $mach_type = $request->mach_type;
        $mach_id = $request->mach_id;
        $start = $request->start;
        $end = $request->end;

        $where = "where mill_id = '$mill' and Periode between '$start' and '$end'";

        if ($division){
            $where .= " and divisi = '$division'";
        }

        if ($mach_type){
            $where .= " and mach_type = '$mach_type'";
        }

        if ($mach_id){
            $where .= " and mach_id = '$mach_id'";
        }

         $data = DB::connection("sqlsrv2")
                    ->select(DB::raw("select Periode,
                    round(cast((SUM ( full_time )) as FLOAT)/60,2) AS fulltime,
	                round(cast((SUM ( down_time )) as FLOAT)/60,2) AS downtime,
                    round(cast((sum(down_time)/60) as float)/cast((sum(full_time)/60) as float) * 100, 2) as runtime from view_runtime
                    $where
                    group by Periode
                    order by 1"));

        // dd($data);

        return response()->json($data);


    }

    public function chartDownTimeClass(Request $request){

        $mill = $request->mill;
        $division = $request->division;
        $mach_type = $request->mach_type;
        $mach_id = $request->mach_id;
        $periode = $request->periode;
        $txtValue = $request->txtValue;
        $txtPeriode = $request->txtPeriode;

        $where = "where mill_id = '$mill' and Periode = '$txtPeriode' and tr_type='PRD'";

        if ($division){
            $where .= " and Divisi = '$division'";
        }

        if ($mach_type){
            $where .= " and mach_type = '$mach_type'";
        }

        if ($mach_id){
            $where .= " and mach_id = '$mach_id'";
        }

         $data = DB::connection("sqlsrv2")
                    ->select(DB::raw("select Class,
                    round(cast(SUM (DATEDIFF( MINUTE, dt_start, dt_end )) as float)/60,2) as result,
                    round((cast(SUM (DATEDIFF( MINUTE, dt_start, dt_end )) as float)/60) / $txtValue,5) * 100 AS pct_result from view_downtime 
                    $where
                    group by Class order by 1"));

        // dd($data);

        return response()->json($data);


    }

    public function chartDownTimeDetail(Request $request){

        $mill = $request->mill;
        $division = $request->division;
        $mach_type = $request->mach_type;
        $mach_id = $request->mach_id;
        $periode = $request->periode;
        $class= $request->class;

        $where = "where mill_id = '$mill' and tr_type='PRD'";

        if ($division){
            $where .= " and Divisi = '$division'";
        }

        if ($mach_type){
            $where .= " and mach_type = '$mach_type'";
        }

        if ($mach_id){
            $where .= " and mach_id = '$mach_id'";
        }

        if ($periode){
            $where .= " and Periode = '$periode'";
        }

        if ($class){
            $where .= " and Class = '$class'";
        }

         $data = DB::connection("sqlsrv2")
                    ->select(DB::raw("select Class + ' - ' +Detail_Class as Detail , round(cast(SUM (DATEDIFF( MINUTE, dt_start, dt_end )) as float) / 60,2) AS result from view_downtime $where
                    group by Class,Detail_Class
                    order by 1,2"));

        // dd($data);

        return response()->json($data);


    }

    //##Daily###

    public function chartDownTimeDaily(Request $request){

        $mill = $request->mill;
        $division = $request->division;
        $mach_type = $request->mach_type;
        $mach_id = $request->mach_id;
        // $start = $request->start;
        $periode = $request->periode;

        $where = "where mill_id = '$mill'";

        if ($division){
            $where .= " and divisi = '$division'";
        }

        if ($mach_type){
            $where .= " and mach_type = '$mach_type'";
        }

        if ($mach_id){
            $where .= " and mach_id = '$mach_id'";
        }

        if ($periode){
            $where .= " and Periode = '$periode'";
        }

         $data = DB::connection("sqlsrv2")
                    ->select(DB::raw("select FORMAT(tanggal, 'yyyyMMdd') as dt_val, FORMAT(tanggal, 'dd MMM yyyy') as day,
                    round(cast((SUM ( full_time )) as FLOAT)/60,2) AS fulltime,
	                round(cast((SUM ( down_time )) as FLOAT)/60,2) AS downtime,
                    round(cast((sum(down_time)/60) as float)/cast((sum(full_time)/60) as float) * 100, 2) as runtime from view_runtime
                    $where
                    group by tanggal
                    order by 1"));

        // dd($data);

        //echo $where;

        return response()->json($data);


    }

    public function chartDownTimeClassDaily(Request $request){

        $mill = $request->mill;
        $division = $request->division;
        $mach_type = $request->mach_type;
        $mach_id = $request->mach_id;
        $txtValue = $request->txtValue;
        $txtDate = $request->txtDate;

        $where = "where MILL_id = '$mill' and tr_type='PRD'";

        if ($division){
            $where .= " and Divisi = '$division'";
        }

        if ($mach_type){
            $where .= " and mach_type = '$mach_type'";
        }

        if ($mach_id){
            $where .= " and mach_id = '$mach_id'";
        }

        if ($txtDate){
            $where .= " and FORMAT(tr_date, 'dd MMM yyyy') = '$txtDate'";
        }

         $data = DB::connection("sqlsrv2")
                    ->select(DB::raw("select Class,
                    round(cast(SUM (DATEDIFF( MINUTE, dt_start, dt_end )) as float)/60,2) as result,
                    round((cast(SUM (DATEDIFF( MINUTE, dt_start, dt_end )) as float)/60) / $txtValue,5) * 100 AS pct_result from view_downtime 
                    $where
                    group by Class order by 1"));

        //dd($data);

        return response()->json($data);


    }

    public function chartDownTimeDetailDaily(Request $request){

        $mill = $request->mill;
        $division = $request->division;
        $mach_type = $request->mach_type;
        $mach_id = $request->mach_id;
        $txtDate = $request->txtDate;
        $class= $request->class;

        $where = "where mill_id= '$mill' and tr_type='PRD'";

        if ($division){
            $where .= " and Divisi = '$division'";
        }

        if ($mach_type){
            $where .= " and mach_type = '$mach_type'";
        }

        if ($mach_id){
            $where .= " and mach_id = '$mach_id'";
        }

        if ($txtDate){
            $where .= " and FORMAT(tr_date, 'dd MMM yyyy') = '$txtDate'";
        }

        if ($class){
            $where .= " and Class = '$class'";
        }


         $data = DB::connection("sqlsrv2")
                    ->select(DB::raw("select Class + ' - ' +Detail_Class as Detail , round(cast(SUM (DATEDIFF( MINUTE, dt_start, dt_end )) as float) / 60,2) AS result from view_downtime $where group by Class,Detail_Class
                    order by 1,2"));

        // dd($data);

        return response()->json($data);


    }





}
