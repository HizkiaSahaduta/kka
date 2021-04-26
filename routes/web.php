<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('home');
});

Auth::routes([
    'register' => false,
    'reset' => false,
    'password' => false,
    'verify' => false,
  ]);

Route::get('ChangeDefaultPassword', 'ChangeDefaultPasswordController@index');
Route::post('ChangeDefPass', 'ChangeDefaultPasswordController@ChangeDefPass');


/*---------------------------------------------------------------------------------------------------------------------------------------------*/
//Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index')->name('home');

//-- Dashboard
Route::post('ProduksiSum', 'HomeController@ProduksiSum');
Route::post('ProduksiSumCustGroup', 'HomeController@ProduksiSumCustGroup');
Route::post('ProduksiSumPrevMonth', 'HomeController@ProduksiSumPrevMonth');
Route::post('ProduksiSumCurrMonth', 'HomeController@ProduksiSumCurrMonth');
Route::get('listCustGroup', 'HomeController@listCustGroup');

/*---------------------------------------------------------------------------------------------------------------------------------------------*/
//-- PO Confirm
Route::get('POConfirm', 'POConfirmController@index')->name('POConfirm');
Route::post('getPOHdr', 'POConfirmController@getPOHdr');
Route::post('getPODtl', 'POConfirmController@getPODtl');
Route::post('setApprove', 'POConfirmController@setApprove');
Route::post('setReject', 'POConfirmController@setReject');
//Route::post('setUnApprove', 'POConfirmController@setUnApprove');

//-- DN Confirm
Route::get('DNConfirm', 'DNConfirmController@index')->name('DNConfirm');
Route::post('getDNHdr', 'DNConfirmController@getDNHdr');
Route::post('getDNDtl', 'DNConfirmController@getDNDtl');
Route::post('setDelivConfirm', 'DNConfirmController@setDelivConfirm');

//-- User Mgmt
Route::get('MyAccount', 'MyAccountController@index')->name('MyAccount');
Route::get('ChangePass', 'ChangePassController@index')->name('ChangePass');
Route::post('ActChangePass', 'ChangePassController@ActChangePass')->name('ActChangePass');
Route::get('AddUser', 'AddUserController@index')->name('AddUser');
Route::post('listUser', 'AddUserController@listUser')->name('listUser');
Route::post('saveUser', 'AddUserController@saveUser')->name('saveUser');
Route::get('getUser/id={id}&id2={id2}', 'AddUserController@getUser');
Route::get('delUser/id={id}&id2={id2}', 'AddUserController@delUser');
Route::post('editUser', 'AddUserController@editUser')->name('editUser');
Route::get('AddSales', 'AddSalesController@index')->name('AddSales');
Route::post('saveSales', 'AddSalesController@saveSales')->name('saveSales');

// JSON Downtime Analysis
Route::get('listMillDowntime', 'JSONController@listMillDowntime');
Route::get('listDivisionDowntime', 'JSONController@listDivisionDowntime');
Route::get('listMachTypeMillDowntime/mill={mill}', 'JSONController@listMachTypeMillDowntime');
Route::get('listMachTypeMillDivDowntime/mill={mill}&div={div}', 'JSONController@listMachTypeMillDivDowntime');
Route::get('listMachIDTypeDowntime/mill={mill}&type={type}', 'JSONController@listMachIDTypeDowntime');

// JSON Deliv Analysis
Route::get('listMillDeliv', 'JSONController@listMillDeliv');
Route::get('listDivisionDeliv', 'JSONController@listDivisionDeliv');
Route::get('listMachTypeMillDeliv/mill={mill}', 'JSONController@listMachTypeMillDeliv');
Route::get('listMachTypeMillDivDeliv/mill={mill}&div={div}', 'JSONController@listMachTypeMillDivDeliv');

// JSON Order Analysis
Route::get('listDivisionOrder', 'JSONController@listDivisionOrder');
Route::get('listAllCustomer', 'JSONController@listAllCustomer')->name('listAllCustomer');
Route::get('listBrand', 'JSONController@listBrand');

