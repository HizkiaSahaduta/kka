<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class DelivController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        if(!Session::has('mnuDelivAnalysis'))
        {
            return view('errors.403');
        }

        else {

            return view('layouts.DelivAnalysis');


        }

    }

    public function chartDeliv(Request $request){

        $mill = $request->mill;
        $division = $request->division;
        $mach_type = $request->mach_type;
        $start = $request->start;
        $end = $request->end;

        $where = "where mill_id = '$mill' and Periode between '$start' and '$end'";

        if ($division){
            $where .= " and divisi = '$division'";
        }

        if ($mach_type){
            $where .= " and mach_type = '$mach_type'";
        }


        //  $data = DB::connection("sqlsrv2")
        //             ->select(DB::raw("
        //             SELECT
        //                 mill_id,
        //                 mill_name,
        //                 periode,
        //                 COUNT ( deliv_id ) tot_ship,
        //                 round( AVG ( ot_ship ), 2 ) ot_ship,
        //                 round( AVG ( real_ship ), 2 ) real_ship,
        //                 round( AVG ( pct_ot ), 2 ) pct_ot,
        //                 round( AVG ( pct_real ), 2 ) pct_real
        //             FROM
        //                 (
        //                 SELECT DISTINCT
        //                     mill_id,
        //                     mill_name,
        //                     periode,
        //                     deliv_id,
        //                     dt_rcv,
        //                     dateadd( DAY, 3, dt_rcv ) ot_date,
        //                     req_ship_date,
        //                     CAST ( datediff( DAY, dateadd( DAY, 3, dt_rcv ), ship_date ) AS FLOAT ) ot_ship,
        //                 CASE

        //                         WHEN datediff( DAY, dateadd( DAY, 3, dt_rcv ), ship_date ) <= 0 THEN
        //                         100
        //                         WHEN datediff( DAY, dateadd( DAY, 3, dt_rcv ), ship_date ) >= 30 THEN
        //                         0 ELSE ( CAST ( ( 30 - datediff( DAY, dateadd( DAY, 3, dt_rcv ), ship_date ) ) AS FLOAT ) / 30 ) * 100
        //                     END AS pct_ot,
        //                     CAST ( datediff( DAY, req_ship_date, ship_date ) AS FLOAT ) real_ship,
        //                 CASE

        //                         WHEN datediff( DAY, req_ship_date, ship_date ) <= 0 THEN
        //                         100
        //                         WHEN datediff( DAY, req_ship_date, ship_date ) >= 30 THEN
        //                         0 ELSE ( CAST ( ( 30 - datediff( DAY, req_ship_date, ship_date ) ) AS FLOAT ) / 30 ) * 100
        //                     END AS pct_real
        //                 FROM
        //                     view_deliv
        //                 $where
        //                 ) x
        //             GROUP BY
        //                 mill_id,
        //                 mill_name,
        //                 periode
        //             ORDER BY
        //                 periode"));

        $data = DB::connection("sqlsrv2")
                    ->select(DB::raw("
                            SELECT
                            x.mill_id,
                            x.mill_name,
                            x.periode,
                            COUNT ( deliv_id ) tot_ship,
                            round( AVG ( x.selisih ), 2 ) AS average,
                            round( MIN ( x.selisih ), 2 ) AS minim,
                            round( MAX ( x.selisih ), 2 ) AS maxim,
                            y.selisih AS modus 
                        FROM
                            (
                            SELECT DISTINCT
                                mill_id,
                                mill_name,
                                periode,
                                Order_id,
                                deliv_id,
                                FORMAT ( ship_date, 'dd MMM yyyy' ) AS ship_date,
                                FORMAT ( dt_rcv, 'dd MMM yyyy' ) AS dt_rcv,
                                FORMAT ( dateadd( DAY, 3, dt_rcv ), 'dd MMM yyyy' ) AS expected,
                                CAST ( datediff( DAY, dt_rcv, ship_date ) AS FLOAT ) selisih 
                            FROM
                                view_deliv 
                            $where
                            ) x
                            INNER JOIN (
                            SELECT
                                mill_id,
                                mill_name,
                                periode,
                                AVG ( selisih ) AS selisih 
                            FROM
                                (
                                SELECT
                                    mill_id,
                                    mill_name,
                                    periode,
                                    selisih,
                                    COUNT ( selisih ) jumlah,
                                    MAX ( COUNT ( selisih ) ) OVER ( partition BY mill_id, mill_name, periode ) AS makmak 
                                FROM
                                    (
                                    SELECT DISTINCT
                                        mill_id,
                                        mill_name,
                                        periode,
                                        Order_id,
                                        deliv_id,
                                        FORMAT ( ship_date, 'dd MMM yyyy' ) AS ship_date,
                                        FORMAT ( dt_rcv, 'dd MMM yyyy' ) AS dt_rcv,
                                        FORMAT ( dateadd( DAY, 3, dt_rcv ), 'dd MMM yyyy' ) AS expected,
                                        CAST ( datediff( DAY, dt_rcv, ship_date ) AS FLOAT ) selisih 
                                    FROM
                                        view_deliv 
                                    $where
                                    ) x 
                                GROUP BY
                                    mill_id,
                                    mill_name,
                                    periode,
                                    selisih UNION
                                SELECT
                                    mill_id,
                                    mill_name,
                                    periode,
                                    selisih,
                                    jumlah,
                                    MAX ( jumlah ) OVER ( partition BY mill_id, mill_name, periode ) AS makmak2 
                                FROM
                                    (
                                    SELECT
                                        mill_id,
                                        mill_name,
                                        periode,
                                        selisih,
                                        jumlah 
                                    FROM
                                        (
                                        SELECT
                                            mill_id,
                                            mill_name,
                                            periode,
                                            selisih,
                                            COUNT ( selisih ) jumlah,
                                            MAX ( COUNT ( selisih ) ) OVER ( partition BY mill_id, mill_name, periode ) AS makmak 
                                        FROM
                                            (
                                            SELECT DISTINCT
                                                mill_id,
                                                mill_name,
                                                periode,
                                                Order_id,
                                                deliv_id,
                                                FORMAT ( ship_date, 'dd MMM yyyy' ) AS ship_date,
                                                FORMAT ( dt_rcv, 'dd MMM yyyy' ) AS dt_rcv,
                                                FORMAT ( dateadd( DAY, 3, dt_rcv ), 'dd MMM yyyy' ) AS expected,
                                                CAST ( datediff( DAY, dt_rcv, ship_date ) AS FLOAT ) selisih 
                                            FROM
                                                view_deliv 
                                            $where
                                            ) x 
                                        GROUP BY
                                            mill_id,
                                            mill_name,
                                            periode,
                                            selisih 
                                        ) a 
                                    GROUP BY
                                        mill_id,
                                        mill_name,
                                        periode,
                                        selisih,
                                        jumlah 
                                    ) b 
                                WHERE
                                    jumlah NOT IN (
                                    SELECT MAX
                                        ( jumlah ) 
                                    FROM
                                        (
                                        SELECT
                                            mill_id,
                                            mill_name,
                                            periode,
                                            selisih,
                                            jumlah 
                                        FROM
                                            (
                                            SELECT
                                                mill_id,
                                                mill_name,
                                                periode,
                                                selisih,
                                                COUNT ( selisih ) jumlah,
                                                MAX ( COUNT ( selisih ) ) OVER ( partition BY mill_id, mill_name, periode ) AS makmak 
                                            FROM
                                                (
                                                SELECT DISTINCT
                                                    mill_id,
                                                    mill_name,
                                                    periode,
                                                    Order_id,
                                                    deliv_id,
                                                    FORMAT ( ship_date, 'dd MMM yyyy' ) AS ship_date,
                                                    FORMAT ( dt_rcv, 'dd MMM yyyy' ) AS dt_rcv,
                                                    FORMAT ( dateadd( DAY, 3, dt_rcv ), 'dd MMM yyyy' ) AS expected,
                                                    CAST ( datediff( DAY, dt_rcv, ship_date ) AS FLOAT ) selisih 
                                                FROM
                                                    view_deliv 
                                                $where 
                                                ) x 
                                            GROUP BY
                                                mill_id,
                                                mill_name,
                                                periode,
                                                selisih 
                                            ) a 
                                        GROUP BY
                                            mill_id,
                                            mill_name,
                                            periode,
                                            selisih,
                                            jumlah 
                                        ) b 
                                    GROUP BY
                                        periode 
                                    ) 
                                GROUP BY
                                    mill_id,
                                    mill_name,
                                    periode,
                                    selisih,
                                    jumlah 
                                ) e 
                            WHERE
                                jumlah = makmak 
                            GROUP BY
                                mill_id,
                                mill_name,
                                periode 
                            ) y ON x.mill_id= y.mill_id 
                            AND x.mill_name= y.mill_name 
                            AND x.periode= y.periode 
                        GROUP BY
                            x.mill_id,
                            x.mill_name,
                            x.periode,
                            y.selisih 
                        ORDER BY
                            x.periode"));

        return response()->json($data);


    }

    public function chartDelivDaily(Request $request){

        $mill = $request->mill;
        $division = $request->division;
        $mach_type = $request->mach_type;
        $periode = $request->periode;

        $where = "where mill_id = '$mill' and Periode = '$periode'";

        if ($division){
            $where .= " and divisi = '$division'";
        }

        if ($mach_type){
            $where .= " and mach_type = '$mach_type'";
        }

        $data = DB::connection("sqlsrv2")
                    ->select(DB::raw("
                    SELECT DISTINCT
                        mill_id,
                        mill_name,
                        periode,
                        Order_id,
                        deliv_id,
                        FORMAT(ship_date, 'dd MMM yyyy') as ship_date,
                        FORMAT(dt_rcv, 'dd MMM yyyy') as dt_rcv,
                        CAST ( datediff( DAY, dt_rcv, ship_date ) AS FLOAT ) selisih
                    FROM view_deliv $where
                    group by mill_id, mill_name, periode, Order_id, deliv_id, ship_date, dt_rcv"));

        return \DataTables::of($data)
        ->make(true);


        // $data = DB::connection("sqlsrv2")
        //             ->select(DB::raw("
        //             SELECT
        //                 mill_id,
        //                 mill_name,
        //                 FORMAT(ship_date, 'dd MMM yyyy') as ship_date,
        //                 COUNT ( deliv_id ) tot_ship,
        //                 round( AVG ( ot_ship ), 2 ) ot_ship,
        //                 round( AVG ( real_ship ), 2 ) real_ship,
        //                 round( AVG ( pct_ot ), 2 ) pct_ot,
        //                 round( AVG ( pct_real ), 2 ) pct_real
        //             FROM
        //                 (
        //                 SELECT DISTINCT
        //                     mill_id,
        //                     mill_name,
        //                     deliv_id,
        //                     dt_rcv,
        //                     dateadd( DAY, 3, dt_rcv ) ot_date,
        //                     req_ship_date,
        //                     ship_date,
        //                     CAST ( datediff( DAY, dateadd( DAY, 3, dt_rcv ), ship_date ) AS FLOAT ) ot_ship,
        //                 CASE

        //                         WHEN datediff( DAY, dateadd( DAY, 3, dt_rcv ), ship_date ) <= 0 THEN
        //                         100
        //                         WHEN datediff( DAY, dateadd( DAY, 3, dt_rcv ), ship_date ) >= 30 THEN
        //                         0 ELSE ( CAST ( ( 30 - datediff( DAY, dateadd( DAY, 3, dt_rcv ), ship_date ) ) AS FLOAT ) / 30 ) * 100
        //                     END AS pct_ot,
        //                     CAST ( datediff( DAY, req_ship_date, ship_date ) AS FLOAT ) real_ship,
        //                 CASE

        //                         WHEN datediff( DAY, req_ship_date, ship_date ) <= 0 THEN
        //                         100
        //                         WHEN datediff( DAY, req_ship_date, ship_date ) >= 30 THEN
        //                         0 ELSE ( CAST ( ( 30 - datediff( DAY, req_ship_date, ship_date ) ) AS FLOAT ) / 30 ) * 100
        //                     END AS pct_real
        //                 FROM
        //                     view_deliv
        //                 $where
        //                 ) x
        //             GROUP BY
        //                 mill_id,
        //                 mill_name,
        //                 ship_date
        //             ORDER BY
        //                 ship_date"));

        // return response()->json($data);



    }


}
