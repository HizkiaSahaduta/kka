<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class JSONController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    // Downtime
    public function listMillDowntime(){

        if (Session::has('MILLID')){

            $result = DB::connection('sqlsrv3')
                            ->table('mill')
                            ->selectRaw('LTRIM(RTRIM(mill_id)) as mill_id, LTRIM(RTRIM(mill_name)) as mill_name')
                            ->where('mill_id', '=', Session::get('MILLID'))
                            ->where('active_flag', '=', 'Y')
                            ->where('mill_type', '=', 'M')
                            ->orderBy('mill_type', 'desc')
                            ->get();
            return response()->json($result);
        }
        else {

            $result = DB::connection('sqlsrv3')
                            ->table('mill')
                            ->selectRaw('LTRIM(RTRIM(mill_id)) as mill_id, LTRIM(RTRIM(mill_name)) as mill_name')
                            ->where('active_flag', '=', 'Y')
                            ->where('mill_type', '=', 'M')
                            ->orderBy('mill_type', 'desc')
                            ->get();
            return response()->json($result);

        }    
    }

    public function listDivisionDowntime(){

        $result = DB::connection("sqlsrv2")
                ->table('view_downtime')
                ->select('view_downtime.Divisi', 'division.descr')
                ->join('division', 'view_downtime.Divisi', '=', 'division.class')
                ->distinct()
                ->orderBY('division.descr')
                ->get();

        return response()->json($result);

    }

    public function listMachTypeMillDowntime($mill){

        $result =DB::connection("sqlsrv2")
                ->table('view_downtime')
                ->select('mach_type', 'mach_descr')
                ->where('mill_id', '=', $mill)
                ->distinct()
                 ->orderBy('mach_type')
                ->get();

        return response()->json($result);

    }

    public function listMachTypeMillDivDowntime($mill, $div){

        $result =DB::connection("sqlsrv2")
                ->table('view_downtime')
                ->select('mach_type','mach_descr')
                ->where('mill_id', '=', $mill)
                ->where('divisi', '=', $div)
                ->distinct()
                ->orderBy('mach_type')
                ->get();

        return response()->json($result);

    }

    public function listMachIDTypeDowntime($mill, $type){

        $result =DB::connection("sqlsrv2")
                ->table('view_downtime')
                ->select('mach_id', 'mach_id_desc')
                ->where('mill_id', '=', $mill)
                ->where('mach_type', '=', $type)
                ->distinct()
                ->orderBy('mach_id')
                ->get();

        return response()->json($result);

    }

    // Deliv

    public function listMillDeliv(){

        if (Session::has('MILLID')){

            $result = DB::connection('sqlsrv3')
                            ->table('mill')
                            ->select('mill_id', 'mill_name')
                            ->where('mill_id', '=', Session::get('MILLID'))
                            ->where('active_flag', '=', 'Y')
                            ->where('mill_type', '=', 'M')
                            ->orderBy('mill_type', 'desc')
                            ->get();
            return response()->json($result);
        }
        else {

            $result = DB::connection('sqlsrv3')
                            ->table('mill')
                            ->select('mill_id', 'mill_name')
                            ->where('active_flag', '=', 'Y')
                            ->where('mill_type', '=', 'M')
                            ->orderBy('mill_type', 'desc')
                            ->get();
            return response()->json($result);

        }    
    }

    public function listDivisionDeliv(){

        $result =DB::connection("sqlsrv2")
                ->table('view_deliv')
                ->selectRaw('LTRIM(RTRIM(view_deliv.divisi)) as divisi, LTRIM(RTRIM(division.descr)) as descr')
                ->join('division', 'view_deliv.divisi', '=', 'division.class')
                ->distinct()
                ->orderBy('descr')
                ->get();

        return response()->json($result);

    }

    public function listMachTypeMillDeliv($mill){

        $result =DB::connection("sqlsrv2")
                ->table('view_deliv')
                ->selectRaw('LTRIM(RTRIM(mach_type)) as mach_type, LTRIM(RTRIM(mesin)) as mesin')
                ->where('mill_id', '=', $mill)
                ->distinct()
                ->orderBY('mach_type')
                ->get();

        return response()->json($result);

    }

    public function listMachTypeMillDivDeliv($mill, $div){

        $result =DB::connection("sqlsrv2")
                ->table('view_deliv')
                ->selectRaw('LTRIM(RTRIM(mach_type)) as mach_type, LTRIM(RTRIM(mesin)) as mesin')
                ->where('mill_id', '=', $mill)
                ->where('divisi', '=', $div)
                ->distinct()
                ->orderBy('mach_type')
                ->get();

        return response()->json($result);

    }

    // Sales

    public function listDeptSales(){

        $result =DB::table('sec_group')
                ->select('group_id')
                ->whereIn('group_id', ['SALES', 'KACAB', 'RM'])
                ->distinct()
                ->get();

        return response()->json($result);

    }

    public function listCitySales(){

        $result =DB::connection("sqlsrv2")
                ->table('sales')
                ->select('kota')
                ->distinct()
                ->orderBY('kota')
                ->get();

        return response()->json($result);


    }

    public function listDivisionSales(){

        $result =DB::connection("sqlsrv2")
                ->table('division')
                ->select('class', 'descr')
                ->where('active_flag',  '=', 'Y')
                ->get();

        return response()->json($result);


    }

    public function listRegionSales(){

        $result =DB::connection("sqlsrv2")
                ->table('sales')
                ->select('region')
                ->where('active_flag',  '=', 'Y')
                ->distinct()
                ->get();

        return response()->json($result);

    }

    public function listSalesOffice(){

        $result =DB::connection("sqlsrv2")
                ->table('branch_office')
                ->select('office_id','office')
                ->where('pt_id',  '=', 'KKA')
                ->where('active_flag',  '=', 'Y')
                ->get();

        return response()->json($result);

    }

    public function listBranchHead($id){

        $result =DB::connection("sqlsrv2")
                ->table('branch_office')
                ->selectRaw('LTRIM(RTRIM(branch_office.ka_cab)) as ka_cab,  LTRIM(RTRIM(sales.namasales)) as namasales')
                ->join('sales', 'branch_office.ka_cab', '=', 'sales.salesid')
                ->where ('branch_office.office_id', '=', $id)
                ->where ('branch_office.pt_id', '=', 'KKA')
                ->where('sales.active_flag',  '=', 'Y')
                ->get();

        return response()->json($result);

    }

    public function listBankSales(){

        $result =DB::connection("sqlsrv2")
                ->table('account')
                ->select('bank_name')
                ->distinct()
                ->get();

        return response()->json($result);


    }

    public function checkRegion($id){

        $result =DB::connection("sqlsrv2")
                ->table('branch_office')
                ->selectRaw('LTRIM(RTRIM(branch_office.rm)) as rm')
                ->where ('office_id', '=', $id)
                ->value('rm');

        return response()->json($result);

    }

    public function getCust(Request $request){
        $search = $request->get('term');
        $result = DB::connection('sqlsrv2')
                    ->table('customer')
                    ->Where('NamaCustomer', 'LIKE', '%'. $search. '%')
					->where('active_flag', '=', 'Y')
                    ->orWhere("CustomerId", "=",  $search  )
                    ->take(25)
                    ->get();
        return response()->json($result);
    }

    public function getCustID($id){
        $result = DB::connection('sqlsrv2')
                    ->table('customer')
                    ->Where('CustomerId', '=', $id)
                    ->first();
                    
        return response()->json($result);
    }

    public function getSalesByOffice($id){
        
        if($id != 0)
        {
            $result = DB::connection('sqlsrv2')
                        ->table('Sales')
                        ->select('SalesId', 'NamaSales')
                        ->where('office_id', '=', $id)
                        ->where('pt_id', '=', 'KKA')
                        ->where('active_flag','=','Y')
                        ->get();
            return response()->json($result);
        }
        else
        {
            $result = DB::connection('sqlsrv2')
                        ->table('Sales')
                        ->select('SalesId', 'NamaSales')
                        ->where('pt_id', '=', 'KKA')
                        ->where('active_flag','=','Y')
                        ->get();
            return response()->json($result);
        }
    }

    public function checkSalesId($id){
        $result = DB::connection('sqlsrv2')
                    ->table('sales')
                    ->Where('salesid', '=', $id)
                    ->value('salesid');

        return response()->json($result);
    }

    // Order Analysis

    public function listDivisionOrder(){

        $result = DB::connection("sqlsrv2")
                ->table('view_order_sum')
                ->select('view_order_sum.class', 'division.descr')
                ->join('division', 'view_order_sum.class', '=', 'division.class')
                ->where('view_order_sum.mill_id', '=', 'KP')
                ->distinct()
                ->orderBY('division.descr')
                ->get();

        return response()->json($result);

    }

    public function listAllCustomer (Request $request) {

        $search = $request->get('term');
        $result = DB::connection('sqlsrv2')
                    ->table('View_order_sum')
                    ->selectRaw('LTRIM(RTRIM(CustomerID)) as CustomerID, LTRIM(RTRIM(NamaCustomer)) as NamaCustomer')
                    ->where('NamaCustomer', 'LIKE', '%'. $search. '%')
                    ->orWhere('CustomerID', '=',  $search )
                    ->distinct()
                    ->get();

        return response()->json($result);

    }

    public function listBrand(){

        $result = DB::connection("sqlsrv2")
                    ->select(DB::raw("
                    SELECT
                    CASE
                        WHEN brand_id = ' ' THEN 'OTHER'
                            ELSE brand_id
                    END as brand_id
                    FROM view_order_sum
                    group by brand_id"));

        return response()->json($result);




    }

    // Piutang

    public function searchCustomer(Request $request){
        $search = $request->get('term');
        $result = DB::connection('sqlsrv2')
                    ->table('v_piutang')
                    ->selectRaw('distinct(CustomerId), NamaCustomer')
                    ->where('NamaCustomer', 'LIKE', '%'. $search. '%')
                    ->orWhere('CustomerId', '=',  $search )
                    ->get();

        return response()->json($result);
    }

    public function getSalesman (Request $request) {

        $result = DB::connection("sqlsrv2")
                ->table('v_piutang')
                ->select('SalesId', 'NamaSales')
                ->distinct()
                ->orderBY('NamaSales')
                ->get();

        return response()->json($result);

    }

    // Quality Performance

    public function listDivisionQP(){

        $result = DB::connection("sqlsrv2")
                ->table('division')
                ->select('class', 'descr')
                ->orderBY('class')
                ->get();

        return response()->json($result);

    }

    public function listQualityQP(){

        $result = DB::connection("sqlsrv2")
                ->table('BarangJadi')
                ->select('grade')
                ->distinct()
                ->orderBY('grade')
                ->get();

        return response()->json($result);

    }

    public function listMachTypeMillQP($mill){

        $result =DB::connection("sqlsrv2")
            ->table('machine_type')
            ->selectRaw('LTRIM(RTRIM(mach_type)) as mach_type, LTRIM(RTRIM(descr)) as descr')
            ->where('mill_id', '=', $mill)
            ->orderBy('mach_type')
            ->get();

        return response()->json($result);

    }

    public function listMachTypeMillDivQP($mill, $div){

        $result =DB::connection("sqlsrv2")
            ->table('machine_type')
            ->selectRaw('LTRIM(RTRIM(mach_type)) as mach_type, LTRIM(RTRIM(descr)) as descr')
            ->where('mill_id', '=', $mill)
            ->where('class', '=', $div)
            ->orderBy('mach_type')
            ->get();

        return response()->json($result);

    }

    public function listMachIDMillType($mill, $type){

        $result =DB::connection("sqlsrv2")
            ->table('machine_id')
            ->selectRaw('LTRIM(RTRIM(mach_id)) as mach_id, LTRIM(RTRIM(descr)) as descr')
            ->where('mill_id', '=', $mill)
            ->where('mach_type', '=', $type)
            ->orderBy('mach_id')
            ->get();

        return response()->json($result);

    }
    
    // Performance Analysis

    public function searchSP(Request $request){
        $search = $request->get('term');
        $result = DB::connection('sqlsrv2')
                    ->table('View_wh_perform')
                    ->select('CustomerOrderNo')
                    ->where('CustomerOrderNo', 'LIKE', '%'. $search. '%')
                    ->groupBy('CustomerOrderNo')
                    ->get();

        return response()->json($result);
    }

    public function listSP($txtMill){

        $result = DB::connection("sqlsrv2")
                ->table('View_wh_perform')
                ->select('CustomerOrderNo')
                ->where('mill_id', '=', $txtMill)
                ->orderBy('CustomerOrderNo')
                ->get();

        return response()->json($result);

    }

    public function listItemDescr($txtSP){

        $result = DB::connection("sqlsrv2")
                ->table('View_wh_perform')
                ->select('item_num', 'NamaBarang')
                ->where('CustomerOrderNo', '=', $txtSP)
                ->orderBy('item_num')
                ->get();

        return response()->json($result);

    }







}
