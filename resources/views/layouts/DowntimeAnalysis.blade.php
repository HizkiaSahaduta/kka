@extends('main')

{{-- Content Page CSS Begin--}}
@section('contentcss')
<link href="{{ asset('outside/plugins/notification/snackbar/snackbar.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('outside/plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/style.css">
<link href="{{ asset('outside/assets/css/components/tabs-accordian/custom-tabs.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/select2/select2.min.css') }}">
<style>
.badge {
  background: transparent;
}

.badge-info {
    position: absolute;
    font-size: 9px;
    right: 2%;
    color: #2196f3;
    border: 1px dashed;
}

.badge-success {
    position: absolute;
    font-size: 9px;
    right: 2%;
    color: #8dbf42;
    border: 1px dashed;
}

.badge-danger {
    position: absolute;
    font-size: 9px;
    right: 2%;
    color: #e7515a;
    border: 1px dashed;
}

</style>
@endsection
{{-- Content CSS End--}}

{{-- Content Navbar Content Begin--}}
@section('navbar_content')
<div class="sub-header-container">
    <header class="header navbar navbar-expand-sm">
        <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a>

        <ul class="navbar-nav flex-row">
            <li>
                <div class="page-header">
                    <nav class="breadcrumb-one" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">KKA System</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('DowntimeAnalysis') }}">Downtime Analysis</a></li>
                        </ol>
                    </nav>
                </div>
            </li>
        </ul>

        <ul class="navbar-nav flex-row ml-auto ">
			<li class="nav-item more-dropdown">
				<div class="dropdown  custom-dropdown-icon">
					<a class="dropdown-toggle btn" href="#" role="button" id="customDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span>Hello, {{ Auth::user()->name1 }}</span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></a>

					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="customDropdown">

                        @if(session()->has('mnuMyAccount'))
                        <a class="dropdown-item" data-value="UserProfile" href="{{ url('MyAccount') }}">My Account</a>
                        @endif

                        @if(session()->has('mnuMyAccount'))
                        <a class="dropdown-item" data-value="UserProfile" href="{{ url('ChangePass') }}">Change Password</a>
                        @endif

						<a class="dropdown-item" data-value="Logout" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Log Out</a>
					</div>

					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						{{ csrf_field() }}
					</form>

				</div>
			</li>
        </ul>

    </header>
</div>
@endsection
{{-- Content Navbar Content End--}}


{{-- Content Page Begin--}}
@section('content')
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Downtime Report Analys</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">

                    <div class="form-row mb-6">
                        <div class="form-group col-md-5">
                            <label class="text-dark" for="mill">Mill</label>
                            <div id="mill_loading">
                            <select class="form-control basic" name="mill" id="mill">
                                <option></option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group col-md-5">
                            <label class="text-dark" for="division">Division</label>
                            <div id="div_loading">
                            <select class="form-control basic" name="division" id="division">
                                <option></option>
                            </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row mb-6">
                        <div class="form-group col-md-5">
                            <label class="text-dark" for="mach_type">Mach Type</label>
                            <a id="mach_type_badge"><span class="badge badge-danger">N/A</span></a>
                            <div id="mach_type_loading">
                            <select class="form-control basic" name="mach_type" id="mach_type">
                                <option></option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group col-md-5">
                            <label class="text-dark" for="mach_id">Mach ID</label>
                            <a id="mach_id_badge"><span class="badge badge-danger">N/A</span></a>
                            <div id="mach_id_loading">
                            <select class="form-control basic" name="mach_id" id="mach_id">
                                <option></option>
                            </select>
                            </div>
                        </div>
                    </div>


                    <div class="form-row mb-6">
                        <div class="form-group col-md-5">
                            <label class="text-dark" for="start">Start Date</label>
                            <span class="badge badge-info">Period Date</span>
                            <input id="start" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select start date">
                        </div>
                        <div class="form-group col-md-5">
                            <label class="text-dark" for="end">End Date</label>
                            <span class="badge badge-info">Period Date</span>
                            <input id="end" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select end date">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success mt-4" id="reset">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                        &nbsp;Reset Form
                    </button>

                    <button type="submit" class="btn btn-primary mt-4" id="go">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        &nbsp;Submit
                    </button>

                </div>
            </div>
        </div>

        <div id="tabsWithIcons" class="col-lg-12 col-12 layout-spacing" style="display: none">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Downtime Chart Analys</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area rounded-pills-icon">
                    <ul class="nav nav-pills mb-4 mt-3  justify-content-left" id="rounded-pills-icon-tab" role="tablist">
                        <li class="nav-item ml-2 mr-2">
                        <a class="nav-link mb-2 active text-center toMonthly" id="chart-monthly-tab" data-toggle="pill" href="#chart-monthly" role="tab" aria-controls="rounded-pills-icon-home" aria-selected="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                            Monthly
                        </a>
                        </li>
                        <li class="nav-item ml-2 mr-2">
                        <a class="nav-link mb-2 text-center toDaily" id="chart-daily-tab" data-toggle="pill" href="#chart-daily" role="tab" aria-controls="rounded-pills-icon-profile" aria-selected="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            Daily
                        </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="rounded-pills-icon-tabContent">
                        <div class="tab-pane fade show active" id="chart-monthly" role="tabpanel" aria-labelledby="chart-monthly-tab">


                            <div class="form-row mb-12">

                                <div class="form-group col-md-12">
                                        
                                    <div id="chartContainer1" style="height: 370px; width: 100%;"></div>
                                
                                </div>

                            </div>

                        </div>

                        <div class="tab-pane fade" id="chart-daily" role="tabpanel" aria-labelledby="chart-daily-tab">

                            <div class="form-row mb-12">

                                 <div class="form-group col-md-12">
                                    <label for="periode_daily">Periode</label>
                                    <div id="periode_daily_loading">
                                        <select class="form-control basic" name="periode_daily" id="periode_daily">
                                            <option></option>
                                        </select>
                                        <br>
                                        <br>
                                        <div id="chartContainer4" style="height: 370px; width: 100%;"></div>
                                    </div>                
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 layout-spacing layout-spacing" id="result2" style="display: none">
            <div class="statbox widget box box-shadow chartContainer4">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4 id="By Class"></h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div id="chartContainer5" style="height: 370px; width: 100%;"></div>

                </div>
            </div>
        </div>

        <div class="col-lg-12 layout-spacing layout-spacing" id="result3" style="display: none">
            <div class="statbox widget box box-shadow chartContainer4">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4 id="By Class"></h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div id="chartContainer6" style="height: 370px; width: 100%;"></div>

                </div>
            </div>
        </div>




    </div>
</div>


<div class="modal fade" id="chartClassDetail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" id="modalLoad">
            <div class="modal-header">
                <h4 class="modal-title" id="cartClassDetailTitle">Chart Class Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">

                <div id="chartContainer7" style="height: 370px; width: 100%;"></div>

            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
{{-- Content Page End--}}

