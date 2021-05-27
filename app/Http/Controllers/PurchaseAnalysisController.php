<?php

namespace App\Http\Controllers;

use DB;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class PurchaseAnalysisController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        if(!Session::has('mnuPerformanceAnalysis'))
        {
            return view('errors.403');
        }

        else {

            return view('layouts.PurchaseAnalysis');

        }

    }

    public function chartPurchaseAnalysis(Request $request) {

        $where = "where 1=1";
        $txtOfficeID = $request->txtOfficeID;
        if ($txtOfficeID) {
            $where .= " and dept_id = '$txtOfficeID'";
        }
        $txtStartDate = $request->txtStartDate;
        $txtEndDate = $request->txtEndDate;
        if ($txtStartDate && $txtEndDate) {
            $where .= " and period between '$txtStartDate' and '$txtEndDate'";
        }
        if ($txtStartDate && !$txtEndDate) {
            $where .= " and period >= '$txtStartDate'";
        }
        if (!$txtStartDate && $txtEndDate) {
            $where .= " and period <= '$txtEndDate'";
        }
        $txtUserID = $request->txtUserID;
        if ($txtUserID) {
            $where .= " and user_id = '$txtUserID'";
        }
        $txtStatus = $request->txtStatus;
        if ($txtStatus != "All") {
            $where .= " and stat = '$txtStatus'";
        }
        $txtRaw = $request->txtRaw;
        if ($txtRaw == 'Rawmat') {
            $where .= " and type_pr = 'RAW'";
        }
        if ($txtRaw == 'General') {
            $where .= " and type_pr = 'ALL'";
        }

        $result = DB::connection("sqlsrv2")
                    ->select(DB::raw("With t_step1 as 
                    (select period, round(avg(NULLIF(cast(step1 as float), -3000)), 2) as step1,
                    count(NULLIF(step1, -3000)) as count_step1 from
                    (SELECT period,
                    round(avg(NULLIF(cast(step1 as float), -3000)), 2) as step1,
                    count(NULLIF(step1, -3000)) as count_step1
                    FROM 
                    (SELECT period, pru_id, dt_pru, dt_aprv,
                    case 
                        when dt_aprv = '1900-01-01 00:00:00.000' then -3000
                        else DATEDIFF( DAY, dt_pru, dt_aprv )
                        end as step1
                    FROM view_pr_performa $where) as x
                    group by period, pru_id) as y
                    group by period)
                    
                    , t_step2 as 
                    (select period, round(avg(NULLIF(cast(step2 as float), -3000)), 2) as step2,
                    count(NULLIF(step2, -3000)) as count_step2 from
                    (SELECT period, pru_id, po_id, dt_aprv, dt_po,
                    round(avg(NULLIF(cast(step2 as float), -3000)), 2) as step2,
                    count(NULLIF(step2, -3000)) as count_step2
                    FROM 
                    (SELECT period, pru_id, po_id, dt_aprv, dt_po,  
                    case 
                        when dt_po = '1900-01-01 00:00:00.000' then -3000
                        else DATEDIFF( DAY, dt_aprv, dt_po )
                        end as step2
                    FROM view_pr_performa $where) as x
                    group by period, pru_id, po_id, dt_aprv, dt_po) as y
                    group by period)
                    
                    , t_step3 as 
                    (select period, round(avg(NULLIF(cast(step3 as float), -3000)), 2) as step3,
                    count(NULLIF(step3, -3000)) as count_step3 from
                    (SELECT period, pru_id, pru_item, po_id, po_item, rcv_id, dt_po, dt_rcv,
                    round(avg(NULLIF(cast(step3 as float), -3000)), 2) as step3,
                    count(NULLIF(step3, -3000)) as count_step3
                    FROM 
                    (SELECT period, pru_id, pru_item, po_id, po_item, rcv_id, dt_po, dt_rcv,
                    case 
                        when dt_rcv = '1900-01-01 00:00:00.000' then -3000
                        else DATEDIFF( DAY, dt_po, dt_rcv )
                        end as step3
                    FROM view_pr_performa $where) as x
                    group by period, pru_id, po_id, pru_item, po_item, rcv_id, dt_po, dt_rcv) as y
                    group by period)
                    
                    , t_step4 as 
                    (select period, round(avg(NULLIF(cast(step4 as float), -3000)), 2) as step4,
                    count(NULLIF(step4, -3000)) as count_step4 from
                    (SELECT period, pru_id, pru_item, po_id, po_item, rcv_id, dt_po, dt_rcv,
                    round(avg(NULLIF(cast(step4 as float), -3000)), 2) as step4,
                    count(NULLIF(step4, -3000)) as count_step4
                    FROM 
                    (SELECT period, pru_id, pru_item, po_id, po_item, rcv_id, dt_po, dt_rcv,
                    case 
                        when dt_rcv = '1900-01-01 00:00:00.000' then -3000
                        else DATEDIFF( DAY, dt_pru, dt_rcv )
                        end as step4
                    FROM view_pr_performa $where) as x
                    group by period, pru_id, po_id, pru_item, po_item, rcv_id, dt_po, dt_rcv) as y
                    group by period)
                    
                    select t_step1.period
                    , t_step1.step1
                    , t_step1.count_step1
                    , t_step2.step2
                    , t_step2.count_step2
                    , t_step3.step3
                    , t_step3.count_step3
                    , t_step4.step4
                    , t_step4.count_step4
                    from t_step1 join t_step2 
                    on t_step1.period = t_step2.period
                    join t_step3 
                    on t_step1.period = t_step3.period
                    join t_step4 
                    on t_step1.period = t_step4.period
                    order by 1 asc"));

        return response()->json(['result' => $result]);
  

    }

    public function getPurchaseAnalysisDetail(Request $request) {

        $where = "where 1=1";
        $txtStep = $request->txtStep;
        $txtParam = $request->txtParam;
        if ($txtParam) {
            $where .= " and period = '$txtParam'";
        }
        $txtOfficeID = $request->txtOfficeID;
        if ($txtOfficeID) {
            $where .= " and dept_id = '$txtOfficeID'";
        }
        $txtUserID = $request->txtUserID;
        if ($txtUserID) {
            $where .= " and user_id = '$txtUserID'";
        }
        $txtStatus = $request->txtStatus;
        if ($txtStatus != "All") {
            $where .= " and stat = '$txtStatus'";
        }
        $txtRaw = $request->txtRaw;
        if ($txtRaw == 'Rawmat') {
            $where .= " and type_pr = 'RAW'";
        }
        if ($txtRaw == 'General') {
            $where .= " and type_pr = 'ALL'";
        }

        if ($txtStep == 'step1') {

            $result = DB::connection("sqlsrv2")
                        ->select(DB::raw("select period, LTRIM(RTRIM(pru_id)) as pru_id, FORMAT(dt_pru, 'dd MMM yyyy') as dt_pru, FORMAT(dt_aprv, 'dd MMM yyyy') as dt_aprv, concat(DayInterval, ' days') as DayInterval from (
                            SELECT period, pru_id, dt_pru, dt_aprv,
                            case 
                                when dt_aprv = '1900-01-01 00:00:00.000' then -3000
                                else DATEDIFF( DAY, dt_pru, dt_aprv )
                                end as DayInterval
                            FROM view_pr_performa $where) as x 
                            where DayInterval <> -3000
                            group by period, pru_id, dt_pru, dt_aprv, DayInterval
                            order by period, pru_id asc
                            "));

            // dd($result);

            return \DataTables::of($result)
            ->make(true);

        }

        if ($txtStep == 'step2') {


            $result = DB::connection("sqlsrv2")
                        ->select(DB::raw("select period, LTRIM(RTRIM(pru_id)) as pru_id, LTRIM(RTRIM(po_id)) as po_id, pru_item, LTRIM(RTRIM(descr)) as descr, FORMAT(dt_aprv, 'dd MMM yyyy') as dt_aprv, FORMAT(dt_po, 'dd MMM yyyy') as dt_po, concat(DayInterval, ' days') as DayInterval from (
                            SELECT period, pru_id, po_id, pru_item, descr, dt_aprv, dt_po,
                            case 
                                when dt_po = '1900-01-01 00:00:00.000' then -3000
                                else DATEDIFF( DAY, dt_aprv, dt_po )
                                end as DayInterval
                            FROM view_pr_performa $where ) as x 
                            where DayInterval <> -3000
                            group by period, pru_id, po_id, pru_item, descr,dt_aprv, dt_po, DayInterval
                            order by period, pru_id, pru_item asc
                            "));

             // dd($result);

            return \DataTables::of($result)
            ->make(true);

        }

        if ($txtStep == 'step3') {

            $result = DB::connection("sqlsrv2")
                        ->select(DB::raw("select period, LTRIM(RTRIM(pru_id)) as pru_id, pru_item, LTRIM(RTRIM(descr)) as descr, LTRIM(RTRIM(po_id)) as po_id, po_item, LTRIM(RTRIM(rcv_id)) as rcv_id, FORMAT(dt_po, 'dd MMM yyyy') as dt_po, FORMAT(dt_rcv, 'dd MMM yyyy') as dt_rcv, concat(DayInterval, ' days') as DayInterval from (
                            SELECT period, pru_id, po_id, pru_item, descr, po_item, rcv_id, dt_po, dt_rcv, 
                            case 
                                when dt_rcv = '1900-01-01 00:00:00.000' then -3000
                                else DATEDIFF( DAY, dt_po, dt_rcv )
                                end as DayInterval
                            FROM view_pr_performa $where) as x
                            where DayInterval <> -3000
                            group by period, pru_id, po_id, pru_item, descr, po_item, rcv_id, dt_po, dt_rcv, DayInterval
                            order by pru_id, pru_item, po_item
                            "));

             // dd($result);

            return \DataTables::of($result)
            ->make(true);
        }

        if ($txtStep == 'step4') {

            $result = DB::connection("sqlsrv2")
                        ->select(DB::raw("select period, LTRIM(RTRIM(pru_id)) as pru_id, pru_item, LTRIM(RTRIM(descr)) as descr, LTRIM(RTRIM(po_id)) as po_id, po_item, LTRIM(RTRIM(rcv_id)) as rcv_id, FORMAT(dt_pru, 'dd MMM yyyy') as dt_pru, FORMAT(dt_rcv, 'dd MMM yyyy') as dt_rcv, concat(DayInterval, ' days') as DayInterval from (
                            SELECT period, pru_id, po_id, pru_item, descr, po_item, rcv_id, dt_pru, dt_rcv, 
                            case 
                                when dt_rcv = '1900-01-01 00:00:00.000' then -3000
                                else DATEDIFF( DAY, dt_pru, dt_rcv )
                                end as DayInterval
                            FROM view_pr_performa $where) as x
                            where DayInterval <> -3000
                            group by period, pru_id, po_id, pru_item, descr, po_item, rcv_id, dt_pru, dt_rcv, DayInterval
                            order by pru_id, pru_item, po_item
                            "));

             // dd($result);

            return \DataTables::of($result)
            ->make(true);
        }

    }
}
