@extends('main')

{{-- Content Page CSS Begin--}}
@section('contentcss')
<link href="{{ asset('outside/plugins/notification/snackbar/snackbar.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('outside/plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/style.css">
<link href="{{ asset('outside/assets/css/components/tabs-accordian/custom-tabs.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/select2/select2.min.css') }}">
<link href="{{ asset('outside/assets/css/components/custom-modal.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.4/css/responsive.dataTables.min.css" />
<style>

.widget-content-area {
  box-shadow: none !important; }

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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('DelivAnalysis') }}">Deliv Analysis</a></li>
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
                            <h4>Delivery Report Analysis</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">

                    <div class="form-row mb-6">
                        <div class="form-group col-md-4">
                            <label class="text-dark" for="mill">Mill</label>
                            <div id="mill_loading">
                            <select class="form-control basic select2" name="mill" id="mill">
                                <option></option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="text-dark" for="division">Division</label>
                            <div id="div_loading">
                            <select class="form-control basic select2" name="division" id="division">
                                <option></option>
                            </select>
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label class="text-dark" for="mach_type">Mach Type</label>
                            <a id="mach_type_badge"><span class="badge badge-danger">N/A</span></a>
                            <div id="mach_type_loading">
                            <select class="form-control basic select2" name="mach_type" id="mach_type">
                                <option></option>
                            </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row mb-6">
                        <div class="form-group col-md-5">
                            <label class="text-dark" for="start">Start Period Date</label>
                            <span class="badge badge-info">Ship Date</span>
                            <input id="start" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select start date">
                        </div>
                        <div class="form-group col-md-5">
                            <label class="text-dark" for="end">End Period Date</label>
                            <span class="badge badge-info">Ship Date</span>
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

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing" id="result" style="display: none">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Delivery Analysis (Monthly)</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">

                    <div id="chartContainer1" style="height: 370px; width: 100%;"></div>

                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing" id="result2" style="display: none">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4 id="TitleDetail"></h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">

                    <div class="table-responsive">
                        <table class="table mb-4" style="width:100%" id="DetailDelivery">
                          <thead>
                              <tr>
                                  <th>MillName</th>
                                  <th>OrderID</th>
                                  <th>DelivID</th>
                                  <th>ShipDate</th>
                                  <th>DtRcv</th>
                                  <th>RealTimeDeliv(Day)</th>
                              </tr>
                          </thead>
                        </table>
                      </div>

                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="chartDaily" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" id="modalLoad">
            <div class="modal-header">
                <h4 class="modal-title">OnTime Delivery (Daily)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">

                <div id="chartContainer2" style="height: 370px; width: 100%;"></div>

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
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.4/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.4/js/responsive.bootstrap4.min.js"></script>
<script>

