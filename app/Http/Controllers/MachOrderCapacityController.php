<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Carbon\Carbon;

class MachOrderCapacityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        set_time_limit(0);

        $year =  DB::connection("sqlsrv2")
                    ->table("view_mach_cap_vs_order")
                    ->select("tahun")
                    ->distinct()
                    ->get();

        $week =  DB::connection("sqlsrv2")
                    ->table("view_mach_cap_vs_order")
                    ->select("minggu")
                    ->orderBy("minggu", "asc")
                    ->distinct()
                    ->get();

        $millId =  DB::connection("sqlsrv2")
                    ->table("view_mach_cap_vs_order as a")
                    ->join("mill as b", "b.mill_id", "=", "a.mill")
                    ->select("a.mill", "b.mill_name")
                    ->distinct()
                    ->get();

        return view('layouts.MachOrderCapacity', ['year' => $year, 'week' => $week, 'millId' => $millId]);
    }

    public function getMachID(Request $request)
    {

        $id = $request->txtMillID;

        $result =  DB::connection("sqlsrv2")
                        ->table("machine_type")
                        ->select("mach_type", "descr")
                        ->orderBy("descr", "asc")
                        ->distinct()
                        ->where("active_flag", "=", "Y")
                        ->where("mill_id", "=", $id)
                        ->get();

        return response()->json($result);

    }

    public function FindOrderCapacity(Request $request)
    {
        set_time_limit(0);

        $txtMillID = $request->txtMillID;
        $txtMachType = $request->txtMachType;
        $dtStart = $request->dtStart;
        $dtEnd = $request->dtEnd;

        $startYear = substr($dtStart, 0, 4);
        $endYear = substr($dtEnd, 0, 4);

        $dStart = new Carbon($dtStart);
        $weekStart = $dStart->weekOfYear + 1;

        $dEnd = new Carbon($dtEnd);
        $weekEnd = $dEnd->weekOfYear + 1;

        $sqlwhere = "1=1 ";

        if($txtMillID){
            $sqlwhere = $sqlwhere . "and mill = '$txtMillID' " ;
        }

        if($txtMachType){
            $sqlwhere = $sqlwhere . "and mesin = '$txtMachType' " ;
        }

        $sqlwhere = $sqlwhere . "and tahun between '$startYear' and '$endYear' and minggu between '$weekStart' and '$weekEnd' " ;

        $result =  DB::connection("sqlsrv2")
                        ->table("view_mach_cap_vs_order")
                        ->whereRaw($sqlwhere)
                        ->get();

        return \DataTables::of($result)
                            ->with('weekStart', $weekStart)
                            ->with('weekEnd', $weekEnd)
                            ->toJson();

    }

    public function FindOrderCapacityGraph(Request $request)
    {

        set_time_limit(0);

        $txtMillID = $request->txtMillID;
        $txtMachType = $request->txtMachType;
        $dtStart = $request->dtStart;
        $dtEnd = $request->dtEnd;

        $startYear = substr($dtStart, 0, 4);
        $endYear = substr($dtEnd, 0, 4);

        $dStart = new Carbon($dtStart);
        $weekStart = $dStart->weekOfYear + 1;

        $dEnd = new Carbon($dtEnd);
        $weekEnd = $dEnd->weekOfYear + 1;

        $sqlwhere = "1=1 ";

        if($txtMillID){
            $sqlwhere = $sqlwhere . "and mill = '$txtMillID' " ;
        }

        if($txtMachType){
            $sqlwhere = $sqlwhere . "and mesin = '$txtMachType' " ;
        }

        $sqlwhere = $sqlwhere . "and tahun between '$startYear' and '$endYear' and minggu between '$weekStart' and '$weekEnd' " ;

        $result =  DB::connection("sqlsrv2")
                        ->table("view_mach_cap_vs_order")
                        // ->selectRaw("minggu, FORMAT(TotPanjangOrder, 'N0') as TotPanjangOrder")
                        // ->select("minggu", "TotPanjangOrder")
                        ->whereRaw($sqlwhere)
                        ->get();

        return response()->json($result);
    
    }

}
