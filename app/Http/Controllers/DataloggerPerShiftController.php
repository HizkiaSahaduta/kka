<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class DataloggerPerShiftController extends Controller
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

        return view('layouts.DataloggerPerShift', ['millname' => $millname]);
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
        $txtRound = $request->txtRound;

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

    public function FindDataloggerPerShift(Request $request)
    {

        $txtRound = $request->txtRound;


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

        if($request->txtShiftMode != null)
        {
            $txtShiftMode = $request->txtShiftMode;
        }
        else
        {
            $txtShiftMode = '';
        }

        if($request->dtStart != null)
        {
            $dtStart = $request->dtStart;
        }
        else
        {
            $dtStart = '';
        }

        if($request->dtHour != '00:00')
        {
            $dtHour = $request->dtHour;
        }
        else
        {
            $dtHour = '08:00';
        }

        $sqlWhere = '1=1';

        if (!empty($txtMillID))
        {
            $sqlWhere = $sqlWhere . " and d.[Key] = ". "LTRIM(RTRIM('" . $txtMillID . "'))";
        }

        if (!empty($txtMachType))
        {
            $sqlWhere = $sqlWhere . " and c.Type_Key = ". "LTRIM(RTRIM('" . $txtMachType . "'))";
        }

        if (!empty($txtMachId))
        {
            $sqlWhere = $sqlWhere . " and c.Id = ". "LTRIM(RTRIM('" . $txtMachId . "'))";
        }

        $dTime = $dtStart." ".$dtHour ; 

        if($txtShiftMode == "short"){
            $sqlQueryShortShift = "with x (tanggal, shift, SiteMesin_key, kondisi, length) as 
                                (select cast(tanggal as date), 
                                case when tanggal >= '$dTime' and tanggal < dateadd(hh, 8, '$dTime') then '1' 
                                when tanggal >= dateadd(hh, 8, '$dTime') and tanggal < dateadd(hh, 16,'$dTime') then '2'
                                when tanggal >= dateadd(hh, 16, '$dTime') and tanggal < dateadd(hh, 24,'$dTime') then '3'
                                end as Shift, SiteMesin_Key, Kondisi, Length
                                from transaksi)
                                select case when x.shift = 3 then dateadd(dd, -1, x.tanggal) else x.tanggal end as tanggal, 
                                x.shift, x.SiteMesin_Key, x.kondisi, count(x.shift) as jumlah, isnull(e.jmlhpotong,0) as jmlhpotong, 
                                sum(Round(((cast(Length as float)/360)*36.0158*10 + 1) / $txtRound, 0) * $txtRound) / 1000 as total_panjang, isnull(e.totalPanjangTot,0) as totalPanjangTot, c.Type_Key, c.Id, d.Id as lokasi
                                from x
                                join SiteMesin b on x.SiteMesin_Key = b.[Key]
                                join Mesin c on b.Mesin_key = c.[Key]
                                join Site d on b.Site_key = d.[Key]
                                left outer join kepuh.dbo.view_mach_stat_shift_tot e on e.mach_type=c.Type_Key and e.mach_id=c.Id and e.shift=x.shift and e.dt_trans = '$dtStart' AND e.mill_id = d.Id
                                where x.shift IS NOT NULL and kondisi <> 0 and ".$sqlWhere." 
                                GROUP BY e.mill_id,x.tanggal, x.shift, x.SiteMesin_Key, x.kondisi, c.Type_Key, c.Id, e.jmlhpotong, e.totalPanjangTot, d.Id
                                order by c.Id";
        }
        else{
            $sqlQueryShortShift = "with x (tanggal, shift, SiteMesin_Key, kondisi, length) as 
                                (select cast(tanggal as date), 
                                case when tanggal >= '$dTime' and tanggal < dateadd(hh, 12, '$dTime') then '1' 
                                when tanggal >= dateadd(hh, 12, '$dTime') and tanggal < dateadd(hh, 24,'$dTime') then '2'
                                end as Shift, SiteMesin_Key, Kondisi, Length
                                from transaksi)
                                select case when x.shift = 3 then dateadd(dd, -1, x.tanggal) else x.tanggal end as tanggal, 
                                x.shift, x.SiteMesin_Key, x.kondisi, count(x.shift) as jumlah, isnull(e.jmlhpotong,0) as jmlhpotong, 
                                sum(Round(((cast(Length as float)/360)*36.0158*10 + 1) / $txtRound, 0) * $txtRound) / 1000 as total_panjang, isnull(e.totalPanjangTot,0) as totalPanjangTot, c.Type_Key, c.Id, d.Id as lokasi
                                from x
                                join SiteMesin b on x.SiteMesin_Key = b.[Key]
                                join Mesin c on b.Mesin_key = c.[Key]
                                join Site d on b.Site_key = d.[Key]
                                left outer join kepuh.dbo.view_mach_stat_shift_tot e on e.mach_type=c.Type_Key and e.mach_id=c.Id and e.shift=x.shift and e.dt_trans = '$dtStart' AND e.mill_id = d.Id
                                where x.shift IS NOT NULL and kondisi <> 0 and ".$sqlWhere." 
                                GROUP BY e.mill_id,x.tanggal, x.shift, x.SiteMesin_Key, x.kondisi, c.Type_Key, c.Id, e.jmlhpotong, e.totalPanjangTot, d.Id
                                order by c.Id";
        }

        
        $result = DB::connection("sqlsrv4")
                    ->select(DB::raw($sqlQueryShortShift));

        return \DataTables::of($result)
                        ->addColumn('Actions', function($result) {
                            return '<button type="button" data-toggle="modal" data-target="#ShiftItemModal" id="ShiftItemList"
                                    data-date="'.LTRIM(RTRIM($result->tanggal)).'" 
                                    data-shift="'.LTRIM(RTRIM($result->shift)).'"
                                    data-id="'.LTRIM(RTRIM($result->SiteMesin_Key)).'" 
                                    class="btn btn-primary" />Details';
                        })
                        // ->rawColumns(['Actions'])
                        ->addColumn('Actions2', function($result) {
                            return '<button type="button" data-toggle="modal" data-target="#ShiftItemModalKKA" id="ShiftItemListKKA"
                                    data-date="'.LTRIM(RTRIM($result->tanggal)).'" 
                                    data-shift="'.LTRIM(RTRIM($result->shift)).'"
                                    data-mill="'.LTRIM(RTRIM($result->lokasi)).'" 
                                    data-mach="'.LTRIM(RTRIM($result->Type_Key)).'"
                                    data-id="'.LTRIM(RTRIM($result->Id)).'" 
                                    class="btn btn-primary" />Details KKA';
                        })
                        ->rawColumns(['Actions','Actions2'])
                        ->make(true);  

    }

    public function DataPerShiftDetail(Request $request)
    {

        $txtDate = $request->txtDate . ' ' .$request->txtHour;
        $txtShift = $request->txtShift;
        $txtSiteMesinKey = $request->txtSiteMesinKey;
        $txtRound = $request->txtRound;

        $sqlWhere = '1=1';

        $result = DB::connection("sqlsrv4")
                    ->select(DB::raw("with x (tanggal, shift, SiteMesin_key, kondisi, panjang) as                     
                    (select cast(tanggal as date),                     
                    case when tanggal >= '$txtDate' and tanggal < dateadd(hh, 8, '$txtDate') then '1'                     
                    when tanggal >= dateadd(hh, 8, '$txtDate') and tanggal < dateadd(hh, 16,'$txtDate') then '2'                   
                    when tanggal >= dateadd(hh, 16, '$txtDate') and tanggal < dateadd(hh, 25,'$txtDate') then '3'                    
                    end as Shift, 
                    SiteMesin_Key, kondisi, Round(((cast(Length as float)/360)*36.0158*10 + 1) / $txtRound, 0) * $txtRound as panjang             
                    from transaksi)                    
                    select tanggal, shift, SiteMesin_Key, kondisi
                    ,panjang
                    ,count(panjang) as jumlah
                    ,sum(panjang) / 1000 as total_panjang                     
                    from x                     
                    where shift IS NOT NULL and kondisi <> 0 and panjang > 0 and shift = $txtShift and SiteMesin_key = $txtSiteMesinKey                    
                    GROUP BY tanggal, shift, SiteMesin_Key, kondisi, panjang                     
                    order by SiteMesin_Key, shift"));

        return \DataTables::of($result)
                        ->make(true);

    }

    public function DataPerShiftDetailKKA(Request $request)
    {

        $txtDate = $request->txtDate;
        $txtShift = $request->txtShift;
        $txtMill = $request->txtMill;
        $txtMach = $request->txtMach;
        $txtMachId = $request->txtMachId;

        $sqlWhere = '1=1';



        $result = DB::connection("sqlsrv2")
                    ->table('view_mach_stat_shift')
                    ->selectRaw("shift, lembar, panjang*1000 as panjang, totalPanjang")
                    ->where("dt_trans", "=", $txtDate)
                    ->where("shift", "=", $txtShift)
                    ->where("mach_type", "=", $txtMach)
                    ->where("mach_id", "=", $txtMachId)
                    ->where("mill_id", "=", $txtMill)
                    ->get();

        return \DataTables::of($result)
                        ->make(true);

    }

}
