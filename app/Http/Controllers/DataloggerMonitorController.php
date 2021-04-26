<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class DataloggerMonitorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $millname = DB::connection('sqlsrv4')
                ->table('Site')
                ->select('Key', 'Lokasi')
                ->orderBy('Key', 'asc')
                ->get();

        // $machtype = DB::connection('sqlsrv2')
        //         ->table('machine_type')
        //         ->select('mach_type', 'descr')
        //         ->where('active_flag', '=', 'Y')
        //         ->where('mill_id', '=', 'KP')
        //         ->distinct('mach_type')
        //         ->orderBy('mach_type', 'asc')
        //         ->get();

        return view('layouts.DataloggerMonitor', ['millname' => $millname]);
    }

    public function ProductionLoggerMach(Request $request)
    {
        $id = $request->id;

        $result = DB::connection('sqlsrv4')
                ->table('SiteMesin as a')
                ->select('b.Type_Key')
                ->join('Mesin as b', 'a.Mesin_key', '=', 'b.Key')
                ->join('Site as c', 'a.Site_key', '=', 'c.Key')
                ->where('c.Key', '=', $id)
                ->distinct()
                ->get();       

        return response()->json($result);

    }

    public function ProductionLoggerMachId(Request $request)
    {

        $millID = $request->millID;
        $machId = $request->machId;

        $result = DB::connection('sqlsrv4')
                ->table('SiteMesin as a')
                ->select('b.Id')
                ->join('Mesin as b', 'a.Mesin_key', '=', 'b.Key')
                ->join('Site as c', 'a.Site_key', '=', 'c.Key')
                ->where('b.Type_Key', '=', $machId)
                ->where('c.Key', '=', $millID)
                ->get();
            
        return response()->json($result);
    }

    public function populateProductionCutting(Request $request)
    {

        if($request->txtMillID != null)
        {
            $txtMillID = $request->txtMillID;
        }
        else
        {
            $txtMillID = '';
        }

        if($request->txtMachType != null)
        {
            $txtMachType = $request->txtMachType;
        }
        else
        {
            $txtMachType = '';
        }

        if($request->txtMachId != null)
        {
            $txtMachId = $request->txtMachId;
        }
        else
        {
            $txtMachId = '';
        }

        if($request->dtStart != null)
        {
            $dtStart = $request->dtStart;
        }
        else
        {
            $dtStart = '';
        }

        if($request->dtEnd != null)
        {
            $dtEnd = $request->dtEnd;
        }
        else
        {
            $dtEnd = '';
        }

        $sqlWhere = '1=1';

        if (!empty($txtMillID))
        {
            $sqlWhere = $sqlWhere . " and c.[Key] = ". "LTRIM(RTRIM('" . $txtMillID . "'))";
        }

        if (!empty($txtMachType))
        {
            $sqlWhere = $sqlWhere . " and d.Type_Key = ". "LTRIM(RTRIM('" . $txtMachType . "'))";
        }

        if (!empty($txtMachId))
        {
            $sqlWhere = $sqlWhere . " and d.Id = ". "LTRIM(RTRIM('" . $txtMachId . "'))";
        }

        if (!empty($dtStart))
        {
            if (!empty($dtEnd))
            {
                $sqlWhere = $sqlWhere . " and a.Tanggal >= '" .$dtStart. "' and a.Tanggal <= '" . $dtEnd . "'";
            }
            else
            {
                $sqlWhere = $sqlWhere . " and FORMAT(a.Tanggal, 'dd-MM-yy') = '" .$dtStart. "'";
            }
        }


        $result = DB::connection("sqlsrv4")
                        ->table('Transaksi as a')
                        ->selectRaw("FORMAT(a.Tanggal, 'yyyyMMdd') as Tanggal, a.[SiteMesin_Key], d.Type_Key, d.Id, c.Lokasi, sum(Round(((cast(Length as float)/360)*36.0158*10 + 1) / $request->txtRound, 0) * $request->txtRound) / 1000 as total, count(a.length) as totalCut")
                        ->join('SiteMesin as b', 'b.Key', '=', 'a.SiteMesin_Key')
                        ->join('Site as c', 'c.Key', '=', 'b.Site_key')
                        ->join('Mesin as d', 'd.Key', '=', 'b.Mesin_key')
                        ->groupByRaw("FORMAT(a.Tanggal, 'yyyyMMdd'), a.[SiteMesin_Key], d.Type_Key, d.Id, c.Lokasi")
                        ->whereRaw($sqlWhere)
                        ->where('a.Length', '>', 0)
                        ->orderByRaw("FORMAT(a.Tanggal, 'yyyyMMdd') desc")
                        ->get();

        return \DataTables::of($result)
                            ->addColumn('Actions', function($result) {
                                return '<button type="button" data-toggle="modal" data-target="#DetLogItemModal" id="DetLogItem" data-date="'.LTRIM(RTRIM($result->Tanggal)).'" data-id="'.LTRIM(RTRIM($result->SiteMesin_Key)).'" class="btn btn-success">Details</a>';
                            })
                            ->rawColumns(['Actions'])
                            ->make(true);  
    }

    public function populateProductionCuttingDetail(Request $request)
    {

        $result = DB::connection("sqlsrv4")
                        ->table('Transaksi')
                        ->selectRaw("Round(((cast(Length as float)/360)*36.0158*10 + 1) / $request->txtRound, 0) * $request->txtRound as panjang, count(Round(((cast(Length as float)/360)*36.0158*10 + 1) / $request->txtRound, 0) * $request->txtRound) as total")
                        ->whereRaw("Tanggal >= '$request->date' and Tanggal <= dateadd(day, 1, '$request->date')")
                        ->where('SiteMesin_Key', '=', $request->mach)
                        ->whereRaw("Round(((cast(Length as float)/360)*36.0158*10 + 1) / $request->txtRound, 0) * $request->txtRound > 0")
                        ->groupByRaw("Round(((cast(Length as float)/360)*36.0158*10 + 1) / $request->txtRound, 0) * $request->txtRound")
                        ->orderByRaw("Round(((cast(Length as float)/360)*36.0158*10 + 1) / $request->txtRound, 0) * $request->txtRound asc")
                        ->get();

        return \DataTables::of($result)
                            ->make(true);

    }
    
}