{{-- Content Page JS Begin--}}
@section('contentjs')
<script src="{{ asset('outside/plugins/notification/snackbar/snackbar.min.js') }}"></script>
<script src="{{ asset('outside/plugins/flatpickr/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/index.js"></script>
<script src="{{ asset('outside/plugins/blockui/jquery.blockUI.min.js') }}"></script>
<script src="{{ asset('outside/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('canvasjs.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js" integrity="sha512-lOtDAY9KMT1WH9Fx6JSuZLHxjC8wmIBxsNFL6gJPaG7sLIVoSO9yCraWOwqLLX+txsOw0h2cHvcUJlJPvMlotw==" crossorigin="anonymous"></script>
<script>

var label, tittle, dataPointsCLassVal, dataPointsCLassPct;
var x = window.matchMedia("(max-width: 991px)")
var dataPoints1_fulltime, dataPoints1_downtime, dataPoints1_runtime;
var dataPoints4_fulltime, dataPoints4_downtime, dataPoints4_runtime;
var tittle_detail, dp_pie;
var mill, division, mach_type, mach_id, start, end, allreq;
var periode, periode_daily, select_periode_daily, param, dt_val;
var count, txtPeriode, txtDate, chart_pie

CanvasJS.addColorSet("colorSet1",[
    "#277da1",
    "#f3722c",
    "#f8961e",
    "#f9844a",
    "#f9c74f",
    "#90be6d",
    "#43aa8b",
    "#4d908e",
    "#577590",
    "#f94144"
]);

CanvasJS.addColorSet("colorSet2",[
    "#54478c",
    "#2c699a",
    "#048ba8",
    "#0db39e",
    "#16db93",
    "#83e377",
    "#b9e769",
    "#efea5a",
    "#f1c453",
    "#f29e4c"
]);

function blockUI(){

    $.blockUI({
        message: '<span class="text-semibold"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin position-left"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg></i>&nbsp; Loading</span>',
        fadeIn: 100,
        overlayCSS: {
            backgroundColor: '#1b2024',
            opacity: 0.8,
            zIndex: 1200,
            cursor: 'wait'
        },
        css: {
            border: 0,
            color: '#fff',
            zIndex: 1201,
            padding: 0,
            backgroundColor: 'transparent'
        }
    });
}

function blockElement(block){

    $(block).block({
        message: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>',
        centerX: 0,
        centerY: 0,
        overlayCSS: {
            backgroundColor: '#fff',
            opacity: 0.8,
            cursor: 'wait'
        },
        css: {
            width: 35,
            top: '10px',
            left: '',
            right: '10px',
            bottom: 0,
            border: 0,
            padding: 0,
            backgroundColor: 'transparent'
        }
    });

}

function blockModal(block){

    $(block).block({
        centerY: false,
        centerX: false,
        message: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>',
        overlayCSS: {
            backgroundColor: '#000',
            opacity: 0.8,
            cursor: 'wait'
        },
        css: {
            border: 0,
            color: '#fff',
            padding: '40px 15px',
            backgroundColor: 'transparent'
        }
    });
}

function listMill(){

    var block = $('#mill_loading');
    blockElement(block);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('listMillDowntime')}}",
        success: function (data) {

            count = Object.keys(data).length;

            if (count < 2) { 

                $(block).unblock();
                $('select[name="mill"]').empty();
                $('select[name="mill"]').prepend('<option></option>');
                $.each(data, function(index, element) {
                $('select[name="mill"]').append('<option value="'+element.mill_id+'" selected>'+element.mill_name+'</option>');
                });
                $('#mill').prop('disabled', true);

            }

            else {

                $(block).unblock();
                $('select[name="mill"]').empty();
                $('select[name="mill"]').prepend('<option></option>');
                $.each(data, function(index, element) {
                $('select[name="mill"]').append('<option value="'+element.mill_id+'">'+element.mill_name+'</option>');
                });

            }
            
        }
    });

    $('#mill').select2({
        placeholder: 'Choose Mill below',
        allowClear: true
    });

}

function listDivision(){
    var block = $('#div_loading');
    blockElement(block);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('listDivisionDowntime')}}",
        success: function (data) {
            $(block).unblock()
            $('select[name="division"]').empty();
            $('select[name="division"]').prepend('<option></option>');
            $.each(data, function(index, element) {
            $('select[name="division"]').append('<option value="'+element.Divisi+'">'+element.descr+'</option>');
            });
        }
    });

    $('#division').select2({
        placeholder: 'Choose Division below',
        allowClear: true
    });

}

function listMachType(){
    $('#mach_type').select2({
        placeholder: "Choose Mill first",
    });
}

function listMachTypeMill(mill){
    var block = $('#mach_type_loading');
    blockElement(block);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('listMachTypeMillDowntime/mill=')}}"+mill,
        success: function (data) {
            $(block).unblock();
            $('select[name="mach_type"]').empty();
            $('select[name="mach_type"]').prepend('<option></option>');
            $.each(data, function(index, element) {
            $('select[name="mach_type"]').append('<option value="'+element.mach_type+'">'+element.mach_type+' || '+element.mach_descr+'</option>');
            });
        }
    });

    $('#mach_type').select2({
        placeholder: 'Choose MachType below',
        allowClear: true
    });

}

function listMachTypeMillDiv(mill, div){
    var block = $('#mach_type_loading');
    blockElement(block);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('listMachTypeMillDivDowntime/mill=')}}"+mill+ "&div=" +div,
        success: function (data) {
            $(block).unblock();
            $('select[name="mach_type"]').empty();
            $('select[name="mach_type"]').prepend('<option></option>');
            $.each(data, function(index, element) {
            $('select[name="mach_type"]').append('<option value="'+element.mach_type+'">'+element.mach_type+' || '+element.mach_descr+'</option>');
            });
        }
    });

    $('#mach_type').select2({
        placeholder: 'Choose MachType below',
        allowClear: true
    });

}

function listMachID(){
    $('#mach_id').select2({
        placeholder: "Choose Mach Type first",
    });
}

function listMachIDType(mill, type){
    var block = $('#mach_id_loading');
    blockElement(block);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('listMachIDTypeDowntime/mill=')}}"+mill+ "&type=" +type,
        success: function (data) {
            $(block).unblock();
            $('select[name="mach_id"]').empty();
            $('select[name="mach_id"]').prepend('<option></option>');
            $.each(data, function(index, element) {
            $('select[name="mach_id"]').append('<option value="'+element.mach_id+'">'+element.mach_id+' || '+element.mach_id_desc+'</option>');
            });
        }
    });

    $('#mach_id').select2({
        placeholder: 'Choose Mach ID below',
        allowClear: true
    });
}

