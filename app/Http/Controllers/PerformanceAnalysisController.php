<?php

namespace App\Http\Controllers;

use DB;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class PerformanceAnalysisController extends Controller
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

            return view('layouts.PerformanceAnalysis');

        }

    }

    public function chartPerformanceAnalysis(Request $request) {

        $mill = '';
        $periode = '';
        $txtMill = $request->txtMill;
        $txtSP = $request->txtSP;
        $txtItemNum = $request->txtItemNum;
        $txtStartDate = $request->txtStartDate;
        $txtEndDate = $request->txtEndDate;
        $where = "where Periode <> '190001'";

        if ($txtMill){

            $where .= " and mill_id = '$txtMill'";

        }

        if ($txtSP){
            $where .= " and CustomerOrderNo = '$txtSP'";
        }

        if ($txtItemNum){
            $where .= " and item_num = '$txtItemNum'";
        }

        if ($txtStartDate && !$txtEndDate) {

            $where .= " and Periode >= '$txtStartDate'";
        }

        if (!$txtStartDate && $txtEndDate) {

            $where .= " and Periode <= '$txtEndDate'";
        }

        if ($txtStartDate && $txtEndDate) {

            $where .= " and Periode between '$txtStartDate' and '$txtEndDate'";
            
        }

       

            $result = DB::connection("sqlsrv2")
                        ->select(DB::raw("
                        SELECT xx.mill_id,xx.Periode,
                        CONVERT(DECIMAL(10,2), CONVERT(DECIMAL, SUM(NULLIF(xx.x,- 3000)))  / CONVERT(DECIMAL, COUNT(NULLIF(xx.x,- 3000)))) as xx,
                        CONVERT(DECIMAL(10,2), CONVERT(DECIMAL, SUM(NULLIF(xx.y,- 3000)))  / CONVERT(DECIMAL, COUNT(NULLIF(xx.y,- 3000)))) as yy,
                        CONVERT(DECIMAL(10,2), CONVERT(DECIMAL, SUM(NULLIF(xx.z,- 3000)))  / CONVERT(DECIMAL, COUNT(NULLIF(xx.z,- 3000)))) as zz
                        FROM
                        (
                        SELECT
                                t1.*,
                                t1.stepA AS x,
                        CASE  
                                WHEN
                                t1.stepB = -3000 OR t1.stepA = -3000 THEN -3000 
                                ELSE t1.stepB - t1.stepA 
                        END AS y,
                        CASE        
                                WHEN t1.stepC = -3000 OR t1.stepB = -3000 THEN -3000 
                                ELSE t1.stepC - t1.stepB 
                        END AS z 
                                FROM
                                        (
                                        SELECT mill_id ,Periode, dt_rcv, dtPlan, dtProd, dtShip, CustomerOrderNo, item_num, NamaBarang,
                                        CASE 
                                                WHEN qty_order <= qty_plan THEN DATEDIFF( DAY, dt_rcv, dtPlan ) ELSE -3000 
                                                END AS stepA,
                                        CASE
                                                        
                                                WHEN qty_order > qty_plan THEN -3000 
                                                WHEN qty_order <= qty_prod THEN DATEDIFF( DAY, dt_rcv, dtProd ) 
                                                WHEN qty_order > qty_prod AND qty_order <= qty_Ship THEN DATEDIFF( DAY, dt_rcv, dtPlan ) 
                                                ELSE -3000 
                                        END AS stepB,
                                        CASE
                                                                
                                                WHEN qty_order > qty_plan THEN -3000 
                                                WHEN qty_order <= qty_Ship THEN DATEDIFF( DAY, dt_rcv, dtShip ) ELSE -3000 
                                        END AS stepC 
                                        FROM View_wh_perform $where) t1 
                                        ) xx 
                                        GROUP BY xx.mill_id, xx.Periode 
                                        ORDER BY xx.Periode"));
            foreach ($result as $results) {
                $mill = $results->mill_id;
                $periode = $results->Periode;
            }

            // dd($result);
    
           return response()->json(['result' => $result, 'mill' => $mill, 'periode' => $periode]);
    

        

    }

    public function chartPerformanceAnalysisDailySum(Request $request) {

        $mill = '';
        $txtMill = $request->txtMill;
        $txtSP = $request->txtSP;
        $txtItemNum = $request->txtItemNum;
        $txtPeriode = $request->txtPeriode;
   
        $where = "where Periode = '$txtPeriode'";

        if ($txtMill){
            $where .= " and mill_id = '$txtMill'";
        }

        if ($txtSP){
            $where .= " and CustomerOrderNo = '$txtSP'";
        }

        if ($txtItemNum){
            $where .= " and item_num = '$txtItemNum'";
        }

        $result = DB::connection("sqlsrv2")
                    ->select(DB::raw("
                            SELECT
                            xx.mill_id, FORMAT(xx.dt_rcv, 'dd MMM yyyy') as dt_rcv,
                            CONVERT(DECIMAL(10,2), CONVERT(DECIMAL, SUM(NULLIF(xx.x,- 3000)))  / CONVERT(DECIMAL, COUNT(NULLIF(xx.x,- 3000)))) as xx,
                            CONVERT(DECIMAL(10,2), CONVERT(DECIMAL, SUM(NULLIF(xx.y,- 3000)))  / CONVERT(DECIMAL, COUNT(NULLIF(xx.y,- 3000)))) as yy,
                            CONVERT(DECIMAL(10,2), CONVERT(DECIMAL, SUM(NULLIF(xx.z,- 3000)))  / CONVERT(DECIMAL, COUNT(NULLIF(xx.z,- 3000)))) as zz
                            FROM
                                (
                                SELECT
                                    t1.*, t1.stepA AS x,
                                CASE
                                        WHEN t1.stepB = -3000 OR t1.stepA = -3000 THEN -3000 
                                        ELSE t1.stepB - t1.stepA 
                                END AS y,
                                CASE			
                                        WHEN t1.stepC = -3000 OR t1.stepB = -3000 THEN -3000 
                                        ELSE t1.stepC - t1.stepB 
                                END AS z 
                                FROM
                                        (
                                        SELECT mill_id, Periode, dt_rcv, dtPlan, dtProd, dtShip, CustomerOrderNo, item_num, NamaBarang,
                                            CASE
                                                    WHEN qty_order <= qty_plan THEN DATEDIFF( DAY, dt_rcv, dtPlan ) 
                                                    ELSE -3000 
                                            END AS stepA,
                                            CASE		
                                                    WHEN qty_order > qty_plan THEN -3000 
                                                    WHEN qty_order <= qty_prod THEN DATEDIFF( DAY, dt_rcv, dtProd ) 
                                                    WHEN qty_order > qty_prod AND qty_order <= qty_Ship THEN DATEDIFF( DAY, dt_rcv, dtPlan ) 
                                                    ELSE -3000 
                                            END AS stepB,
                                            CASE			
                                                    WHEN qty_order > qty_plan THEN -3000 
                                                    WHEN qty_order <= qty_Ship THEN DATEDIFF( DAY, dt_rcv, dtShip ) 
                                                    ELSE -3000 
                                                END AS stepC 
                                            FROM View_wh_perform $where
                                        ) t1 
                                            ) xx 
                                                GROUP BY xx.mill_id, FORMAT(xx.dt_rcv, 'dd MMM yyyy')
                                                ORDER BY FORMAT(xx.dt_rcv, 'dd MMM yyyy')"));
            
            foreach ($result as $results) {
                $mill = $results->mill_id;
            }

            // dd($result);
    
           return response()->json(['result' => $result, 'mill' => $mill]);
    

        

    }

    public function detailPerformanceAnalysisDaily(Request $request) {

        $txtMill = $request->txtMill;
        $txtSP = $request->txtSP;
        $txtItemNum = $request->txtItemNum;
        $txtTanggal = $request->txtTanggal;

        $where = "where FORMAT(dt_rcv, 'dd MMM yyyy') = '$txtTanggal'";

        if ($txtMill){
            $where .= " and mill_id = '$txtMill'";
        }

        if ($txtSP){
            $where .= " and CustomerOrderNo = '$txtSP'";
        }

        if ($txtItemNum){
            $where .= " and item_num = '$txtItemNum'";
        }

        $result = DB::connection("sqlsrv2")
                    ->select(DB::raw("
                    SELECT
                    t1.mill_id,  FORMAT(t1.dt_rcv, 'dd MMM yyyy') as dt_rcv, FORMAT(t1.dtPlan, 'dd MMM yyyy') as dtPlan,
                    FORMAT(t1.dtProd, 'dd MMM yyyy') as dtProd, FORMAT(t1.dtShip, 'dd MMM yyyy') as dtShip, t1.CustomerOrderNo, t1.item_num, t1.NamaBarang, t1.stepA AS x,
                    CASE
                            WHEN t1.stepB = -3000 OR t1.stepA = -3000 THEN -3000 
                            ELSE t1.stepB - t1.stepA 
                    END AS y,
                    CASE			
                            WHEN t1.stepC = -3000 OR t1.stepB = -3000 THEN -3000 
                            ELSE t1.stepC - t1.stepB 
                    END AS z 
                        FROM
                            (
                                SELECT mill_id, dt_rcv, dtPlan, dtProd, dtShip, CustomerOrderNo, item_num, NamaBarang,
                                CASE
                                        WHEN qty_order <= qty_plan THEN DATEDIFF( DAY, dt_rcv, dtPlan ) 
                                        ELSE -3000 
                                END AS stepA,
                                CASE		
                                        WHEN qty_order > qty_plan THEN -3000 
                                        WHEN qty_order <= qty_prod THEN DATEDIFF( DAY, dt_rcv, dtProd ) 
                                        WHEN qty_order > qty_prod AND qty_order <= qty_Ship THEN DATEDIFF( DAY, dt_rcv, dtPlan ) 
                                        ELSE -3000 
                                END AS stepB,
                                CASE			
                                        WHEN qty_order > qty_plan THEN -3000 
                                        WHEN qty_order <= qty_Ship THEN DATEDIFF( DAY, dt_rcv, dtShip ) 
                                        ELSE -3000 
                                    END AS stepC 
                                FROM View_wh_perform $where) t1 
                                order by t1.CustomerOrderNo,  t1.item_num"));
            
        return \DataTables::of($result)
        ->editColumn('x', function ($data) {
            if ($data->x == -3000) return 'N/A';
            return $data->x;
        })
        ->editColumn('y', function ($data) {
            if ($data->y == -3000) return 'N/A';
            return $data->y;
        })
        ->editColumn('z', function ($data) {
            if ($data->z == -3000) return 'N/A';
            return $data->z;
        })
        ->rawColumns(['x', 'y', 'z'])
        ->make(true);


    }


}
