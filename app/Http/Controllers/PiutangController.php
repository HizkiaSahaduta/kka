<?php

namespace App\Http\Controllers;

use DB;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class PiutangController extends Controller
{
    //
    public function __construct(){
        
        $this->middleware('auth');
    }

    public function index(){

        if(!Session::has('mnuPiutang'))
        {
            return view('errors.403');
        }

        else {

            return view('layouts.PiutangReport');

        }

    }

    public function getAllSummaryPiutang(Request $request){

        $txtCustomer = $request->txtCustomer;
        $txtSalesman = $request->txtSalesman;
        $txtFlag = $request->txtFlag;
        $txtStartDate = $request->txtStartDate;
        $txtEndDate = $request->txtEndDate;
        $dateBy = $request->dateBy;
        $where = "";
        $where.= "1=1";
        if ($txtCustomer) {

            $where.= " and CustomerId = '$txtCustomer'";
        }

        if ($txtSalesman) {

            $where.= " and SalesId = '$txtSalesman'";
        }

        if ($txtFlag) {

            if ($txtFlag == 'Y') {
                $where.= " and Pelunasan = 'LUNAS'";
            }

            if ($txtFlag == 'N') {
                $where.= " and Pelunasan = 'BELUM'";
            }

            if ($txtFlag == 'All') {
                $where.= " and Pelunasan <> ''";
            }
        }

        if ($dateBy == 'byInvoiceDate') {

            if ($txtStartDate && !$txtEndDate) {

                $where.= " and tglfaktur >= '$txtStartDate'";
            }
    
            if (!$txtStartDate && $txtEndDate) {
    
                $where.= " and tglfaktur <= '$txtEndDate'";
            }
    
            if ($txtStartDate && $txtEndDate) {
    
                $where.= " and tglfaktur between '$txtStartDate' and '$txtEndDate'";
            }

        }

        if ($dateBy == 'byDueDate') {

            if ($txtStartDate && !$txtEndDate) {

                $where.= " and TglJTempo >= '$txtStartDate'";
            }
    
            if (!$txtStartDate && $txtEndDate) {
    
                $where.= " and TglJTempo <= '$txtEndDate'";
            }
    
            if ($txtStartDate && $txtEndDate) {
    
                $where.= " and TglJTempo between '$txtStartDate' and '$txtEndDate'";
            }

        }

        try{

            $data = DB::connection("sqlsrv2")
                        ->select(DB::raw("select sum(total_faktur) as total_faktur, sum(total_tagihan) as total_tagihan, sum(total_bayar) as total_bayar, sum(total_piutang) as total_piutang
                        from
                        (select count(faktur) as total_faktur, CustomerId, NamaCustomer, Pelunasan, sum(tagihan) as total_tagihan,
                        sum(bayar) as total_bayar, sum(piutang) as total_piutang
                        from v_piutang where $where
                        group by CustomerId, NamaCustomer, Pelunasan) x "));

            
            return response()->json($data);
        }
        catch(QueryException $ex){
            $error = $ex->getMessage();
            return response()->json(['error' => $error]);
        }




    }

    public function getSummaryPiutang(Request $request){

        $txtCustomer = $request->txtCustomer;
        $txtSalesman = $request->txtSalesman;
        $txtFlag = $request->txtFlag;
        $txtStartDate = $request->txtStartDate;
        $txtEndDate = $request->txtEndDate;
        $dateBy = $request->dateBy;
        $where = "";
        $where.= "1=1";
        if ($txtCustomer) {

            $where.= " and CustomerId = '$txtCustomer'";
        }

        if ($txtSalesman) {

            $where.= " and SalesId = '$txtSalesman'";
        }

        if ($txtFlag) {

            if ($txtFlag == 'Y') {
                $where.= " and Pelunasan = 'LUNAS'";
            }

            if ($txtFlag == 'N') {
                $where.= " and Pelunasan = 'BELUM'";
            }

            if ($txtFlag == 'All') {
                $where.= " and Pelunasan <> ''";
            }
        }

        if ($dateBy == 'byInvoiceDate') {

            if ($txtStartDate && !$txtEndDate) {

                $where.= " and tglfaktur >= '$txtStartDate'";
            }
    
            if (!$txtStartDate && $txtEndDate) {
    
                $where.= " and tglfaktur <= '$txtEndDate'";
            }
    
            if ($txtStartDate && $txtEndDate) {
    
                $where.= " and tglfaktur between '$txtStartDate' and '$txtEndDate'";
            }

        }

        if ($dateBy == 'byDueDate') {

            if ($txtStartDate && !$txtEndDate) {

                $where.= " and TglJTempo >= '$txtStartDate'";
            }
    
            if (!$txtStartDate && $txtEndDate) {
    
                $where.= " and TglJTempo <= '$txtEndDate'";
            }
    
            if ($txtStartDate && $txtEndDate) {
    
                $where.= " and TglJTempo between '$txtStartDate' and '$txtEndDate'";
            }

        }
        

        $data = DB::connection("sqlsrv2")
                ->table('v_piutang')
                ->selectRaw("count(faktur) as total_faktur, CustomerId, NamaCustomer, Pelunasan, sum(tagihan) as total_tagihan,
                sum(bayar) as total_bayar, sum(piutang) as total_piutang")
                ->whereRaw($where)
                ->groupBy('CustomerId')
                ->groupBy('NamaCustomer')
                ->groupBy('Pelunasan')
                ->orderBy('total_faktur', 'desc')
                ->get();

        return \DataTables::of($data)
        ->editColumn('Pelunasan', function ($data) {
            if ($data->Pelunasan == "LUNAS") return '<span class="shadow-none badge badge-success">Y</span>';
            if ($data->Pelunasan == "BELUM") return '<span class="shadow-none badge badge-danger">N</span>';
            return '<span class="shadow-none badge badge-primary">N/A</span>';
        })
        ->addColumn('Detail', function($data) {

            return '
                <a href="javascript:void(0)" data-id1="'.$data->CustomerId.'" data-id2="'.$data->NamaCustomer.'" class="bs-tooltip detail" data-placement="top" title="Detail" data-toggle="modal" data-target="#detail">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </a>
                ';
            })
        ->rawColumns(['Pelunasan','Detail'])
        ->make(true);

        //echo  $where;

    }

    public function getOverviewPiutang(Request $request){

        $txtCustomer = $request->txtCustomer;
        $txtSalesman = $request->txtSalesman;
        $txtFlag = $request->txtFlag;
        $txtStartDate = $request->txtStartDate;
        $txtEndDate = $request->txtEndDate;
        $dateBy = $request->dateBy;
        $where = "";
        $where.= "1=1";
        if ($txtCustomer) {

            $where.= " and a.CustomerId = '$txtCustomer'";
        }

        if ($txtSalesman) {

            $where.= " and a.SalesId = '$txtSalesman'";
        }

        if ($txtFlag) {

            if ($txtFlag == 'Y') {
                $where.= " and Pelunasan = 'LUNAS'";
            }

            if ($txtFlag == 'N') {
                $where.= " and Pelunasan = 'BELUM'";
            }

            if ($txtFlag == 'All') {
                $where.= " and Pelunasan <> ''";
            }
        }

        if ($dateBy == 'byInvoiceDate') {

            if ($txtStartDate && !$txtEndDate) {

                $where.= " and a.tglfaktur >= '$txtStartDate'";
            }
    
            if (!$txtStartDate && $txtEndDate) {
    
                $where.= " and a.tglfaktur <= '$txtEndDate'";
            }
    
            if ($txtStartDate && $txtEndDate) {
    
                $where.= " and a.tglfaktur between '$txtStartDate' and '$txtEndDate'";
            }

        }

        if ($dateBy == 'byDueDate') {

            if ($txtStartDate && !$txtEndDate) {

                $where.= " and a.TglJTempo >= '$txtStartDate'";
            }
    
            if (!$txtStartDate && $txtEndDate) {
    
                $where.= " and a.TglJTempo <= '$txtEndDate'";
            }
    
            if ($txtStartDate && $txtEndDate) {
    
                $where.= " and a.TglJTempo between '$txtStartDate' and '$txtEndDate'";
            }

        }
        

        $data = DB::connection("sqlsrv2")
                    ->select(DB::raw("select a.CustomerId, a.NamaCustomer, Pelunasan,
                    a.NamaSales, a.faktur, a.CustomerOrderNo,
                    FORMAT(a.tglfaktur, 'dd MMM yyyy') as tglfaktur,
                    FORMAT(a.TglJTempo, 'dd MMM yyyy') as TglJTempo,
                    a.NominalFaktur, a.Discount,a.kwitansi, a.tagihan, a.bayar, a.piutang, 
                    LTRIM(RTRIM(b.office)) as office,
                    a.region from v_piutang a
                    inner join branch_office b on a.office_id = b.office_id where $where"));      

        return \DataTables::of($data)
        ->editColumn('Pelunasan', function ($data) {
            if ($data->Pelunasan == "LUNAS") return '<span class="shadow-none badge badge-success">Y</span>';
            if ($data->Pelunasan == "BELUM") return '<span class="shadow-none badge badge-danger">N</span>';
            return '<span class="shadow-none badge badge-primary">N/A</span>';
        })
        ->rawColumns(['Pelunasan'])
        ->make(true);

        //echo  $where;

    }


        

}