function getChart1(tittle, dataPoints1_fulltime, dataPoints1_downtime, dataPoints1_runtime, label){
    var chart1 = new CanvasJS.Chart("chartContainer1", {
        animationEnabled: true,
        theme: "light2",
        title: {
            text: tittle,
            fontFamily: "Calibri",
            fontSize: 20
        },
        exportEnabled: true,
        subtitles:[
            {
                text: label,
                //Uncomment properties below to see how they behave
                fontFamily: "Calibri",
                fontColor: "red",
                fontSize: 12
            }
        ],
        axisX:{
            crosshair: {
                enabled: true,
                snapToDataPoint: true
            }
	    },
        axisY: {
            scaleBreaks: {
                autoCalculate: true,
                type: "wavy"
		    },
            crosshair: {
			    enabled: true,
                snapToDataPoint: true
		    },
            // scaleBreaks: {
            //     autoCalculate: true,
            //     collapsibleThreshold: "95%", //change to "50%"
            //     type: "wavy"
            // },

            // title: "Units Sold",
            // valueFormatString: "#0,,.",
            title: "Hourly",
            labelFormatter: addSymbols,
            // stripLines: [{
            //     value: sum,
            //     label: "Average",
            //     color: "#ff8c00",
            //     labelFontColor: "#ff8c00",

            // }]
        },
        axisY2: {
            title: "Downtime (%)",
            suffix: "%",
            titleFontColor: "#0f4c75",
            lineColor: "#0f4c75",
            labelFontColor: "#0f4c75",
            tickColor: "#0f4c75",
            includeZero: true
	    },
        toolTip:{
		    shared:true
	    },
        legend: {
            cursor: "pointer",
            itemclick: toggleDataSeries
	    },
        data: [
            {
                type: "column",
                click: onClickFulltime,
                name: "Fulltime",
                showInLegend: true,
                indexLabel: "{y}",
                indexLabelPlacement: "outside",
                indexLabelOrientation: "horizontal",
                indexLabelFontWeight: "bold",
                indexLabelFontSize: 12,
                indexLabelFontFamily: "calibri",
                color: "#00b7c2" //ijo
            },
	        {
                type: "area",
                name: "Downtime (Val)",
                showInLegend: true,
                indexLabel: "{y}",
                indexLabelPlacement: "inside",
                indexLabelOrientation: "horizontal",
                indexLabelFontWeight: "bold",
                indexLabelFontSize: 13,
                indexLabelFontFamily: "calibri",
                indexLabelFontColor: "#b52b65",
                color: "#b52b65" //abang

            },
            {
                type: "spline",
                name: "Downtime (%)",
                axisYType: "secondary",
                yValueFormatString: "0.##\"%\"",
                showInLegend: true,
                indexLabel: "{y}",
                indexLabelPlacement: "inside",
                indexLabelOrientation: "horizontal",
                indexLabelFontWeight: "bold",
                indexLabelFontSize: 13,
                indexLabelFontFamily: "calibri",
                indexLabelFontColor: "#0f4c75",
                color: "#0f4c75" //biru
            },
        ]
    });
    chart1.options.data[0].dataPoints = dataPoints1_fulltime;
    chart1.options.data[1].dataPoints = dataPoints1_downtime;
    chart1.options.data[2].dataPoints = dataPoints1_runtime;
    // showDefaultText(chart1, "No Data Found!");

    if (x.matches) {

        for(var i = 0; i < chart1.options.data.length; i++){
            chart1.options.data[i].indexLabelFontSize = 6;
        }
        chart1.render();
    }
    chart1.render();
}

function getChart2(tittle, label, dataPointsCLass, dataPointsCLassPct){
    var chart2 = new CanvasJS.Chart("chartContainer5", {
        animationEnabled: true,
        theme: "light2",
        title: {
            text: tittle,
            fontFamily: "Calibri",
            fontSize: 20
        },
        exportEnabled: true,
        subtitles:[
            {
                text: label,
                //Uncomment properties below to see how they behave
                fontFamily: "Calibri",
                fontColor: "red",
                fontSize: 12
            }
        ],
        axisX:{
            crosshair: {
                enabled: true,
                snapToDataPoint: true
            }
	    },
        axisY: {
            scaleBreaks: {
                autoCalculate: true,
                type: "wavy"
		    },
            crosshair: {
			    enabled: true,
                snapToDataPoint: true
		    },
            // scaleBreaks: {
            //     autoCalculate: true,
            //     collapsibleThreshold: "95%", //change to "50%"
            //     type: "wavy"
            // },

            // title: "Units Sold",
            // valueFormatString: "#0,,.",
            title: "Hourly (Val)",
            labelFormatter: addSymbols,
            // stripLines: [{
            //     value: sum,
            //     label: "Average",
            //     color: "#ff8c00",
            //     labelFontColor: "#ff8c00",

            // }]
        },
        axisY2: {
            title: "Downtime % (/Fulltime)",
            suffix: "%",
            titleFontColor: "#0f4c75",
            lineColor: "#0f4c75",
            labelFontColor: "#0f4c75",
            tickColor: "#0f4c75",
            includeZero: true
	    },
        toolTip:{
		    shared:true
	    },
        legend: {
            cursor: "pointer",
            itemclick: toggleDataSeries
	    },
        data: [
            {
                type: "column",
                click: onClickClassDetail,
                name: "Hourly (Val)",
                showInLegend: true,
                indexLabel: "{y}",
                indexLabelPlacement: "outside",
                indexLabelOrientation: "horizontal",
                indexLabelFontWeight: "bold",
                indexLabelFontSize: 12,
                indexLabelFontFamily: "calibri",
                color: "#b52b65" //abang
            },
            {
                type: "spline",
                name: "Downtime (%)",
                axisYType: "secondary",
                yValueFormatString: "0.##\"%\"",
                showInLegend: true,
                indexLabel: "{y}",
                indexLabelPlacement: "inside",
                indexLabelOrientation: "horizontal",
                indexLabelFontWeight: "bold",
                indexLabelFontSize: 12,
                indexLabelFontFamily: "calibri",
                indexLabelFontColor: "#0f4c75",
                color: "#0f4c75" //biru
            },
        ]
    });
    chart2.options.data[0].dataPoints = dataPointsCLass;
    chart2.options.data[1].dataPoints =  dataPointsCLassPct;
    // showDefaultText(chart1, "No Data Found!");

    if (x.matches) {

        for(var i = 0; i < chart2.options.data.length; i++){
            chart2.options.data[i].indexLabelFontSize = 6;
        }
        chart2.render();
    }
    chart2.render();
}

