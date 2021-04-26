<?php

namespace App\Http\Controllers;

use DB;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class QualityPerformanceController extends Controller
{
    //
    public function __construct(){
        
        $this->middleware('auth');
    }

    public function index(){

        if(!Session::has('mnuQualityPerformance'))
        {
            return view('errors.403');
        }

        else {

            return view('layouts.QualityPerformance');

        }

    }

    public function chartQPRatio(Request $request){

        $txtMill = $request->txtMill;
        $txtDivision = $request->txtDivision;
        $txtQuality = $request->txtQuality;
        $txtMachType = $request->txtMachType;
        $txtMachID = $request->txtMachID;
        $txtStartDate = $request->txtStartDate;
        $txtEndDate =  $request->txtEndDate;
        $where = "";
        $where.= "1=1";

        if ($txtMill) {
            $where.= " and mill_id = '$txtMill'";
        }

        if ($txtDivision) {
            $where.= " and divisi = '$txtDivision'";
        }

        if ($txtQuality) {
            $where.= " and quality = '$txtQuality'";
        }

        if ($txtMachType) {
            $where.= " and mach_type = '$txtMachType'";
        }

        if ($txtMachID) {
            $where.= " and mach_id = '$txtMachID'";
        }

        if ($txtStartDate && !$txtEndDate) {

            $where.= " and LEFT(CONVERT(varchar, tanggal, 112), 6) >= '$txtStartDate'";
        }

        if (!$txtStartDate && $txtEndDate) {

            $where.= " and LEFT(CONVERT(varchar, tanggal, 112), 6) <= '$txtEndDate'";
        }

        if ($txtStartDate && $txtEndDate) {

            $where.= " and LEFT(CONVERT(varchar, tanggal, 112), 6) between '$txtStartDate' and '$txtEndDate'";
        }
        

        try{

            $data = DB::connection("sqlsrv2")
                        ->select(DB::raw("select Periode, sum(PRIME) as prime, sum(PRIME)/sum(total)*100 as pct_prime, sum(NONPRIME) as nonprime, 
                        sum(NONPRIME)/sum(total)*100 as pct_nonprime,
                        sum(SCRAP) as scrap, sum(SCRAP)/sum(total)*100 as pct_scrap,
                        sum(total) as total from (
                        select mill_id , LEFT(CONVERT(varchar, tanggal, 112), 6) AS Periode,
                        case when quality = 'A' then berat else 0 end as PRIME,
                        case when quality <> 'A' and quality <> 'Z' then berat else 0 end as NONPRIME,
                        case when quality = 'Z' then berat else 0 end as SCRAP, berat as total
                        from view_prod_ratio_quality where $where )x 
                        group by Periode
                        order by 1"));

            
            return response()->json($data);
        }
        catch(QueryException $ex){
            $error = $ex->getMessage();
            return response()->json(['error' => $error]);
        }




    }

    public function chartQPRatioPctPeriodic(Request $request){

        $txtMill = $request->txtMill;
        $txtDivision = $request->txtDivision;
        $txtQuality = $request->txtQuality;
        $txtMachType = $request->txtMachType;
        $txtMachID = $request->txtMachID;
        $txtPeriode = $request->txtPeriode;
        $where = "";
        $where.= "LEFT(CONVERT(varchar, tanggal, 112), 6) = '$txtPeriode'";

        if ($txtMill) {
            $where.= " and mill_id = '$txtMill'";
        }

        if ($txtDivision) {
            $where.= " and divisi = '$txtDivision'";
        }

        if ($txtQuality) {
            $where.= " and quality = '$txtQuality'";
        }

        if ($txtMachType) {
            $where.= " and mach_type = '$txtMachType'";
        }

        if ($txtMachID) {
            $where.= " and mach_id = '$txtMachID'";
        }
        

        try{

            $data = DB::connection("sqlsrv2")
                        ->select(DB::raw("select sum(PRIME) as prime, sum(PRIME)/sum(total)*100 as pct_prime, sum(NONPRIME) as nonprime, 
                        sum(NONPRIME)/sum(total)*100 as pct_nonprime,
                        sum(SCRAP) as scrap, sum(SCRAP)/sum(total)*100 as pct_scrap,
                        sum(total) as total from (
                        select mill_id , LEFT(CONVERT(varchar, tanggal, 112), 6) AS Periode,
                        case when quality = 'A' then berat else 0 end as PRIME,
                        case when quality <> 'A' and quality<>'Z' then berat else 0 end as NONPRIME,
                        case when quality = 'Z' then berat else 0 end as SCRAP, berat as total
                        from view_prod_ratio_quality where $where )x 
                        order by 1"));

            
            return response()->json($data);
        }
        catch(QueryException $ex){
            $error = $ex->getMessage();
            return response()->json(['error' => $error]);
        }




    }

    public function chartQPRatioDaily(Request $request){

        $txtMill = $request->txtMill;
        $txtDivision = $request->txtDivision;
        $txtQuality = $request->txtQuality;
        $txtMachType = $request->txtMachType;
        $txtMachID = $request->txtMachID;
        $txtPeriode = $request->txtPeriode;
        $where = "";
        $where.= "LEFT(CONVERT(varchar, tanggal, 112), 6) = '$txtPeriode'";

        if ($txtMill) {
            $where.= " and mill_id = '$txtMill'";
        }

        if ($txtDivision) {
            $where.= " and divisi = '$txtDivision'";
        }

        if ($txtQuality) {
            $where.= " and quality = '$txtQuality'";
        }

        if ($txtMachType) {
            $where.= " and mach_type = '$txtMachType'";
        }

        if ($txtMachID) {
            $where.= " and mach_id = '$txtMachID'";
        }

        try{

            $data = DB::connection("sqlsrv2")
                        ->select(DB::raw("select Periode, tanggal, f_tanggal, sum(PRIME) as prime, sum(PRIME)/sum(total)*100 as pct_prime, sum(NONPRIME) as nonprime, 
                        sum(NONPRIME)/sum(total)*100 as pct_nonprime,
                        sum(SCRAP) as scrap, sum(SCRAP)/sum(total)*100 as pct_scrap,
                        sum(total) as total from (
                        select mill_id , LEFT(CONVERT(varchar, tanggal, 112), 6) AS Periode, LEFT(CONVERT(varchar, tanggal, 112), 8) AS tanggal,
                        FORMAT(tanggal, 'dd MMM yyyy') as f_tanggal,
                        case when quality = 'A' then berat else 0 end as PRIME,
                        case when quality <> 'A' and quality <> 'Z' then berat else 0 end as NONPRIME,
                        case when quality = 'Z' then berat else 0 end as SCRAP, berat as total
                        from view_prod_ratio_quality where $where )x 
                        group by Periode, tanggal, f_tanggal
                        order by f_tanggal asc"));

            
            return response()->json($data);
        }
        catch(QueryException $ex){
            $error = $ex->getMessage();
            return response()->json(['error' => $error]);
        }




    }

    public function chartQPRatioPctDaily(Request $request){

        $txtMill = $request->txtMill;
        $txtDivision = $request->txtDivision;
        $txtQuality = $request->txtQuality;
        $txtMachType = $request->txtMachType;
        $txtMachID = $request->txtMachID;
        $txtTanggal = $request->txtTanggal;
        $where = "";
        $where.= "LEFT(CONVERT(varchar, tanggal, 112), 8) = '$txtTanggal'";

        if ($txtMill) {
            $where.= " and mill_id = '$txtMill'";
        }

        if ($txtDivision) {
            $where.= " and divisi = '$txtDivision'";
        }

        if ($txtQuality) {
            $where.= " and quality = '$txtQuality'";
        }

        if ($txtMachType) {
            $where.= " and mach_type = '$txtMachType'";
        }

        if ($txtMachID) {
            $where.= " and mach_id = '$txtMachID'";
        }
        

        try{

            $data = DB::connection("sqlsrv2")
                        ->select(DB::raw("select sum(PRIME) as prime, sum(PRIME)/sum(total)*100 as pct_prime, sum(NONPRIME) as nonprime, 
                        sum(NONPRIME)/sum(total)*100 as pct_nonprime,
                        sum(SCRAP) as scrap, sum(SCRAP)/sum(total)*100 as pct_scrap,
                        sum(total) as total from (
                        select mill_id , LEFT(CONVERT(varchar, tanggal, 112), 6) AS Periode,
                        case when quality = 'A' then berat else 0 end as PRIME,
                        case when quality <> 'A' and quality<>'Z' then berat else 0 end as NONPRIME,
                        case when quality = 'Z' then berat else 0 end as SCRAP, berat as total
                        from view_prod_ratio_quality where $where )x 
                        order by 1"));

            
            return response()->json($data);
        }
        catch(QueryException $ex){
            $error = $ex->getMessage();
            return response()->json(['error' => $error]);
        }




    }


        

}
