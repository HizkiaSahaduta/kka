<?php

namespace App\Http\Controllers;

use DB;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;


class OrderAnalysisController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        if(!Session::has('mnuOrderAnalysis'))
        {
            return view('errors.403');
        }

        else {

            return view('layouts.OrderAnalysis');

        }

    }

    public function chartOrderAnalysis(Request $request){

        $txtMill = $request->txtMill;
        $txtBrand = $request->txtBrand;
        $txtDivision = $request->txtDivision;
        $txtCustomer = $request->txtCustomer;
        $txtStartDate = $request->txtStartDate;
        $txtEndDate = $request->txtEndDate;

        $where = "where Periode between '$txtStartDate' and '$txtEndDate'";

        if ($txtBrand){

            if($txtBrand == "OTHER") {

                $where .= " and brand_id = ''";
            }

            else {

                $where .= " and brand_id = '$txtBrand'";

            }

            
        }

        if ($txtDivision){
            $where .= " and class = '$txtDivision'";
        }

        // if ($txtCustomer){
        //     $where .= " and CustomerId = '$txtCustomer'";
        // }

        if ($txtMill) {
            $where .= " and mill_id = '$txtMill'";
        }

         $data = DB::connection("sqlsrv2")
                    ->select(DB::raw("select periode, sum(wgt_order)/1000 as wgt_order, sum(wgt_prod)/1000 as wgt_prod, sum(wgt_ship)/1000 as wgt_ship
                    from view_total_wgt $where group by periode order by periode asc"));

        // dd($data);

        // echo $where;

        return response()->json($data);


    }

    // ###Order###    
    public function chartOrderAnalysisByBrand(Request $request){

        $txtMill = $request->txtMill;
        $txtBrand = $request->txtBrand;
        $txtDivision = $request->txtDivision;
        $txtCustomer = $request->txtCustomer;
        $txtPeriode = $request->txtPeriode;

        $where = "where Periode = '$txtPeriode'";

        if ($txtBrand){

            if($txtBrand == "OTHER") {

                $where .= " and brand_id = ''";
            }

            else {

                $where .= " and brand_id = '$txtBrand'";

            }

            
        }

        if ($txtDivision){
            $where .= " and class = '$txtDivision'";
        }

        // if ($txtCustomer){
        //     $where .= " and CustomerId = '$txtCustomer'";
        // }

        if ($txtMill) {
            $where .= " and mill_id = '$txtMill'";
        }


        $data = DB::connection("sqlsrv2")
                    ->select(DB::raw("select periode, sum(wgt_order)/1000 as wgt_order,
                    CASE
                        WHEN brand_id = ' ' THEN 'OTHER'
                            ELSE brand_id
                    END as brand_id
                    from View_order_sum $where group by periode, brand_id"));

        // dd($data);

        // echo $where;

        return response()->json($data);


    }

    public function chartOrderAnalysisByClass(Request $request){

        $txtMill = $request->txtMill;
        $txtBrand = $request->txtBrand;
        $txtDivision = $request->txtDivision;
        $txtCustomer = $request->txtCustomer;
        $txtPeriode = $request->txtPeriode;

        $where = "where a.Periode = '$txtPeriode'";

        if ($txtBrand){

            if($txtBrand == "OTHER") {

                $where .= " and a.brand_id = ''";
            }

            else {

                $where .= " and a.brand_id = '$txtBrand'";

            }

            
        }

        if ($txtDivision){
            $where .= " and a.class = '$txtDivision'";
        }

        // if ($txtCustomer){
        //     $where .= " and a.CustomerId = '$txtCustomer'";
        // }

        if ($txtMill) {
            $where .= " and a.mill_id = '$txtMill'";
        }


         $data = DB::connection("sqlsrv2")
                    ->select(DB::raw(" select a.periode, a.class, LTRIM(RTRIM(b.descr)) as descr, sum(a.wgt_order)/1000 as wgt_order from View_order_sum a inner join division b on a.class = b.class $where group by a.periode, a.class, b.descr"));

        // dd($data);

        // echo $where;

        return response()->json($data);


    }

    public function chartOrderAnalysisByCust(Request $request){

        $txtMill = $request->txtMill;
        $txtBrand = $request->txtBrand;
        $txtDivision = $request->txtDivision;
        $txtCustomer = $request->txtCustomer;
        $txtPeriode = $request->txtPeriode;

        $where = "where Periode = '$txtPeriode'";

        if ($txtBrand){

            if($txtBrand == "OTHER") {

                $where .= " and brand_id = ''";
            }

            else {

                $where .= " and brand_id = '$txtBrand'";

            }

            
        }

        if ($txtDivision){
            $where .= " and class = '$txtDivision'";
        }

        // if ($txtCustomer){
        //     $where .= " and CustomerId = '$txtCustomer'";
        // }

        if ($txtMill) {
            $where .= " and mill_id = '$txtMill'";
        }


        $data = DB::connection("sqlsrv2")
                    ->select(DB::raw("select periode, CustomerID, NamaCustomer, sum(wgt_order)/1000 as wgt_order from View_order_sum $where group by periode, CustomerID, NamaCustomer"));

        // dd($data);

        // echo $where;

        return response()->json($data);


    }
    // ###Order### 


    // ###Production### 

    public function chartProdAnalysisByBrand(Request $request){

        $txtMill = $request->txtMill;
        $txtBrand = $request->txtBrand;
        $txtDivision = $request->txtDivision;
        $txtCustomer = $request->txtCustomer;
        $txtPeriode = $request->txtPeriode;

        $where = "where periode = '$txtPeriode'";

        if ($txtBrand){

            if($txtBrand == "OTHER") {

                $where .= " and brand_id = ''";
            }

            else {

                $where .= " and brand_id = '$txtBrand'";

            }

            
        }

        if ($txtDivision){
            $where .= " and class = '$txtDivision'";
        }

        // if ($txtCustomer){
        //     $where .= " and CustomerId = '$txtCustomer'";
        // }

        if ($txtMill) {
            $where .= " and mill_id = '$txtMill'";
        }


        $data = DB::connection("sqlsrv2")
                    ->select(DB::raw("select periode,
                    CASE
                        WHEN brand_id = ' ' THEN 'OTHER'
                            ELSE brand_id
                    END as brand_id,
                    sum(wgt_prod)/1000 as wgt_prod from View_order_produksi
                    $where
                    group by periode, brand_id"));

        // dd($data);

        // echo $where;

        return response()->json($data);


    }
    
    public function chartProdAnalysisByClass(Request $request){

        $txtMill = $request->txtMill;
        $txtDivision = $request->txtDivision;
        $txtCustomer = $request->txtCustomer;
        $txtPeriode = $request->txtPeriode;

        $where = "where a.periode = '$txtPeriode'";

        if ($txtDivision){
            $where .= " and a.class = '$txtDivision'";
        }

        // if ($txtCustomer){
        //     $where .= " and CustomerId = '$txtCustomer'";
        // }

        if ($txtMill) {
            $where .= " and a.mill_id = '$txtMill'";
        }


        $data = DB::connection("sqlsrv2")
                    ->select(DB::raw("select a.periode, a.class, LTRIM(RTRIM(b.descr)) as descr, sum(a.wgt_prod)/1000 as wgt_prod from View_order_produksi a inner join division b on a.class = b.class $where group by a.periode, a.class, b.descr"));

        // dd($data);

        // echo $where;

        return response()->json($data);


    }

    public function chartProdAnalysisByCust(Request $request){

        $txtMill = $request->txtMill;
        $txtDivision = $request->txtDivision;
        $txtCustomer = $request->txtCustomer;
        $txtPeriode = $request->txtPeriode;

        $where = "where periode = '$txtPeriode'";

        if ($txtDivision){
            $where .= " and class = '$txtDivision'";
        }

        // if ($txtCustomer){
        //     $where .= " and CustomerId = '$txtCustomer'";
        // }

        if ($txtMill) {
            $where .= " and mill_id = '$txtMill'";
        }


        $data = DB::connection("sqlsrv2")
                    ->select(DB::raw("select periode,
                    case
                            WHEN custGroup = 'LAIN' then 'OTHER'
                            else custGroup
                    END AS custGroup,
                    sum(wgt_prod)/1000 as wgt_prod from View_order_produksi
                    $where
                    group by periode, CustGroup"));

        // dd($data);

        // echo $where;

        return response()->json($data);


    }
    // ###Production### 


    // ###Shipment###
    public function chartShipAnalysisByBrand(Request $request){

        $txtMill = $request->txtMill;
        $txtBrand = $request->txtBrand;
        $txtDivision = $request->txtDivision;
        $txtCustomer = $request->txtCustomer;
        $txtPeriode = $request->txtPeriode;

        $where = "where periode = '$txtPeriode'";

        if ($txtBrand){

            if($txtBrand == "OTHER") {

                $where .= " and brand_id = ''";
            }

            else {

                $where .= " and brand_id = '$txtBrand'";

            }

            
        }

        if ($txtDivision){
            $where .= " and class = '$txtDivision'";
        }

        // if ($txtCustomer){
        //     $where .= " and CustomerId = '$txtCustomer'";
        // }

        if ($txtMill) {
            $where .= " and mill_id = '$txtMill'";
        }


        $data = DB::connection("sqlsrv2")
                    ->select(DB::raw("select periode, brand_id,
                    sum(wgt_ship)/1000 as wgt_ship from dashboard_deliv_sum
                    $where
                    group by periode, brand_id"));

        // dd($data);

        // echo $where;

        return response()->json($data);


    }

    public function chartShipAnalysisByClass(Request $request){

        $txtMill = $request->txtMill;
        $txtDivision = $request->txtDivision;
        $txtCustomer = $request->txtCustomer;
        $txtPeriode = $request->txtPeriode;

        $where = "where a.periode = '$txtPeriode'";

        if ($txtDivision){
            $where .= " and a.class = '$txtDivision'";
        }

        // if ($txtCustomer){
        //     $where .= " and CustomerId = '$txtCustomer'";
        // }

        if ($txtMill) {
            $where .= " and a.mill_id = '$txtMill'";
        }


        $data = DB::connection("sqlsrv2")
                    ->select(DB::raw("select a.periode, a.class, LTRIM(RTRIM(b.descr)) as descr, sum(a.wgt_ship)/1000 as wgt_ship from dashboard_deliv_sum a inner join division b on a.class = b.class $where group by a.periode, a.class, b.descr"));

        // dd($data);

        // echo $where;

        return response()->json($data);


    }

    public function chartShipAnalysisByCust(Request $request){

        $txtMill = $request->txtMill;
        $txtDivision = $request->txtDivision;
        $txtCustomer = $request->txtCustomer;
        $txtPeriode = $request->txtPeriode;

        $where = "where periode = '$txtPeriode'";

        if ($txtDivision){
            $where .= " and class = '$txtDivision'";
        }

        // if ($txtCustomer){
        //     $where .= " and CustomerId = '$txtCustomer'";
        // }

        if ($txtMill) {
            $where .= " and mill_id = '$txtMill'";
        }


        $data = DB::connection("sqlsrv2")
                    ->select(DB::raw("select periode, customerid, NamaCustomer,
                    sum(wgt_ship)/1000 as wgt_ship from dashboard_deliv_sum
                    $where
                    group by periode, customerid, NamaCustomer"));

        // dd($data);

        // echo $where;

        return response()->json($data);


    }
    // ###Shipment###


}