function getChart3(tittle, label, dataPointsCLass, dataPointsCLassPct){
    var chart3 = new CanvasJS.Chart("chartContainer6", {
        animationEnabled: true,
        theme: "light2",
        title: {
            text: tittle,
            fontFamily: "Calibri",
            fontSize: 20
        },
        exportEnabled: true,
        subtitles:[
            {
                text: label,
                //Uncomment properties below to see how they behave
                fontFamily: "Calibri",
                fontColor: "red",
                fontSize: 12
            }
        ],
        axisX:{
            crosshair: {
                enabled: true,
                snapToDataPoint: true
            }
	    },
        axisY: {
            scaleBreaks: {
                autoCalculate: true,
                type: "wavy"
		    },
            crosshair: {
			    enabled: true,
                snapToDataPoint: true
		    },
            // scaleBreaks: {
            //     autoCalculate: true,
            //     collapsibleThreshold: "95%", //change to "50%"
            //     type: "wavy"
            // },

            // title: "Units Sold",
            // valueFormatString: "#0,,.",
            title: "Hourly (Val)",
            labelFormatter: addSymbols,
            // stripLines: [{
            //     value: sum,
            //     label: "Average",
            //     color: "#ff8c00",
            //     labelFontColor: "#ff8c00",

            // }]
        },
        axisY2: {
            title: "Downtime % (/Fulltime)",
            suffix: "%",
            titleFontColor: "#0f4c75",
            lineColor: "#0f4c75",
            labelFontColor: "#0f4c75",
            tickColor: "#0f4c75",
            includeZero: true
	    },
        toolTip:{
		    shared:true
	    },
        legend: {
            cursor: "pointer",
            itemclick: toggleDataSeries
	    },
        data: [
            {
                type: "column",
                click: onClickClassDetailDaily,
                name: "Hourly (Val)",
                showInLegend: true,
                indexLabel: "{y}",
                indexLabelPlacement: "outside",
                indexLabelOrientation: "horizontal",
                indexLabelFontWeight: "bold",
                indexLabelFontSize: 12,
                indexLabelFontFamily: "calibri",
                color: "#b52b65" //abang
            },
            {
                type: "spline",
                name: "Downtime (%)",
                axisYType: "secondary",
                yValueFormatString: "0.##\"%\"",
                showInLegend: true,
                indexLabel: "{y}",
                indexLabelPlacement: "inside",
                indexLabelOrientation: "horizontal",
                indexLabelFontWeight: "bold",
                indexLabelFontSize: 12,
                indexLabelFontFamily: "calibri",
                indexLabelFontColor: "#0f4c75",
                color: "#0f4c75" //biru
            },
        ]
    });
    chart3.options.data[0].dataPoints = dataPointsCLass;
    chart3.options.data[1].dataPoints =  dataPointsCLassPct;
    // showDefaultText(chart1, "No Data Found!");

    if (x.matches) {

        for(var i = 0; i < chart3.options.data.length; i++){
            chart3.options.data[i].indexLabelFontSize = 6;
        }
        chart3.render();
    }
    chart3.render();
}

function getChart4(tittle, dataPoints4_fulltime, dataPoints4_downtime, dataPoints4_runtime, label){
    chart4 = new CanvasJS.Chart("chartContainer4", {
        animationEnabled: true,
        theme: "light2",
        title: {
            text: tittle,
            fontFamily: "Calibri",
            fontSize: 20
        },
        exportEnabled: true,
        subtitles:[
            {
                text: label,
                //Uncomment properties below to see how they behave
                fontFamily: "Calibri",
                fontColor: "red",
                fontSize: 12
            }
        ],
        axisX:{
            crosshair: {
                enabled: true,
                snapToDataPoint: true
            }
	    },
        axisY: {
            scaleBreaks: {
                autoCalculate: true,
                type: "wavy"
		    },
            crosshair: {
			    enabled: true,
                snapToDataPoint: true
		    },
            // scaleBreaks: {
            //     autoCalculate: true,
            //     collapsibleThreshold: "95%", //change to "50%"
            //     type: "wavy"
            // },

            // title: "Units Sold",
            // valueFormatString: "#0,,.",
            title: "Hourly",
            labelFormatter: addSymbols,
            // stripLines: [{
            //     value: sum,
            //     label: "Average",
            //     color: "#ff8c00",
            //     labelFontColor: "#ff8c00",

            // }]
        },
        axisY2: {
            title: "Downtime (%)",
            suffix: "%",
            titleFontColor: "#0f4c75",
            lineColor: "#0f4c75",
            labelFontColor: "#0f4c75",
            tickColor: "#0f4c75",
            includeZero: true
	    },
        toolTip:{
		    shared:true
	    },
        legend: {
            cursor: "pointer",
            itemclick: toggleDataSeries
	    },
        data: [
            {
                type: "column",
                click: onClickFulltimeDaily,
                name: "Fulltime",
                showInLegend: true,
                indexLabel: "{y}",
                indexLabelPlacement: "outside",
                indexLabelOrientation: "horizontal",
                indexLabelFontWeight: "bold",
                indexLabelFontSize: 12,
                indexLabelFontFamily: "calibri",
                color: "#00b7c2" //ijo
            },
	        {
                type: "area",
                name: "Downtime (Val)",
                showInLegend: true,
                indexLabel: "{y}",
                indexLabelPlacement: "inside",
                indexLabelOrientation: "horizontal",
                indexLabelFontWeight: "bold",
                indexLabelFontSize: 13,
                indexLabelFontFamily: "calibri",
                indexLabelFontColor: "#b52b65",
                color: "#b52b65" //abang

            },
             {
                type: "spline",
                name: "Downtime (%)",
                axisYType: "secondary",
                yValueFormatString: "0.##\"%\"",
                showInLegend: true,
                indexLabel: "{y}",
                indexLabelPlacement: "inside",
                indexLabelOrientation: "horizontal",
                indexLabelFontWeight: "bold",
                indexLabelFontSize: 13,
                indexLabelFontFamily: "calibri",
                indexLabelFontColor: "#0f4c75",
                color: "#0f4c75" //biru
            },
        ]
    });
    chart4.options.data[0].dataPoints = dataPoints4_fulltime;
    chart4.options.data[1].dataPoints = dataPoints4_downtime;
    chart4.options.data[2].dataPoints = dataPoints4_runtime;
    // showDefaultText(chart4, "No Data Found!");

    if (x.matches) {

        for(var i = 0; i < chart4.options.data.length; i++){
            chart4.options.data[i].indexLabelFontSize = 6;
        }
        chart4.render();
    }
    chart4.render();
}

function getPieChart(tittle_detail, dp_pie, label){
    chart_pie = new CanvasJS.Chart("chartContainer7", {
        colorSet: "colorSet1",
	    animationEnabled: true,
        exportEnabled: true,
        theme: "light2",
        title: {
            text: tittle_detail,
            fontFamily: "Calibri",
            fontSize: 14
        },
        exportEnabled: true,
        subtitles:[
            {
                text: label,
                //Uncomment properties below to see how they behave
                fontFamily: "Calibri",
                fontColor: "red",
                fontSize: 12
            }
        ],
        data: [{

            type: "pie",
            percentFormatString: "#0.##",
            indexLabel: "{label} {y} #percent%",
            indexLabelFontSize: 10

        }]
    });
    chart_pie.options.data[0].dataPoints = dp_pie;
    showDefaultText(chart_pie, "No Data Found!");
    if (x.matches) {

        for(var i = 0; i < chart_pie.options.data.length; i++){
            chart_pie.options.data[i].indexLabelFontSize = 8;
        }
        chart_pie.render();
    }
    chart_pie.render();
}

function addSymbols(e) {
	var suffixes = ["", "K", "M", "B"];
	var order = Math.max(Math.floor(Math.log(e.value) / Math.log(1000)), 0);

	if(order > suffixes.length - 1)
		order = suffixes.length - 1;

	var suffix = suffixes[order];
	return CanvasJS.formatNumber(e.value / Math.pow(1000, order)) + suffix;
}

function toggleDataSeries(e) {
	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else {
		e.dataSeries.visible = true;
	}
	e.chart.render();
}

