<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class BlankController extends Controller
{

    public function index()
    {


        return view('layouts.Blank');
    }

    public function populateTest(Request $request)
    {
        set_time_limit(0);

        $timeline = $request->txtTimeline;
        $date = $request->dtStart;

        $result =  DB::connection("sqlsrv4")
                    ->select(DB::raw("select left(b.$timeline , 8) as waktu, avg(isnull(Length,0)) as length from KEPUH.dbo.timeline b
                    left outer join Transaksi a on CONVERT(VARCHAR(5), a.Tanggal, 108) = left(b.$timeline , 5) and a.Tanggal between '$date 00:00:00.000' and '$date 23:59:00.000' and a.SiteMesin_Key = 9
                    where 1=1 
                    group by left(b.$timeline , 8)
                    order by left(b.$timeline , 8)
                    "));

        return response()->json($result);
    }

}