// JSON Sales
Route::get('listDeptSales', 'JSONController@listDeptSales');
Route::get('listCitySales', 'JSONController@listCitySales');
Route::get('listDivisionSales', 'JSONController@listDivisionSales');
Route::get('listRegionSales', 'JSONController@listRegionSales');
Route::get('listSalesOffice', 'JSONController@listSalesOffice');
Route::get('listBranchHead/id={id}', 'JSONController@listBranchHead');
Route::get('listBankSales', 'JSONController@listBankSales');
Route::get('getCust', 'JSONController@getCust');
Route::get('getCustDetails/id={id}', 'JSONController@getCustID');
Route::get('checkRegion/id={id}', 'JSONController@checkRegion');
Route::get('getSalesByOffice/id={id}', 'JSONController@getSalesByOffice');
Route::get('checkSalesId/id={id}', 'JSONController@checkSalesId');

// JSON Piutang
Route::get('searchCustomer', 'JSONController@searchCustomer');
Route::get('getSalesman', 'JSONController@getSalesman');

// JSON Quality Performance
Route::get('listDivisionQP', 'JSONController@listDivisionQP');
Route::get('listQualityQP', 'JSONController@listQualityQP');
Route::get('listMachTypeMillQP/mill={mill}', 'JSONController@listMachTypeMillQP');
Route::get('listMachTypeMillDivQP/mill={mill}&div={div}', 'JSONController@listMachTypeMillDivQP');
Route::get('listMachIDMillType/mill={mill}&type={type}', 'JSONController@listMachIDMillType');

// JSON Performance
Route::get('searchSP', 'JSONController@searchSP');
Route::get('listItemDescr/txtSP={txtSP}', 'JSONController@listItemDescr');
Route::get('listSP/txtMill={txtMill}', 'JSONController@listSP');

//-- DownTime Analysis
Route::get('DowntimeAnalysis', 'DownTimeController@index')->name('DowntimeAnalysis');
Route::post('chartDownTime', 'DownTimeController@chartDownTime');
Route::post('chartDownTimeClass', 'DownTimeController@chartDownTimeClass');
Route::post('chartDownTimeDetail', 'DownTimeController@chartDownTimeDetail');
Route::post('chartDownTimeDaily', 'DownTimeController@chartDownTimeDaily');
Route::post('chartDownTimeClassDaily', 'DownTimeController@chartDownTimeClassDaily');
Route::post('chartDownTimeDetailDaily', 'DownTimeController@chartDownTimeDetailDaily');

//-- Deliv Analysis
Route::get('DelivAnalysis', 'DelivController@index')->name('DelivAnalysis');
Route::post('chartDeliv', 'DelivController@chartDeliv');
Route::post('chartDelivDaily', 'DelivController@chartDelivDaily');

//-- Order Analysis
Route::get('OrderAnalysis', 'OrderAnalysisController@index')->name('OrderAnalysis');
Route::post('chartOrderAnalysis', 'OrderAnalysisController@chartOrderAnalysis');
Route::post('chartOrderAnalysisByBrand', 'OrderAnalysisController@chartOrderAnalysisByBrand');
Route::post('chartOrderAnalysisByClass', 'OrderAnalysisController@chartOrderAnalysisByClass');
Route::post('chartOrderAnalysisByCust', 'OrderAnalysisController@chartOrderAnalysisByCust');

Route::post('chartProdAnalysisByBrand', 'OrderAnalysisController@chartProdAnalysisByBrand');
Route::post('chartProdAnalysisByClass', 'OrderAnalysisController@chartProdAnalysisByClass');
Route::post('chartProdAnalysisByCust', 'OrderAnalysisController@chartProdAnalysisByCust');

Route::post('chartShipAnalysisByBrand', 'OrderAnalysisController@chartShipAnalysisByBrand');
Route::post('chartShipAnalysisByClass', 'OrderAnalysisController@chartShipAnalysisByClass');
Route::post('chartShipAnalysisByCust', 'OrderAnalysisController@chartShipAnalysisByCust');


//-- Sales Activity
Route::get('TodayVisit', 'TodayVisitController@index')->name('TodayVisit');
Route::post('getTodayVisit', 'TodayVisitController@getTodayVisit')->name('getTodayVisit');
Route::post('listSales', 'AddSalesController@listSales')->name('listSales');
Route::get('CustomerVisit', 'CustomerVisitController@index')->name('CustomerVisit');
Route::post('storeActivity', 'CustomerVisitController@storeActivity');
Route::get('checkLastVisit', 'CustomerVisitController@checkLastVisit');
Route::get('VisitReport', 'VisitReportController@index')->name('VisitReport');
Route::post('GetVisit', 'VisitReportController@GetVisit');