function showDefaultText(chart, text) {
  var dataPoints = chart.options.data[0].dataPoints;
  var isEmpty = !(dataPoints && dataPoints.length > 0);

  if (!isEmpty) {
    for (var i = 0; i < dataPoints.length; i++) {
      isEmpty = !dataPoints[i].y;
      if (!isEmpty)
        break;
    }
  }

  if (!chart.options.subtitles)
    chart.options.subtitles = [];
  if (isEmpty) {
    chart.options.subtitles.push({
      text: text,
      verticalAlign: 'center',
    });
    chart.options.data[0].showInLegend = false;
  } else {
    chart.options.data[0].showInLegend = false;
  }
}

function onClickFulltime(e){

    blockUI();
    result3.style.display = "none";

    var txtValue = e.dataPoint.y;
    txtPeriode = e.dataPoint.label;

    $.ajax({
        type: "POST",
        url: "{{ url('chartDownTimeClass') }}",
        data: {
            '_token': '{{ csrf_token() }}',
            'mill': mill,
            'division': division,
            'mach_type': mach_type,
            'mach_id': mach_id,
            'txtValue' :txtValue,
            'txtPeriode' :txtPeriode
        },
        success: function(data) {

            if (data.length > 0) {

                result2.style.display = "block";
                dataPointsCLass = []; dataPointsCLassPct = [];
                for (var i = 0; i < data.length; i++) {
                    dataPointsCLass.push({ label: data[i].Class, y: parseFloat(data[i].result) });
                    dataPointsCLassPct.push({ label: data[i].Class, y: parseFloat(data[i].pct_result) });
                }
                tittle = 'Downtine Each Class for Period '+txtPeriode+" (100% = "+txtValue+")";
                getChart2(tittle, label, dataPointsCLass, dataPointsCLassPct);

                $('html, body').animate({
                    scrollTop: $("#result2").offset().top
                }, 1200);

                $.unblockUI();

                console.log(dataPointsCLassPct)

            }

            else {
                
                result2.style.display = "block";
                dataPointsCLass = [];  dataPointsCLassPct = [];
                dataPointsCLass.push({ y: 0 });
                dataPointsCLassPct.push({ y: 0 });
                tittle = 'Downtine Each Class for Period '+txtPeriode+" (100% = "+txtValue+")";
                getChart2(tittle, label, dataPointsCLass, dataPointsCLassPct);

                $.unblockUI();
                swal("Downtime (Class) Chart - Monthly", "Data not available",  "error");

                $('html, body').animate({
                    scrollTop: $("#result2").offset().top
                }, 1200);

            }
        }
    });

}

function onClickFulltimeDaily(e){

    blockUI();
    result2.style.display = "none";

    var txtValue = e.dataPoint.y;
    txtDate = e.dataPoint.label;

    // alert(txtDate+", "+txtValue)

    $.ajax({
        type: "POST",
        url: "{{ url('chartDownTimeClassDaily') }}",
        data: {
            '_token': '{{ csrf_token() }}',
            'mill': mill,
            'division': division,
            'mach_type': mach_type,
            'mach_id': mach_id,
            'txtValue' :txtValue,
            'txtDate' :txtDate
        },
        success: function(data) {

            if (data.length > 0) {

                result3.style.display = "block";
                dataPointsCLass = []; dataPointsCLassPct = [];
                for (var i = 0; i < data.length; i++) {
                    dataPointsCLass.push({ label: data[i].Class, y: parseFloat(data[i].result) });
                    dataPointsCLassPct.push({ label: data[i].Class, y: parseFloat(data[i].pct_result) });
                }
                tittle = 'Downtine Each Class for '+txtDate+" (100% = "+txtValue+")";
                getChart3(tittle, label, dataPointsCLass, dataPointsCLassPct);

                $('html, body').animate({
                    scrollTop: $("#result3").offset().top
                }, 1200);

                $.unblockUI();

                console.log(dataPointsCLassPct)

            }

            else {
                
                result3.style.display = "block";
                dataPointsCLass = [];  dataPointsCLassPct = [];
                dataPointsCLass.push({ y: 0 });
                dataPointsCLassPct.push({ y: 0 });
                tittle = 'Downtine Each Class for '+txtDate+" (100% = "+txtValue+")";
                getChart3(tittle, label, dataPointsCLass, dataPointsCLassPct);

                $.unblockUI();
                swal("Downtime (Class) Chart - Daily", "Data not available",  "error");

                $('html, body').animate({
                    scrollTop: $("#result3").offset().top
                }, 1200);

            }
        }
    });

}

function onClickClassDetail(e){

    $("#chartClassDetail").modal();
    blockModal(block);
    var txtClass = e.dataPoint.label;

    $.ajax({
        type: "POST",
        url: "{{ url('chartDownTimeDetail') }}",
        data: {
            '_token': '{{ csrf_token() }}',
            'mill': mill,
            'division': division,
            'mach_type': mach_type,
            'mach_id': mach_id,
            'periode': txtPeriode,
            'class' : txtClass 
        },
        success: function(data) {

            if (data.length > 0) {

                
                dp_pie = [];
                for (var i = 0; i < data.length; i++) {
                    dp_pie.push({
                        label: data[i].Detail,
                        y: parseFloat(data[i].result)
                    });
                }

                tittle_detail = 'Detail '+txtClass+' for Periode ' +txtPeriode;
                getPieChart(tittle_detail, dp_pie, label);

                $(block).unblock();

            } else {

                
                tittle_detail = 'Detail '+txtClass+' for Periode ' +txtPeriode;
                dp_pie = [];
                dp_pie.push({ y: 0 });
                getPieChart(tittle_detail, dp_pie, label);

                $(block).unblock();
                swal("Downtime (Class-Detail) Chart - Periodic", "Data not available", "error");
            }
        }
    });

}

function onClickClassDetailDaily(e){

    $("#chartClassDetail").modal();
    blockModal(block);
    var txtClass = e.dataPoint.label;

    $.ajax({
        type: "POST",
        url: "{{ url('chartDownTimeDetailDaily') }}",
        data: {
            '_token': '{{ csrf_token() }}',
            'mill': mill,
            'division': division,
            'mach_type': mach_type,
            'mach_id': mach_id,
            'txtDate': txtDate,
            'class' : txtClass 
        },
        success: function(data) {

            if (data.length > 0) {

                
                dp_pie = [];
                for (var i = 0; i < data.length; i++) {
                    dp_pie.push({
                        label: data[i].Detail,
                        y: parseFloat(data[i].result)
                    });
                }

                tittle_detail = 'Detail '+txtClass+' for ' +txtDate;
                getPieChart(tittle_detail, dp_pie, label);

                $(block).unblock();

            } else {

                
                tittle_detail = 'Detail '+txtClass+' for ' +txtDate;
                dp_pie = [];
                dp_pie.push({ y: 0 });
                getPieChart(tittle_detail, dp_pie, label);

                $(block).unblock();
                swal("Downtime (Class-Detail) Chart - Daily", "Data not available", "error");
            }
        }
    });

}