var label, tittle, block; 
var x = window.matchMedia("(max-width: 991px)")
var mill, division, mach_type, start, end;
var dp_avg1, dp_max1, dp_min1, dp_modus1;
var dp_avg2, dp_max2, dp_min2, dp_modus2;

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
        url: "{{url('listDivisionDeliv')}}",
        success: function (data) {
            $(block).unblock()
            $('select[name="division"]').empty();
            $('select[name="division"]').prepend('<option></option>');
            $.each(data, function(index, element) {
            $('select[name="division"]').append('<option value="'+element.divisi+'">'+element.descr+'</option>');
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
        url: "{{url('listMachTypeMillDeliv/mill=')}}"+mill,
        success: function (data) {
            $(block).unblock();
            $('select[name="mach_type"]').empty();
            $('select[name="mach_type"]').prepend('<option></option>');
            $.each(data, function(index, element) {
            $('select[name="mach_type"]').append('<option value="'+element.mach_type+'">'+element.mach_type+' || '+element.mesin+'</option>');
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
        url: "{{url('listMachTypeMillDivDeliv/mill=')}}"+mill+ "&div=" +div,
        success: function (data) {
            $(block).unblock();
            $('select[name="mach_type"]').empty();
            $('select[name="mach_type"]').prepend('<option></option>');
            $.each(data, function(index, element) {
            $('select[name="mach_type"]').append('<option value="'+element.mach_type+'">'+element.mach_type+' || '+element.mesin+'</option>');
            });
        }
    });

    $('#mach_type').select2({
        placeholder: 'Choose MachType below',
        allowClear: true
    });

}

function getChart1(tittle, dp_avg1, dp_max1, dp_min1, dp_modus1, label){
    var chart1 = new CanvasJS.Chart("chartContainer1", {
	    animationEnabled: true,
        exportEnabled: true,
        theme: "light2",
        title: {
            text: tittle,
            fontFamily: "Calibri",
            fontSize: 20
        },
        subtitles:[
            {
                text: label,
                fontFamily: "Calibri",
                fontColor: "red",
                fontSize: 12
            }
        ],
        exportEnabled: true,
        axisY: {
            scaleBreaks: {
                autoCalculate: true,
                type: "wavy"
		    },
            crosshair: {
			    enabled: true,
                snapToDataPoint: true
		    },
            title: "Days"
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
                click: onClick1,
                name: "Average",
                showInLegend: true,
                indexLabel: "{y}",
                indexLabelPlacement: "outside",
                indexLabelOrientation: "horizontal",
                // indexLabelFontColor: "#fff",
                // indexLabelFontWeight: "bold",
                indexLabelFontSize: 12,
                indexLabelFontFamily: "calibri",
                color: "#556052", //ijo dongker
                // yValueFormatString: "#,###,,,.##"
            },
            {
                type: "column",
                click: onClick1,
                name: "Max",
                showInLegend: true,
                indexLabel: "{y}",
                indexLabelPlacement: "outside",
                indexLabelOrientation: "horizontal",
                // indexLabelFontColor: "#fff",
                // indexLabelFontWeight: "bold",
                indexLabelFontSize: 12,
                indexLabelFontFamily: "calibri",
                color: "#8f384d", //merah
                // yValueFormatString: "#,###,,,.##"
            },
            {
                type: "column",
                click: onClick1,
                name: "Min",
                showInLegend: true,
                indexLabel: "{y}",
                indexLabelPlacement: "outside",
                indexLabelOrientation: "horizontal",
                // indexLabelFontColor: "#fff",
                // indexLabelFontWeight: "bold",
                indexLabelFontSize: 12,
                indexLabelFontFamily: "calibri",
                color: "#132743", //biru dongker
                // yValueFormatString: "#,###,,,.##"
            },
            {
                type: "column",
                click: onClick1,
                name: "Modus",
                showInLegend: true,
                indexLabel: "{y}",
                indexLabelPlacement: "outside",
                indexLabelOrientation: "horizontal",
                // indexLabelFontColor: "#fff",
                // indexLabelFontWeight: "bold",
                indexLabelFontSize: 12,
                indexLabelFontFamily: "calibri",
                color: "#00b7c2", //ijo
                // yValueFormatString: "#,###,,,.##"
            },
        ]
    });

    chart1.options.data[0].dataPoints = dp_avg1;
    chart1.options.data[1].dataPoints = dp_max1;
    chart1.options.data[2].dataPoints = dp_min1;
    chart1.options.data[3].dataPoints = dp_modus1;
    // showDefaultText(chart1, "No Data Found!");

    if (x.matches) {

        for(var i = 0; i < chart1.options.data.length; i++){
            chart1.options.data[i].indexLabelFontSize = 8;
        }
        chart1.render();
    }
    chart1.render();
}

function getChart2(tittle, dataPoints2_totalShip, dataPoints2_otShip, dataPoints2_realShip, dataPoints2_pctOt, dataPoints2_pctReal,label){
    chart2 = new CanvasJS.Chart("chartContainer2", {
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
            // title: "Hourly",
            // labelFormatter: addSymbols,
            // stripLines: [{
            //     value: sum,
            //     label: "Average",
            //     color: "#ff8c00",
            //     labelFontColor: "#ff8c00",

            // }]
        },
        axisY2: {
            title: "(%)",
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
            // {
            //     type: "column",
            //     name: "Total Shipment",
            //     showInLegend: true,
            //     indexLabel: "{y}",
            //     indexLabelPlacement: "outside",
            //     indexLabelOrientation: "horizontal",
            //     indexLabelFontWeight: "bold",
            //     indexLabelFontSize: 12,
            //     indexLabelFontFamily: "calibri",
            //     color: "#00b7c2" //ijo
            // },
	        {
                type: "column",
                name: "OnTime",
                showInLegend: true,
                indexLabel: "{y}",
                indexLabelPlacement: "outside",
                indexLabelOrientation: "horizontal",
                indexLabelFontWeight: "bold",
                indexLabelFontSize: 10,
                indexLabelFontFamily: "calibri",
                indexLabelFontColor: "#4ea0ae",
                color: "#4ea0ae"

            },
            // {
            //     type: "column",
            //     name: "RealTime",
            //     showInLegend: true,
            //     indexLabel: "{y}",
            //     indexLabelPlacement: "outside",
            //     indexLabelOrientation: "horizontal",
            //     indexLabelFontWeight: "bold",
            //     indexLabelFontSize: 10,
            //     indexLabelFontFamily: "calibri",
            //     indexLabelFontColor: "#f9d56e",
            //     color: "#f9d56e"
            // },
            {
                type: "spline",
                name: "OnTime (%)",
                axisYType: "secondary",
                yValueFormatString: "0.##\"%\"",
                showInLegend: true,
                // indexLabel: "{y}",
                indexLabelPlacement: "inside",
                indexLabelOrientation: "horizontal",
                indexLabelFontWeight: "bold",
                indexLabelFontSize: 13,
                indexLabelFontFamily: "calibri",
                indexLabelFontColor: "#ffacb7",
                color: "#ffacb7"
            },
            // {
            //     type: "spline",
            //     name: "RealTime (%)",
            //     axisYType: "secondary",
            //     yValueFormatString: "0.##\"%\"",
            //     showInLegend: true,
            //     // indexLabel: "{y}",
            //     indexLabelPlacement: "inside",
            //     indexLabelOrientation: "horizontal",
            //     indexLabelFontWeight: "bold",
            //     indexLabelFontSize: 13,
            //     indexLabelFontFamily: "calibri",
            //     indexLabelFontColor: "#6886c5",
            //     color: "#6886c5"
            // }
        ]
    });
    //chart1.options.data[0].dataPoints = dataPoints1_totalShip;
    // chart2.options.data[0].dataPoints = dataPoints2_otShip;
    // chart2.options.data[1].dataPoints = dataPoints2_realShip;
    // chart2.options.data[2].dataPoints = dataPoints2_pctOt;
    // chart2.options.data[3].dataPoints = dataPoints2_pctReal;

    chart2.options.data[0].dataPoints = dataPoints2_otShip;
    chart2.options.data[1].dataPoints = dataPoints2_pctOt;
    showDefaultText(chart2, "No Data Found!");

    if (x.matches) {

        for(var i = 0; i < chart2.options.data.length; i++){
            chart2.options.data[i].indexLabelFontSize = 6;
        }
        chart2.render();
    }

    chart2.render();
}

function toggleDataSeries(e) {
	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else {
		e.dataSeries.visible = true;
	}
	e.chart.render();
}

function addSymbols(e) {
	var suffixes = ["", "K", "M", "B"];
	var order = Math.max(Math.floor(Math.log(e.value) / Math.log(1000)), 0);

	if(order > suffixes.length - 1)
		order = suffixes.length - 1;

	var suffix = suffixes[order];
	return CanvasJS.formatNumber(e.value / Math.pow(1000, order)) + suffix;
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
    chart.options.data[0].showInLegend = true;
  }
}

