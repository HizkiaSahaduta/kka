<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class DataloggerStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $subQuery = DB::connection('sqlsrv4')
                        ->table('Transaksi as b')
                        ->selectRaw('max(b.tanggal) as Tgl, b.SiteMesin_Key')
                        ->groupBy('b.SiteMesin_Key');

        $result = DB::connection('sqlsrv4')
                    ->table('Transaksi as a')
                    //->select('a.Tanggal', 'a.SiteMesin_Key', 'a.Kondisi', 'd.Lokasi', 'e.Id', 'f.Description')
                    ->selectRaw("format(a.Tanggal, 'dd-MM-yy hh:mm') as Tanggal, a.SiteMesin_Key, 
                                (case
                                when a.Kondisi = 0 then 'Mesin Mati'
                                when a.Kondisi = 1 then 'Mesin Hidup' 
                                end) as Kondisi,
                                (case
                                when a.Proses = 1 then 'Mesin Aktif'
                                when a.Proses = 2 then 'Mesin Idle' 
                                when a.Proses = 3 then 'Trial Cut' 
                                when a.Proses = 4 then 'Maintenance' 
                                when a.Proses = 5 then 'Mesin Mati' 
                                end) as Proses, 
                                d.Lokasi, e.Type_Key, e.Id, f.Description")
                    ->joinSub($subQuery, 'b', function ($join) {
                        $join->on('a.Tanggal', '=', 'b.Tgl');
                        $join->on('a.SiteMesin_Key', '=', 'b.SiteMesin_Key');
                    })
                    ->join('SiteMesin as c', 'a.SiteMesin_Key', '=', 'c.Key')
                    ->join('Site as d', 'c.Site_key', '=', 'd.Key')
                    ->join('Mesin as e', 'c.Mesin_key', '=', 'e.Key')
                    ->join('Type as f', 'e.Type_Key', '=', 'f.Key')
                    ->get();

        return view('layouts.DataloggerStatus', ['result' => $result]);
    }

    public function DataloggerLiveStatus()
    {

        $subQuery = DB::connection('sqlsrv4')
                        ->table('Transaksi as b')
                        ->selectRaw('max(b.tanggal) as Tgl, b.SiteMesin_Key')
                        ->groupBy('b.SiteMesin_Key');

                        $result = DB::connection('sqlsrv4')
                        ->table('Transaksi as a')
                        //->select('a.Tanggal', 'a.SiteMesin_Key', 'a.Kondisi', 'd.Lokasi', 'e.Id', 'f.Description')
                        ->selectRaw("Format(cast(a.Tanggal as datetime),'dd-MMM-yyyy HH:mm','en-us') as Tanggal, a.SiteMesin_Key, 
                                    (case
                                    when a.Kondisi = 0 then 'Mesin mati'
                                    when a.Kondisi = 1 then 'Mesin Hidup' 
                                    end) as Kondisi,
                                    (case
                                    when a.Proses = 1 then 'Mesin Aktif'
                                    when a.Proses = 2 then 'Mesin Idle' 
                                    when a.Proses = 3 then 'Trial Cut' 
                                    when a.Proses = 4 then 'Maintenance' 
                                    when a.Proses = 5 then 'Mesin Mati' 
                                    end) as Proses, 
                                    d.Lokasi, e.Type_Key, e.Id, f.Description,
                                    FORMAT(Round(((cast(a.Length as float)/360)*36.0158*10 + 1) / 50, 0) * 50, 'N0') as Length")
                        ->joinSub($subQuery, 'b', function ($join) {
                            $join->on('a.Tanggal', '=', 'b.Tgl');
                            $join->on('a.SiteMesin_Key', '=', 'b.SiteMesin_Key');
                        })
                        ->join('SiteMesin as c', 'a.SiteMesin_Key', '=', 'c.Key')
                        ->join('Site as d', 'c.Site_key', '=', 'd.Key')
                        ->join('Mesin as e', 'c.Mesin_key', '=', 'e.Key')
                        ->join('Type as f', 'e.Type_Key', '=', 'f.Key')
                        ->get();

        return response()->json($result);
        // return response()->json(['result' => $result]);
    }

}
