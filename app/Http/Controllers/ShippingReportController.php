<?php

namespace App\Http\Controllers;

use DB;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ShippingReportController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        if(!Session::has('mnuShippingReport'))
        {
            return view('errors.403');
        }

        else {

            return view('layouts.ShippingReport');


        }

    }

    public function chartShippingReport(Request $request){

        $txtMill = $request->txtMill;
        $txtStartDate = $request->txtStartDate;
        $txtEndDate = $request->txtEndDate;

        $where = "where periode between '$txtStartDate' and '$txtEndDate'";

        if ($txtMill) {
            $where .= " and mill_id = '$txtMill'";
        }

         $data = DB::connection("sqlsrv2")
                    ->select(DB::raw("select periode, sum(count_deliv) as count_deliv, sum(wgt_ship)/1000 as wgt_ship from dashboard_deliv_sum $where group by periode order by periode asc"));

        // dd($data);

        // echo $where;

        return response()->json($data);


    }

    public function chartShippingReportbyMill(Request $request){

        $txtMill = $request->txtMill;
        $txtPeriode = $request->txtPeriode;

        $where = "where periode = '$txtPeriode'";

        if ($txtMill) {
            $where .= " and mill_id = '$txtMill'";
        }

         $data = DB::connection("sqlsrv2")
                    ->select(DB::raw("select mill_id, periode, sum(wgt_ship)/1000 as wgt_ship from dashboard_deliv_sum $where group by mill_id, periode order by mill_id asc"));

        // dd($data);

        // echo $where;

        return response()->json($data);


    }

    public function chartShippingReportbyCust(Request $request){

        $txtMill = $request->txtMill;
        $txtPeriode = $request->txtPeriode;

        $where = "where periode = '$txtPeriode'";

        if ($txtMill) {
            $where .= " and mill_id = '$txtMill'";
        }

         $data = DB::connection("sqlsrv2")
                    ->select(DB::raw("select customerid, NamaCustomer, periode, sum(wgt_ship)/1000 as wgt_ship from dashboard_deliv_sum $where group by customerid, NamaCustomer, periode"));

        // dd($data);

        // echo $where;

        return response()->json($data);


    }

}