function onClick1(e){

    // $("#chartDaily").modal();
    // blockModal(block);
    blockUI();
    var param = e.dataPoint.label;

    $('#TitleDetail').text("Delivery Analysis "+param);

    @if(Session::has('MILLID'))

        mill = '{{ Session::get('MILLID') }}';

    @else

        mill = $('#mill').val();

    @endif

    // $.ajax({
    //     type: "POST",
        // url: "{{ url('chartDelivDaily') }}",
        // data: {
        //     '_token': '{{ csrf_token() }}',
        //     'mill': mill,
        //     'division': division,
        //     'mach_type': mach_type,
        //     'periode': param
        // },
    //     success: function(data) {

    //         if (data.length > 0) {

    //             dataPoints2_totalShip = []; dataPoints2_otShip = []; dataPoints2_realShip = [];
    //             dataPoints2_pctOt = []; dataPoints2_pctReal = [];
    //             for (var i = 0; i < data.length; i++) {
    //                 // dataPoints2_totalShip.push({ label: data[i].periode, y: parseInt(data[i].tot_ship) });
    //                 dataPoints2_otShip.push({  label: data[i].ship_date,  y: parseFloat(data[i].ot_ship) });
    //                 dataPoints2_realShip.push({ label: data[i].ship_date,  y: parseFloat(data[i].real_ship) });
    //                 dataPoints2_pctOt.push({ label: data[i].periode,  y: parseFloat(data[i].pct_ot) });
    //                 dataPoints2_pctReal.push({ label: data[i].periode,  y: parseFloat(data[i].pct_real) });
    //             }

    //             $(block).unblock();

    //             tittle = 'Date Period '+param;
    //             getChart2(tittle, dataPoints2_totalShip, dataPoints2_otShip, dataPoints2_realShip, dataPoints2_pctOt, dataPoints2_pctReal, label);

    //         }

    //         else{

    //             swal("Deliv Chart Daily", "Data not available",  "error");
    //             dataPoints2_totalShip = []; dataPoints2_otShip = []; dataPoints2_realShip = [];
    //             dataPoints2_pctOt = []; dataPoints2_pctReal = [];
    //             dataPoints2_totalShip.push({ y: 0 });
    //             dataPoints2_otShip.push({ y: 0 });
    //             dataPoints2_realShip.push({ y: 0 });
    //             dataPoints2_pctOt.push({ y: 0 });
    //             dataPoints2_pctReal.push({ y: 0 });
    //             tittle = 'Date Period '+param;
    //             getChart2(tittle, dataPoints2_totalShip, dataPoints2_otShip, dataPoints2_realShip, dataPoints2_pctOt, dataPoints2_pctReal, label);
    //         }
    //     }
    // });

    var dataTable = $('#DetailDelivery').DataTable({
            "oLanguage": {
                        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                        "sInfo": "Showing page _PAGE_ of _PAGES_",
                        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                        "sSearchPlaceholder": "Search...",
                        "sLengthMenu": "Show :  _MENU_ entries",
                        },
            destroy: true,
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            pageLength: 10,
            "order": [[ 4, "asc" ]],
            ajax: {
                url: "{{ url('chartDelivDaily') }}",
                type: "post",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'mill': mill,
                    'division': division,
                    'mach_type': mach_type,
                    'periode': param
                }
            },
            columns: [
                { data: 'mill_name', name: 'mill_name'},
                { data: 'Order_id', name: 'Order_id'},
                { data: 'deliv_id', name: 'deliv_id'},
                { data: 'ship_date', name: 'ship_date'},
                { data: 'dt_rcv', name: 'dt_rcv'},
                { data: 'selisih', name: 'selisih'},
                ],
                initComplete: function(settings, json) {
                if (dataTable.rows().data().length) {
                    $.unblockUI();
                   
                    result2.style.display="block";
                    $('html, body').animate({
                        scrollTop: $("#result2").offset().top
                    }, 1200);
                }
                if (!dataTable.rows().data().length) {
                    $.unblockUI();
                    swal("Oops! :(", "Data not available", "error");
                    result2.style.display="block";
                }
            },
        }); 




}