//-- Material Availability
Route::get('MaterialAvailability', 'MaterialAvailabilityController@index')->name('MaterialAvailability');
Route::post('find_mats', 'MaterialAvailabilityController@find_mats');

//-- Shipping Report
Route::get('ShippingReport', 'ShippingReportController@index')->name('ShippingReport');
Route::post('chartShippingReport', 'ShippingReportController@chartShippingReport');
Route::post('chartShippingReportbyMill', 'ShippingReportController@chartShippingReportbyMill');
Route::post('chartShippingReportbyCust', 'ShippingReportController@chartShippingReportbyCust');

//-- Shipping Report
Route::get('Piutang', 'PiutangController@index')->name('Piutang');
Route::post('getAllSummaryPiutang', 'PiutangController@getAllSummaryPiutang');
Route::post('getSummaryPiutang', 'PiutangController@getSummaryPiutang');
Route::post('getOverviewPiutang', 'PiutangController@getOverviewPiutang');

// Quality Performance
Route::get('QualityPerformance', 'QualityPerformanceController@index')->name('QualityPerformance');
Route::post('chartQPRatio', 'QualityPerformanceController@chartQPRatio');
Route::post('chartQPRatioDaily', 'QualityPerformanceController@chartQPRatioDaily');
Route::post('chartQPRatioPctPeriodic', 'QualityPerformanceController@chartQPRatioPctPeriodic');
Route::post('chartQPRatioPctDaily', 'QualityPerformanceController@chartQPRatioPctDaily');

//-- Data Logger ProductionMonitoring
Route::get('DataloggerMonitor', 'DataloggerMonitorController@index')->name('DataloggerMonitor');
Route::get('ProductionLoggerMach', 'DataloggerMonitorController@ProductionLoggerMach');
Route::get('ProductionLoggerMachId', 'DataloggerMonitorController@ProductionLoggerMachId');
Route::post('populateProductionCutting', 'DataloggerMonitorController@populateProductionCutting');
Route::post('populateProductionCuttingDetail', 'DataloggerMonitorController@populateProductionCuttingDetail');

//-- Data Logger Machine Status
Route::get('DataloggerStatus', 'DataloggerStatusController@index')->name('DataloggerStatus');
Route::get('DataloggerLiveStatus', 'DataloggerStatusController@DataloggerLiveStatus');

//-- Data Logger Per Shift
Route::get('DataloggerPerShift', 'DataloggerPerShiftController@index')->name('DataloggerPerShift');
Route::post('FindDataloggerPerShift', 'DataloggerPerShiftController@FindDataloggerPerShift');
Route::post('DataPerShiftDetail', 'DataloggerPerShiftController@DataPerShiftDetail');
Route::post('DataPerShiftDetailKKA', 'DataloggerPerShiftController@DataPerShiftDetailKKA');

//-- Mach. Order Capacity
Route::get('MachOrderCapacity', 'MachOrderCapacityController@index')->name('MachOrderCapacity');
Route::get('getMachID', 'MachOrderCapacityController@getMachID');
Route::post('FindOrderCapacity', 'MachOrderCapacityController@FindOrderCapacity');
Route::post('FindOrderCapacityGraph', 'MachOrderCapacityController@FindOrderCapacityGraph');

//-- BLANK PAGE
Route::get('blank', 'BlankController@index')->name('blank');
Route::get('populateTest', 'BlankController@populateTest');


//--Performance Analysis
Route::get('PerformanceAnalysis', 'PerformanceAnalysisController@index')->name('PerformanceAnalysis');
Route::post('chartPerformanceAnalysis', 'PerformanceAnalysisController@chartPerformanceAnalysis');
Route::post('chartPerformanceAnalysisDailySum', 'PerformanceAnalysisController@chartPerformanceAnalysisDailySum');
Route::post('detailPerformanceAnalysisDaily', 'PerformanceAnalysisController@detailPerformanceAnalysisDaily');