$(document).ready(function() {

    $('#homeNav').attr('data-active','false');
    $('#homeNav').attr('aria-expanded','false');
    $('#ReportNav').attr('data-active','true');
    $('#ReportNav').attr('aria-expanded','true');
    $('.ReportTreeView').addClass('show');
    $('#DowntimeAnalysis').addClass('active');

    $('.basic').on('select2:open', function() {
        if (Modernizr.touch) {
            $('.select2-search__field').prop('focus', false);
        }
    });

    $('#chartClassDetail').on('shown.bs.modal', function () {
        chart_pie.render();
    });

    block = $('#modalLoad');

    @if(Session::has('MILLID'))


        var mill = '{{ Session::get('MILLID') }}';

        if (mill) {

            $('#mach_type_badge').empty();
            html = "<span class='badge badge-success'>Mill ID #"+mill+"</span>";
            $('#mach_type_badge').empty();
            $('#mach_type_badge').append(html);
            listMachTypeMill(mill);

            $('#mach_id_badge').empty();
            html2 = "<span class='badge badge-danger'>N/A</span>";
            $('#mach_id_badge').empty();
            $('#mach_id_badge').append(html2);
            listMachID();

        }

        $('#division').change(function(){

            var mill = '{{ Session::get('MILLID') }}';
            var div = $('#division').val();
            $('select[name="mach_id"]').empty();
            $('select[name="mach_type"]').empty();

            if (!div){

                $('#mach_type_badge').empty();
                html = "<span class='badge badge-danger'>N/A</span>";
                $('#mach_type_badge').empty();
                $('#mach_type_badge').append(html);
                listMachType(mill);

                $('#mach_id_badge').empty();
                html2 = "<span class='badge badge-danger'>N/A</span>";
                $('#mach_id_badge').empty();
                $('#mach_id_badge').append(html2);
                listMachID();

            }

            else if (mill && !div){

                $('#mach_type_badge').empty();
                html = "<span class='badge badge-success'>Mill ID #"+mill+"</span>";
                $('#mach_type_badge').empty();
                $('#mach_type_badge').append(html);
                listMachTypeMill(mill);

                $('#mach_id_badge').empty();
                html2 = "<span class='badge badge-danger'>N/A</span>";
                $('#mach_id_badge').empty();
                $('#mach_id_badge').append(html2);
                listMachID();

            }

            else if (mill && div){

                $('#mach_type_badge').empty();
                html = "<span class='badge badge-success'>Mill ID #"+mill+" & Division #"+div+"</span>";
                $('#mach_type_badge').empty();
                $('#mach_type_badge').append(html);
                listMachTypeMillDiv(mill, div);

                $('#mach_id_badge').empty();
                html2 = "<span class='badge badge-danger'>N/A</span>";
                $('#mach_id_badge').empty();
                $('#mach_id_badge').append(html2);
                listMachID();

            }
            else if (!mill && div){

                $('#mach_type_badge').empty();
                html = "<span class='badge badge-danger'>N/A</span>";
                $('#mach_type_badge').empty();
                $('#mach_type_badge').append(html);
                listMachType();

                $('#mach_id_badge').empty();
                html2 = "<span class='badge badge-danger'>N/A</span>";
                $('#mach_id_badge').empty();
                $('#mach_id_badge').append(html2);
                listMachID();

            }



        });

        $('#mach_type').change(function(){

            var mill = '{{ Session::get('MILLID') }}';
            var type = $('#mach_type').val();
            $('select[name="mach_id"]').empty();

            if (!type){

                $('#mach_id_badge').empty();
                html = "<span class='badge badge-danger'>N/A</span>";
                $('#mach_id_badge').empty();
                $('#mach_id_badge').append(html2);
                listMachID();

            }

            else {

                $('#mach_id_badge').empty();
                html = "<span class='badge badge-success'>Mill ID #"+mill+" & Mach #"+type+"</span>";
                $('#mach_id_badge').empty();
                $('#mach_id_badge').append(html);
                listMachIDType(mill, type);

            }


        });


    @else

        listMachType(); listMachID();

        $('#mill').change(function(){

            var mill = $('#mill').val();
            var div = $('#division').val();
            $('select[name="mach_id"]').empty();
            $('select[name="mach_type"]').empty();

            if (!mill && !div){

                $('#mach_type_badge').empty();
                html = "<span class='badge badge-danger'>N/A</span>";
                $('#mach_type_badge').empty();
                $('#mach_type_badge').append(html);
                listMachType();

                $('#mach_id_badge').empty();
                html2 = "<span class='badge badge-danger'>N/A</span>";
                $('#mach_id_badge').empty();
                $('#mach_id_badge').append(html2);
                listMachID();

            }

            else if (mill && !div){

                $('#mach_type_badge').empty();
                html = "<span class='badge badge-success'>Mill ID #"+mill+"</span>";
                $('#mach_type_badge').empty();
                $('#mach_type_badge').append(html);
                listMachTypeMill(mill);

                $('#mach_id_badge').empty();
                html2 = "<span class='badge badge-danger'>N/A</span>";
                $('#mach_id_badge').empty();
                $('#mach_id_badge').append(html2);
                listMachID();

            }

            else if (mill && div){

                $('#mach_type_badge').empty();
                html = "<span class='badge badge-success'>Mill ID #"+mill+" & Division #"+div+"</span>";
                $('#mach_type_badge').empty();
                $('#mach_type_badge').append(html);
                listMachTypeMillDiv(mill, div);

                $('#mach_id_badge').empty();
                html2 = "<span class='badge badge-danger'>N/A</span>";
                $('#mach_id_badge').empty();
                $('#mach_id_badge').append(html2);
                listMachID();

            }
            else if (!mill && div){

                $('#mach_type_badge').empty();
                html = "<span class='badge badge-danger'>N/A</span>";
                $('#mach_type_badge').empty();
                $('#mach_type_badge').append(html);
                listMachType();

                $('#mach_id_badge').empty();
                html2 = "<span class='badge badge-danger'>N/A</span>";
                $('#mach_id_badge').empty();
                $('#mach_id_badge').append(html2);
                listMachID();

            }

        });

        $('#division').change(function(){

            var mill = $('#mill').val();
            var div = $('#division').val();
            $('select[name="mach_id"]').empty();
            $('select[name="mach_type"]').empty();

            if (!mill && !div){

                $('#mach_type_badge').empty();
                html = "<span class='badge badge-danger'>N/A</span>";
                $('#mach_type_badge').empty();
                $('#mach_type_badge').append(html);
                listMachType();

                $('#mach_id_badge').empty();
                html2 = "<span class='badge badge-danger'>N/A</span>";
                $('#mach_id_badge').empty();
                $('#mach_id_badge').append(html2);
                listMachID();

            }

            else if (mill && !div){

                $('#mach_type_badge').empty();
                html = "<span class='badge badge-success'>Mill ID #"+mill+"</span>";
                $('#mach_type_badge').empty();
                $('#mach_type_badge').append(html);
                listMachTypeMill(mill);

                $('#mach_id_badge').empty();
                html2 = "<span class='badge badge-danger'>N/A</span>";
                $('#mach_id_badge').empty();
                $('#mach_id_badge').append(html2);
                listMachID();

            }

            else if (mill && div){

                $('#mach_type_badge').empty();
                html = "<span class='badge badge-success'>Mill ID #"+mill+" & Division #"+div+"</span>";
                $('#mach_type_badge').empty();
                $('#mach_type_badge').append(html);
                listMachTypeMillDiv(mill, div);

                $('#mach_id_badge').empty();
                html2 = "<span class='badge badge-danger'>N/A</span>";
                $('#mach_id_badge').empty();
                $('#mach_id_badge').append(html2);
                listMachID();

            }
            else if (!mill && div){

                $('#mach_type_badge').empty();
                html = "<span class='badge badge-danger'>N/A</span>";
                $('#mach_type_badge').empty();
                $('#mach_type_badge').append(html);
                listMachType();

                $('#mach_id_badge').empty();
                html2 = "<span class='badge badge-danger'>N/A</span>";
                $('#mach_id_badge').empty();
                $('#mach_id_badge').append(html2);
                listMachID();

            }



        });

        $('#mach_type').change(function(){

            var type = $('#mach_type').val();
            var mill = $('#mill').val();
            $('select[name="mach_id"]').empty();

            if (!type){

                $('#mach_id_badge').empty();
                html = "<span class='badge badge-danger'>N/A</span>";
                $('#mach_id_badge').empty();
                $('#mach_id_badge').append(html2);
                listMachID();

            }

            else {

                $('#mach_id_badge').empty();
                html = "<span class='badge badge-success'>Mill ID #"+mill+" & Mach #"+type+"</span>";
                $('#mach_id_badge').empty();
                $('#mach_id_badge').append(html);
                listMachIDType(mill, type);

            }


        });


    @endif

    listMill(); listDivision(); 

    var result = document.getElementById("tabsWithIcons");
    var result2 = document.getElementById("result2");
    var result3 = document.getElementById("result3");


    var f1 = flatpickr(document.getElementById('start'), {
        static: true,
        altInput: true,
        plugins: [new monthSelectPlugin({shorthand: false, dateFormat: "Ym", altFormat: "Ym"})],
        disableMobile: "true",
    });

    var f2 = flatpickr(document.getElementById('end'), {
        static: true,
        altInput: true,
        plugins: [new monthSelectPlugin({shorthand: false, dateFormat: "Ym", altFormat: "Ym"})],
        disableMobile: "true",
    });

   

    $('#go').on('click', function() {


        event.preventDefault();
        // chart1.destroy();
        mill = $('#mill').val();
        division = $('#division').val();
        mach_type = $('#mach_type').val();
        mach_id = $('#mach_id').val();
        start = $('#start').val();
        end = $('#end').val();
        allreq = '';
        label = 'Mill #'+mill;


        if (!end) {

            var today = new Date();
            // var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();
            end = yyyy+mm;
            // end = yyyy+mm+dd;
        }

        if (!mill && !start) {
            swal("Whops", "You must choose Mill and Start Date first", "error");
        }

        else if (!mill) {
            swal("Whops", "You must choose Mill first", "error")

        }

        else if (!start) {
            swal("Whops", "You must choose Start Date first", "error")

        }
        else {

            if (mill){

                // allreq = allreq+'&mill='+mill.trim();
            }

            if (division){

                // allreq = allreq+'&division='+division.trim();
                label = label+', Div #'+division.trim();
            }

            if (mach_type){

                // allreq = allreq+'&mach_type='+mach_type.trim();
                label = label+', MachType #'+mach_type.trim();
            }

            if (mach_id){

                // allreq = allreq+'&mach_id='+mach_id.trim();
                label = label+', MachID #'+mach_id.trim();
            }

            if (start && end){

                // allreq = allreq+'&start='+start.trim();
                // allreq = allreq+'&end='+end.trim();
            }

            // do some here

            periode_daily = end;
            param = periode_daily

            result2.style.display="none";

            blockUI();
        
           
            var block_periode_daily = $('#periode_daily_loading');
            blockElement(block_periode_daily);

            $.ajax({
                type: "POST",
                url: "{{ url('chartDownTime') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'mill': mill,
                    'division': division,
                    'mach_type': mach_type,
                    'mach_id': mach_id,
                    'start': start,
                    'end': end
                },
                success: function(data) {

                    if (data.length > 0) {

                       
                        result.style.display="block";

                        dataPoints1_fulltime = []; dataPoints1_downtime = []; dataPoints1_runtime = [];
                        for (var i = 0; i < data.length; i++) {
                            dataPoints1_fulltime.push({ label: data[i].Periode, y: parseFloat(data[i].fulltime) });
                            dataPoints1_downtime.push({ label: data[i].Periode, y: parseFloat(data[i].downtime) });
                            dataPoints1_runtime.push({ label: data[i].Periode, y: parseFloat(data[i].runtime) });
                        }
                        tittle = 'Date Period '+data[0].Periode+' - '+data[data.length-1].Periode;
                        getChart1(tittle, dataPoints1_fulltime, dataPoints1_downtime, dataPoints1_runtime, label);

                        // Fill select periode Chart Downtime Daily
                        $('select[name="periode_daily"]').empty();
                        $('select[name="periode_daily"]').prepend('<option></option>');
                        $.each(data, function(index, element) {
                            $('select[name="periode_daily"]').append('<option value="'+element.Periode+'">'+element.Periode+'</option>');
                        });
                        $(block_periode_daily).unblock();
                        $('#periode_daily').select2({
                            placeholder: 'Choose Periode below',
                            allowClear: true
                        });

                        $.unblockUI();
                        
                        $('html, body').animate({
                            scrollTop: $("#tabsWithIcons").offset().top
                        }, 1200);

                    }
                    else {

                        result.style.display="block";

                        dataPoints1_fulltime = []; dataPoints1_downtime = []; dataPoints1_runtime = [];
                        dataPoints1_fulltime.push({ y: 0 });
                        dataPoints1_downtime.push({ y: 0 });
                        dataPoints1_runtime.push({ y: 0 });
                        tittle = 'Date Period -';
                        getChart1(tittle, dataPoints1_fulltime, dataPoints1_downtime, dataPoints1_runtime, label);

                       
                        $.unblockUI();
                        $(block_periode_daily).unblock();
                        swal("Downtime Chart", "Data not available",  "error");
                        

                    }
                }
            });


            $.ajax({
                type: "POST",
                url: "{{ url('chartDownTimeDaily') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'mill': mill,
                    'division': division,
                    'mach_type': mach_type,
                    'mach_id': mach_id,
                    'periode': periode_daily
                },
                success: function(data) {

                    if (data.length > 0) {

                        result.style.display="block";

                        dataPoints4_fulltime = []; dataPoints4_downtime = []; dataPoints4_runtime = [];
                        for (var i = 0; i < data.length; i++) {
                            dataPoints4_fulltime.push({ label: data[i].day, y: parseFloat(data[i].fulltime) });
                            dataPoints4_downtime.push({ label: data[i].day, y: parseFloat(data[i].downtime) });
                            dataPoints4_runtime.push({ label: data[i].day,  y: parseFloat(data[i].runtime) });
                        }

                        tittle_daily = 'Date Period ' + periode_daily;
                        getChart4(tittle_daily, dataPoints4_fulltime, dataPoints4_downtime, dataPoints4_runtime, label);

                        $.unblockUI();

                    } else {

                        result.style.display="block";

                        dataPoints4_fulltime = []; dataPoints4_downtime = []; dataPoints4_runtime = [];
                        dataPoints4_fulltime.push({ y: 0 });
                        dataPoints4_downtime.push({ y: 0 });
                        dataPoints4_runtime.push({ y: 0 });
                        tittle_daily = 'Date Period ' + periode_daily;
                        getChart4(tittle_daily, dataPoints4_fulltime, dataPoints4_downtime, dataPoints4_runtime, label);


                        $.unblockUI();
                        swal("Downtime Chart - Daily", "Data not available", "error");
                       
                    }
                }
            });


        }

    });

    $('#reset').on('click', function() {

        listMill();
        $('#division').val(null).trigger('change');
        $('#mach_type').val(null).trigger('change');
        $('#mach_id').val(null).trigger('change');
        f1.clear();
        f2.clear();
        result.style.display="none";

    });

    $('#periode_daily').change(function() {

        blockUI();

        select_periode_daily = $('#periode_daily').val();

        if (select_periode_daily) {
            param = select_periode_daily;
        }

        else {
            param = periode_daily;
        }

        $.ajax({
            type: "POST",
            url: "{{ url('chartDownTimeDaily') }}",
            data: {
                '_token': '{{ csrf_token() }}',
                'mill': mill,
                'division': division,
                'mach_type': mach_type,
                'mach_id': mach_id,
                'periode': param
            },
            success: function(data) {

                if (data.length > 0) {

                    dataPoints4_fulltime = []; dataPoints4_downtime = []; dataPoints4_runtime = [];
                    for (var i = 0; i < data.length; i++) {
                        dataPoints4_fulltime.push({ label: data[i].day, y: parseFloat(data[i].fulltime) });
                        dataPoints4_downtime.push({ label: data[i].day, y: parseFloat(data[i].downtime) });
                        dataPoints4_runtime.push({ label: data[i].day, y: parseFloat(data[i].runtime) });
                    } 
                    tittle_daily = 'Date Period ' + param;
                    getChart4(tittle_daily, dataPoints4_fulltime, dataPoints4_downtime, dataPoints4_runtime, label)

                    $.unblockUI();

                } else {

                    dataPoints4_fulltime = []; dataPoints4_downtime = []; dataPoints4_runtime = [];
                    dataPoints4_fulltime.push({ y: 0 });
                    dataPoints4_downtime.push({ y: 0 });
                    dataPoints4_runtime.push({ y: 0 });
                    tittle_daily = 'Date Period ' + param;
                    getChart4(tittle_daily, dataPoints4_fulltime, dataPoints4_downtime, dataPoints4_runtime, label);

                    $.unblockUI();
                    swal("Downtime Chart - Daily", "Data not available", "error");
                }
            }
        });


    });

    $('.toMonthly').on('click', function() {

        result2.style.display="none";
        result3.style.display="none";

        blockUI();

        var block_periode_daily = $('#periode_daily_loading');
        blockElement(block_periode_daily);

        $.ajax({
            type: "POST",
            url: "{{ url('chartDownTime') }}",
            data: {
                '_token': '{{ csrf_token() }}',
                'mill': mill,
                'division': division,
                'mach_type': mach_type,
                'mach_id': mach_id,
                'start': start,
                'end': end
            },
            success: function(data) {

                    if (data.length > 0) {

                        dataPoints1_fulltime = []; dataPoints1_downtime = []; dataPoints1_runtime = [];
                        for (var i = 0; i < data.length; i++) {
                            dataPoints1_fulltime.push({ label: data[i].Periode, y: parseFloat(data[i].fulltime) });
                            dataPoints1_downtime.push({ label: data[i].Periode, y: parseFloat(data[i].downtime) });
                            dataPoints1_runtime.push({ label: data[i].Periode, y: parseFloat(data[i].runtime) });
                        }

                        tittle = 'Date Period '+data[0].Periode+' - '+data[data.length-1].Periode;
                        getChart1(tittle, dataPoints1_fulltime, dataPoints1_downtime, dataPoints1_runtime, label);

                        // Fill select periode Chart Downtime Daily
                        $('select[name="periode_daily"]').empty();
                        $('select[name="periode_daily"]').prepend('<option></option>');

                        $.each(data, function(index, element) {
                            $('select[name="periode_daily"]').append('<option value="' + element.Periode + '">' + element.Periode + '</option>');
                        });
                        $(block_periode_daily).unblock();

                        $('#periode_daily').select2({
                            placeholder: 'Choose Periode below',
                            allowClear: true
                        });

                        $.unblockUI();


                    }
                    else {


                        dataPoints1_fulltime = []; dataPoints1_downtime = []; dataPoints1_runtime = [];
                        dataPoints1_fulltime.push({ y: 0 });
                        dataPoints1_downtime.push({ y: 0 });
                        dataPoints1_runtime.push({ y: 0 });
                        tittle = 'Date Period -';
                        getChart1(tittle, dataPoints1_fulltime, dataPoints1_downtime, dataPoints1_runtime, label);

                        $.unblockUI();
                        swal("Downtime Chart", "Data not available",  "error");
                        
                    }
                }
        });

    });

    $('.toDaily').on('click', function() {

        result2.style.display="none";
        result3.style.display="none";

        blockUI();

        // Chart Downtime Daily
        $.ajax({
            type: "POST",
            url: "{{ url('chartDownTimeDaily') }}",
            data: {
                '_token': '{{ csrf_token() }}',
                'mill': mill,
                'division': division,
                'mach_type': mach_type,
                'mach_id': mach_id,
                'periode': periode_daily
            },
            success: function(data) {

                if (data.length > 0) {

                    dataPoints4_fulltime = []; dataPoints4_downtime = []; dataPoints4_runtime = [];
                    for (var i = 0; i < data.length; i++) {
                        dataPoints4_fulltime.push({ label: data[i].day, y: parseFloat(data[i].fulltime) });
                        dataPoints4_downtime.push({ label: data[i].day, y: parseFloat(data[i].downtime) });
                        dataPoints4_runtime.push({ label: data[i].day, y: parseFloat(data[i].runtime) });
                    }


                    tittle_daily = 'Date Period ' + periode_daily;
                    getChart4(tittle_daily, dataPoints4_fulltime, dataPoints4_downtime, dataPoints4_runtime, label);

                    $.unblockUI();

                } else {
                    
                    
                    dataPoints4_fulltime = []; dataPoints4_downtime = []; dataPoints4_runtime = [];
                    dataPoints4_fulltime.push({ y: 0 });
                    dataPoints4_downtime.push({ y: 0 });
                    dataPoints4_runtime.push({ y: 0 });
                    tittle_daily = 'Date Period ' + periode_daily;
                    getChart4(tittle_daily, dataPoints4_fulltime, dataPoints4_downtime, dataPoints4_runtime, label);

                    $.unblockUI();
                    swal("Downtime Chart - Daily", "Data not available", "error");

                }
            }
        });
    });








});


</script>

@endsection
{{-- Content Page JS End--}}