$(document).ready(function() {

    $('#homeNav').attr('data-active','false');
    $('#homeNav').attr('aria-expanded','false');
    $('#ReportNav').attr('data-active','true');
    $('#ReportNav').attr('aria-expanded','true');
    $('.ReportTreeView').addClass('show');
    $('#DelivAnalysis').addClass('active');


    $('.select2').on('select2:open', function() {
        if (Modernizr.touch) {
            $('.select2-search__field').prop('focus', false);
        }
    });

    @if(Session::has('MILLID'))


        var mill = '{{ Session::get('MILLID') }}';

        if (mill) {

            $('#mach_type_badge').empty();
            html = "<span class='badge badge-success'>Mill ID #"+mill+"</span>";
            $('#mach_type_badge').empty();
            $('#mach_type_badge').append(html);
            listMachTypeMill(mill);


        }

        $('#division').change(function(){

            mill = '{{ Session::get('MILLID') }}';
            var div = $('#division').val();
            $('select[name="mach_id"]').empty();
            $('select[name="mach_type"]').empty();

            if (!div){

                $('#mach_type_badge').empty();
                html = "<span class='badge badge-success'>Mill ID #"+mill+"</span>";
                $('#mach_type_badge').empty();
                $('#mach_type_badge').append(html);
                listMachTypeMill(mill);

            }

            else if (mill && !div){

                $('#mach_type_badge').empty();
                html = "<span class='badge badge-success'>Mill ID #"+mill+"</span>";
                $('#mach_type_badge').empty();
                $('#mach_type_badge').append(html);
                listMachTypeMill(mill);

            }

            else if (mill && div){

                $('#mach_type_badge').empty();
                html = "<span class='badge badge-success'>Mill ID #"+mill+" & Division #"+div+"</span>";
                $('#mach_type_badge').empty();
                $('#mach_type_badge').append(html);
                listMachTypeMillDiv(mill, div);


            }
            else if (!mill && div){

                $('#mach_type_badge').empty();
                html = "<span class='badge badge-danger'>N/A</span>";
                $('#mach_type_badge').empty();
                $('#mach_type_badge').append(html);
                listMachType();

            }


        });

    @else

        listMachType();

        $('#mill').change(function(){

            var mill = $('#mill').val();
            var div = $('#division').val();
            $('select[name="mach_type"]').empty();

            if (!mill && !div){

                $('#mach_type_badge').empty();
                html = "<span class='badge badge-danger'>N/A</span>";
                $('#mach_type_badge').empty();
                $('#mach_type_badge').append(html);
                listMachType();

            }

            else if (mill && !div){

                $('#mach_type_badge').empty();
                html = "<span class='badge badge-success'>Mill ID #"+mill+"</span>";
                $('#mach_type_badge').empty();
                $('#mach_type_badge').append(html);
                listMachTypeMill(mill);

            }

            else if (mill && div){

                $('#mach_type_badge').empty();
                html = "<span class='badge badge-success'>Mill ID #"+mill+" & Division #"+div+"</span>";
                $('#mach_type_badge').empty();
                $('#mach_type_badge').append(html);
                listMachTypeMillDiv(mill, div);


            }
            else if (!mill && div){

                $('#mach_type_badge').empty();
                html = "<span class='badge badge-danger'>N/A</span>";
                $('#mach_type_badge').empty();
                $('#mach_type_badge').append(html);
                listMachType();

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

            }

            else if (mill && !div){

                $('#mach_type_badge').empty();
                html = "<span class='badge badge-success'>Mill ID #"+mill+"</span>";
                $('#mach_type_badge').empty();
                $('#mach_type_badge').append(html);
                listMachTypeMill(mill);

            }

            else if (mill && div){

                $('#mach_type_badge').empty();
                html = "<span class='badge badge-success'>Mill ID #"+mill+" & Division #"+div+"</span>";
                $('#mach_type_badge').empty();
                $('#mach_type_badge').append(html);
                listMachTypeMillDiv(mill, div);


            }
            else if (!mill && div){

                $('#mach_type_badge').empty();
                html = "<span class='badge badge-danger'>N/A</span>";
                $('#mach_type_badge').empty();
                $('#mach_type_badge').append(html);
                listMachType();

            }


        });


    @endif

    listMill(); listDivision();

    var result = document.getElementById("result");
    var result2 = document.getElementById("result2");


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
        block = $('#modalLoad');  

        @if(Session::has('MILLID'))

            mill = '{{ Session::get('MILLID') }}';

        @else

            mill = $('#mill').val();

        @endif

        division = $('#division').val();
        mach_type = $('#mach_type').val();
        start = $('#start').val();
        end = $('#end').val();

        if (!end) {

            var today = new Date();
            //var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();
            end = yyyy+mm;
            //end = yyyy+mm+dd;
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
                label = 'Mill #'+mill;
            }

            if (division){

                // allreq = allreq+'&division='+division.trim();
                label = label+', Div #'+division.trim();
            }

            if (mach_type){

                // allreq = allreq+'&mach_type='+mach_type.trim();
                label = label+', MachType #'+mach_type.trim();
            }


            if (start && end){

                // allreq = allreq+'&start='+start.trim();
                // allreq = allreq+'&end='+end.trim();
            }

            // do some here

            blockUI();

            $.ajax({
                type: "POST",
                url: "{{ url('chartDeliv') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'mill': mill,
                    'division': division,
                    'mach_type': mach_type,
                    'start': start,
                    'end': end
                },
                success: function(data) {

                    if (data.length > 0) {

                        result2.style.display="none";

                        dp_avg1 = []; dp_max1 = []; dp_min1 = []; dp_modus1 = [];

                        for (var i = 0; i < data.length; i++) {
                            // dataPoints1_totalShip.push({ label: data[i].periode, y: parseInt(data[i].tot_ship) });
                            dp_avg1.push({  label: data[i].periode,  y: parseFloat(data[i].average) });
                            dp_max1.push({ label: data[i].periode,  y: parseFloat(data[i].maxim) });
                            dp_min1.push({ label: data[i].periode,  y: parseFloat(data[i].minim) });
                            dp_modus1.push({ label: data[i].periode,  y: parseFloat(data[i].modus) });
                        }
                        tittle = 'Date Period '+data[0].periode+' - '+data[data.length-1].periode;
                        result.style.display="block";
                        $.unblockUI();
                        $('html, body').animate({
                            scrollTop: $("#result").offset().top
                        }, 1200);
                        getChart1(tittle, dp_avg1, dp_max1, dp_min1, dp_modus1, label);

                    }

                    else{

                        result2.style.display="none";

                        $.unblockUI();
                        swal("Deliv Chart", "Data not available",  "error");
                        dp_avg1 = []; dp_max1 = []; dp_min1 = []; dp_modus1 = [];
                        dp_avg1.push({ y: 0 });
                        dp_max1.push({ y: 0 });
                        dp_min1.push({ y: 0 });
                        dp_modus1.push({ y: 0 });
                        tittle = 'Date Period -';
                        getChart1(tittle, dp_avg1, dp_max1, dp_min1, dp_modus1, label);
                    }
                }
            });

        }

    });

    $('#reset').on('click', function() {

        listMill();
        $('#division').val(null).trigger('change');
        $('#mach_type').val(null).trigger('change');
        f1.clear();
        f2.clear();
        result.style.display="none";
        result2.style.display="none";
    });










});


</script>

@endsection
{{-- Content Page JS End--}}
