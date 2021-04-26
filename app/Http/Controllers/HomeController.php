<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Cache;
use App\User;
use Hash;
use Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function index(){

        $year =  Carbon::now()->year;
        $prev_year =  Carbon::now()->subYear()->year;
        $curr_month =  Carbon::now()->month;
        $prev_month = Carbon::now()->subMonth()->month;
        $prev_monthName = date('F', mktime(0, 0, 0, Carbon::now()->subMonth()->month, 10));
        $curr_monthName = date('F', mktime(0, 0, 0, Carbon::now()->month, 10));

        $groupid = Session::get('GROUPID');

        return view('layouts.home', [
                    'prev_month' => $prev_month,
                    'curr_month' => $curr_month,
                    'year' => $year,
                    'prev_year' => $prev_year,
                    'prev_monthName' => $prev_monthName,
                    'curr_monthName' => $curr_monthName]);
}

    public static function getMonthName($monthNumber){

        return date("F", mktime(0, 0, 0, $monthNumber, 1));

    }

    public function ProduksiSum(Request $request){

        $curr_year = $request->curr_year;
        $prev_year = $request->prev_year;

        if (Session::has('MILLID')){

            $data = DB::connection("sqlsrv2")
                    ->table('View_order_produksi')
                    ->selectRaw("month, year, periode,
                                case
                                    WHEN month = 1 then 'Jan'
                                    WHEN month = 2 then 'Feb'
                                    WHEN month = 3 then 'Mar'
                                    WHEN month = 4 then 'Apr'
                                    WHEN month = 5 then 'May'
                                    WHEN month = 6 then 'Jun'
                                    WHEN month = 7 then 'Jul'
                                    WHEN month = 8 then 'Aug'
                                    WHEN month = 9 then 'Sep'
                                    WHEN month = 10 then 'Oct'
                                    WHEN month = 11 then 'Nov'
                                    ELSE 'Dec'
                                END AS bulan,
                                round(cast(sum(wgt_prod)/1000 as float), 2) as wgt_prod")
                    ->whereBetween('year',[$prev_year, $curr_year])
                    ->where('mill_id', '=', Session::get('MILLID'))
                    ->groupBy('month', 'year', 'periode')
                    ->orderBy('month')
                    ->orderBy('year')
                    ->get();

            return response()->json($data);
        }
        else {

             $data = DB::connection("sqlsrv2")
                    ->table('View_order_produksi')
                    ->selectRaw("month, year, periode,
                                case
                                    WHEN month = 1 then 'Jan'
                                    WHEN month = 2 then 'Feb'
                                    WHEN month = 3 then 'Mar'
                                    WHEN month = 4 then 'Apr'
                                    WHEN month = 5 then 'May'
                                    WHEN month = 6 then 'Jun'
                                    WHEN month = 7 then 'Jul'
                                    WHEN month = 8 then 'Aug'
                                    WHEN month = 9 then 'Sep'
                                    WHEN month = 10 then 'Oct'
                                    WHEN month = 11 then 'Nov'
                                    ELSE 'Dec'
                                END AS bulan,
                                round(cast(sum(wgt_prod)/1000 as float), 2) as wgt_prod")
                    ->whereBetween('year',[$prev_year, $curr_year])
                    ->groupBy('month', 'year', 'periode')
                    ->orderBy('month')
                    ->orderBy('year')
                    ->get();

            return response()->json($data);

        }
    }

    public function ProduksiSumCustGroup(Request $request){

        $year = $request->year;
        $month = $request->month;

        if (Session::has('MILLID')){

            $data = DB::connection("sqlsrv2")
                    ->table('View_order_produksi')
                    ->selectRaw("month, year, periode,
                                case
                                    WHEN custGroup = 'LAIN' then 'OTHER'
                                    else custGroup
                                END AS custGroup,
                                case
                                    WHEN month = 1 then 'JAN'
                                    WHEN month = 2 then 'FEB'
                                    WHEN month = 3 then 'MAR'
                                    WHEN month = 4 then 'APR'
                                    WHEN month = 5 then 'MAY'
                                    WHEN month = 6 then 'JUN'
                                    WHEN month = 7 then 'JUL'
                                    WHEN month = 8 then 'AUG'
                                    WHEN month = 9 then 'SEP'
                                    WHEN month = 10 then 'OCT'
                                    WHEN month = 11 then 'NOV'
                                    ELSE 'DEC'
                                END AS bulan,
                                round(cast(sum(wgt_prod)/1000 as float), 2) as wgt_prod")
                    // ->whereBetween('year',[$prev_year, $curr_year])
                    ->where('year', '=', $year)
                    ->where('month', '=', $month)
                    ->where('mill_id', '=', Session::get('MILLID'))
                    ->groupBy('month', 'year', 'periode', 'custGroup')
                    ->orderBy('month')
                    ->orderBy('year')
                    ->get();

            return response()->json($data);
        }
        else {

            $data = DB::connection("sqlsrv2")
                    ->table('View_order_produksi')
                    ->selectRaw("month, year, periode,
                                case
                                    WHEN custGroup = 'LAIN' then 'OTHER'
                                    else custGroup
                                END AS custGroup,
                                case
                                    WHEN month = 1 then 'JAN'
                                    WHEN month = 2 then 'FEB'
                                    WHEN month = 3 then 'MAR'
                                    WHEN month = 4 then 'APR'
                                    WHEN month = 5 then 'MAY'
                                    WHEN month = 6 then 'JUN'
                                    WHEN month = 7 then 'JUL'
                                    WHEN month = 8 then 'AUG'
                                    WHEN month = 9 then 'SEP'
                                    WHEN month = 10 then 'OCT'
                                    WHEN month = 11 then 'NOV'
                                    ELSE 'DEC'
                                END AS bulan,
                                round(cast(sum(wgt_prod)/1000 as float), 2) as wgt_prod")
                    // ->whereBetween('year',[$prev_year, $curr_year])
                    ->where('year', '=', $year)
                    ->where('month', '=', $month)
                    ->groupBy('month', 'year', 'periode', 'custGroup')
                    ->orderBy('month')
                    ->orderBy('year')
                    ->get();

            return response()->json($data);

        }
    }

    public function ProduksiSumCurrMonth(Request $request){

        $curr_year = $request->curr_year;
        $curr_month = $request->curr_month;

        $data = DB::connection("sqlsrv2")
                    ->select(DB::raw("select a.mill_id, b.mill_name, a.month, a.year, round(cast(sum(a.wgt_prod)/1000 as float), 2) as wgt_prod from View_order_produksi a 
                    inner join mill b on a.mill_id = b.mill_id
                    where month = '$curr_month' and year = '$curr_year'
                    group by a.mill_id, b.mill_name, a.month, a.year"));

        return response()->json($data);

    }

    public function ProduksiSumPrevMonth(Request $request){

        $curr_year = $request->curr_year;
        $prev_month = $request->prev_month;

        if ($prev_month = 12) {
            $curr_year = Carbon::now()->subYear()->year;
        }

        $data = DB::connection("sqlsrv2")
                    ->select(DB::raw("select a.mill_id, b.mill_name, a.month, a.year, round(cast(sum(a.wgt_prod)/1000 as float), 2) as wgt_prod from View_order_produksi a 
                    inner join mill b on a.mill_id = b.mill_id
                    where month = '$prev_month' and year = '$curr_year'
                    group by a.mill_id, b.mill_name, a.month, a.year"));
            
            

        return response()->json($data);

    }

    public function listCustGroup(){

        $data = DB::connection("sqlsrv2")
                ->table('View_order_produksi')
                ->select('custGroup')
                ->distinct()
                ->get();

        return response()->json($data);
    }




}
