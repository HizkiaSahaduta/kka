@extends('main')

{{-- Content Page CSS Begin--}}
@section('contentcss')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/style.css">
<link href="{{ asset('outside/plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.4/css/responsive.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/select2/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('outside/assets/css/widgets/modules-widgets.css') }}"> 
<style>
.badge {
  background: transparent;
}

.widget-content-area {
  box-shadow: none !important; }

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

.modal-dialog {
    max-width: 1200px;
    margin: 1.75rem auto;
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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('PerformanceAnalysis') }}">Purchase Analysis</a></li>
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
                            <h4>Purchase Analysis</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">

                    <div class="form-row mb-6">
                        <div class="form-group col-md-5">
                            <label class="text-dark" for="txtOfficeID">Office</label>
                            <div id="txtOfficeID_loading">
                            <select class="form-control basic" name="txtOfficeID" id="txtOfficeID">
                                <option></option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group col-md-5">
                            <label class="text-dark" for="txtUserID">User</label>
                            <div id="txtUserID_loading">
                            <select class="form-control basic" name="txtUserID" id="txtUserID">
                                <option></option>
                            </select>
                            </div>
                        </div>
                    </div>
                
                    <div class="form-row mb-6">
                        <div class="form-group col-md-5">
                            <label class="text-dark" for="txtStartDate">Start Date</label>
                            <span class="badge badge-info">Period Date</span>
                            <input id="txtStartDate" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select start date">
                        </div>
                        <div class="form-group col-md-5">
                            <label class="text-dark" for="txtEndDate">End Date</label>
                            <span class="badge badge-info">Period Date</span>
                            <input id="txtEndDate" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select end date">
                        </div>
                    </div>

                    <div class="form-row mb-6">
                        <div class="form-group col-md-5">
                            <label class="text-dark" for="txtStatus">PR Status</label>
                            <select class="form-control basic" name="txtStatus" id="txtStatus">
                                <option></option>
                                <option value='All' selected>All (O/C)</option>
                                <option value='C'>Close</option>
                                <option value='O'>Open</option>
                            </select>
                        </div>
                        <div class="form-group col-md-5">
                            <label class="text-dark" for="txtRaw">Rawmat / General ?</label>
                            <select class="form-control basic" name="txtRaw" id="txtRaw">
                                <option></option>
                                <option value='Rawmat'>Rawmat</option>
                                <option value='General' selected>General</option>
                            </select>
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

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing" id="ReportAnalysis" style="display: none">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Chart Purchase Analysis</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">

                    <div id="container1" style="height: 370px; width: 100%;"></div>

                </div>
            </div>
        </div>


    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="detailAnalysisModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" id="modalLoad">
            <div class="modal-header">
                <div id="headerModal"></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">

                <div id="Cstep1">
                    <div class="table-responsive">
                        <table id="step1" class="table mb-4" style="width:100%">
                            <thead>
                               <tr>
                                   <th>Periode</th>
                                   <th>PRU ID</th>
                                   <th>DtPR</th>
                                   <th>DtAprvl</th>
                                   <th>Interval</th>
                               </tr>
                            </thead>
                        </table>
                    </div>   
                </div>  
    
                <div id="Cstep2" style="display: none">
                    <div class="table-responsive">
                        <table id="step2" class="table mb-4" style="width:100%">
                            <thead>
                               <tr>
                                   <th>Periode</th>
                                   <th>PR ID</th>
                                   <th>PR Item</th>
                                   <th>Descr</th>
                                   <th>PO ID</th>
                                   <th>DtAprvl</th>
                                   <th>DtPO</th>
                                   <th>Interval</th>
                               </tr>
                            </thead>
                        </table>
                    </div>   
                </div>  
    
                <div id="Cstep3" style="display: none">
                    <div class="table-responsive">
                        <table id="step3" class="table mb-4" style="width:100%">
                            <thead>
                               <tr>
                                   <th>Periode</th>
                                   <th>PR ID</th>
                                   <th>PR Item</th>
                                   <th>Descr</th>
                                   <th>PO ID</th>
                                   <th>PO Item</th>
                                   <th>RCV ID</th>
                                   <th>DtPO</th>
                                   <th>DtRCV</th>
                                   <th>Interval</th>
                               </tr>
                            </thead>
                        </table>
                    </div>   
                </div>  
    
                <div id="Cstep4" style="display: none">
                    <div class="table-responsive">
                        <table id="step4" class="table mb-4" style="width:100%">
                            <thead>
                               <tr>
                                   <th>Periode</th>
                                   <th>PR ID</th>
                                   <th>PR Item</th>
                                   <th>Descr</th>
                                   <th>PO ID</th>
                                   <th>PO Item</th>
                                   <th>RCV ID</th>
                                   <th>DtPR</th>
                                   <th>DtRCV</th>
                                   <th>Interval</th>
                               </tr>
                            </thead>
                        </table>
                    </div>   
                </div>  
  
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
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.4/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('outside/plugins/notification/snackbar/snackbar.min.js') }}"></script>
<script src="{{ asset('outside/plugins/flatpickr/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/index.js"></script>
<script src="{{ asset('outside/plugins/blockui/jquery.blockUI.min.js') }}"></script>
<script src="{{ asset('outside/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('canvasjs.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js" integrity="sha512-lOtDAY9KMT1WH9Fx6JSuZLHxjC8wmIBxsNFL6gJPaG7sLIVoSO9yCraWOwqLLX+txsOw0h2cHvcUJlJPvMlotw==" crossorigin="anonymous"></script>
<script>

var txtOfficeID, txtUserID, count, txtStep
var dp1, dp2, dp3, dp4, container, title, label;
var x = window.matchMedia("(max-width: 991px)");
var QtxtOfficeID, QtxtUserID, QtxtStartDate, QtxtEndDate, QtxtStatus, QtxtRaw

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

function DefListOffice(){

    var block = $('#txtOfficeID_loading');
    blockElement(block);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('DefListOffice')}}",
        success: function (data) {
            $(block).unblock();
            $('select[name="txtOfficeID"]').empty();
            $('select[name="txtOfficeID"]').prepend('<option></option>');
            $.each(data, function(index, element) {
            $('select[name="txtOfficeID"]').append('<option value="'+element.dept_id+'">'+element.descr_depart+'</option>');
            });
        }
    });

    $('#txtOfficeID').select2({
        placeholder: 'Choose Office below',
        allowClear: true
    });
   
}

function DefListUser(){

    var block = $('#txtUserID_loading');
    blockElement(block);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('DefListUser')}}",
        success: function (data) {
            $(block).unblock();
            $('select[name="txtUserID"]').empty();
            $('select[name="txtUserID"]').prepend('<option></option>');
            $.each(data, function(index, element) {
            $('select[name="txtUserID"]').append('<option value="'+element.user_id+'">'+element.user_id+'</option>');
            });
        }
    });

    $('#txtUserID').select2({
        placeholder: 'Choose user below',
        allowClear: true
    });
   
}

function DefStat() {

    $('#txtStat').select2({
        placeholder: 'Choose Status below',
        allowClear: true
    });

}

function DefRaw() {

    $('#txtRaw').select2({
        placeholder: 'Rawmat / General ?',
        allowClear: true
    });
    
}

function listOfficeUser(txtUserID) {

    var block = $('#txtOfficeID_loading');
    blockElement(block);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('ListOfficeUser/id=')}}"+txtUserID,
        success: function (data) {
            $(block).unblock();

            count = Object.keys(data).length; 
            $('select[name="txtOfficeID"]').empty();
            $('select[name="txtOfficeID"]').prepend('<option></option>');

            if (count < 2) {

                $.each(data, function(index, element) {
                    $('select[name="txtOfficeID"]').append('<option value="'+element.dept_id+'" selected>'+element.descr_depart+'</option>');
                });

            }
            else {

                $.each(data, function(index, element) {
                    $('select[name="txtOfficeID"]').append('<option value="'+element.dept_id+'">'+element.descr_depart+'</option>');
                });

            }
           
        }
    });

    $('#txtOfficeID').select2({
        placeholder: 'Choose Office below',
        allowClear: true
    });


}

function listUserOffice(txtOfficeID) {

    var block = $('#txtUserID_loading');
    blockElement(block);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('ListUserOffice/id=')}}"+txtOfficeID,
        success: function (data) {
            $(block).unblock();

            count = Object.keys(data).length; 
            $('select[name="txtUserID"]').empty();
            $('select[name="txtUserID"]').prepend('<option></option>');

            if (count < 2) {

                $.each(data, function(index, element) {
                    $('select[name="txtUserID"]').append('<option value="'+element.user_id+'" selected>'+element.user_id+'</option>');
                });

            }

            else {

                $.each(data, function(index, element) {
                    $('select[name="txtUserID"]').append('<option value="'+element.user_id+'">'+element.user_id+'</option>');
                });
                
            }
            
            
        }
    });

    $('#txtUserID').select2({
        placeholder: 'Choose user below',
        allowClear: true
    });
   
    
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

function getChart(dp1, dp2, dp3, dp4, container, title, label){

    var chart = new CanvasJS.Chart(container, {
        animationEnabled: true,
        theme: "light2",
        exportEnabled: true,
        title: {
            text: title,
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
        axisY: {
            crosshair: {
                enabled: true,
                snapToDataPoint: true
            },
            title: "DAYS'",
            labelFormatter: addSymbols,
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
                click: Step1,
                showInLegend: true,
                name: "PR->APRV",
                indexLabel: "{y}",
                indexLabelFontSize: 12,
                indexLabelFontFamily: "calibri",
            },
            {
                type: "column",
                click: Step2,
                showInLegend: true,
                name: "APRV->PO",
                indexLabel: "{y}",
                indexLabelFontSize: 12,
                indexLabelFontFamily: "calibri",
            },
            {
                type: "column",
                click: Step3,
                showInLegend: true,
                name: "PO->RCV",
                indexLabel: "{y}",
                indexLabelFontSize: 12,
                indexLabelFontFamily: "calibri",
            },
            {
                type: "column",
                click: Step4,
                showInLegend: true,
                name: "PR->RCV",
                indexLabel: "{y}",
                indexLabelFontSize: 12,
                indexLabelFontFamily: "calibri",
            }
        ]
    });

    chart.options.data[0].dataPoints = dp1;
    chart.options.data[1].dataPoints = dp2;
    chart.options.data[2].dataPoints = dp3;
    chart.options.data[3].dataPoints = dp4;

    // showDefaultText(chart, "No Data Found!");

    if (x.matches) {

        for(var i = 0; i < chart.options.data.length; i++){
            chart.options.data[i].indexLabelFontSize = 8;
        }
        chart.render();
    }
    chart.render();
}

function Step1(e){


    blockUI();

    txtStep = "step1";
    var txtParam = e.dataPoint.label;
    var HeaderDetail = "Periode: "+txtParam;
    $("#headerModal").html('<h4>PR->APRVL, Detail from '+HeaderDetail+'</h4>')

    var dataTable = $('#step1').DataTable({
        "oLanguage": {
                    "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Search",
                    "sLengthMenu": "Show :  _MENU_ entries",
        },
        stripeClasses: [],
        lengthMenu: [5, 10, 20, 50],
        pageLength: 10,
        destroy : true,
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            'url':'{!!url("getPurchaseAnalysisDetail")!!}',
            'type': 'post',
            data: {
                '_token': '{{ csrf_token() }}',
                'txtOfficeID': QtxtOfficeID,
                'txtUserID': QtxtUserID,
                'txtParam': txtParam, 
                'txtStatus': QtxtStatus, 
                'txtRaw': QtxtRaw,
                'txtStep': txtStep
            }
        },
        columns: [
            { data: 'period', name: 'period'},
            { data: 'pru_id', name: 'pru_id'},
            { data: 'dt_pru', name: 'dt_pru' },
            { data: 'dt_aprv', name: 'dt_aprv'},
            { data: 'DayInterval', name: 'DayInterval' }
        ],
        initComplete: function(settings, json) {

            if (!dataTable.rows().data().length) {

                $.unblockUI();

                swal("Whops", "Data not available", "error");
            }

            else {

                $.unblockUI();
                $('#detailAnalysisModal').modal('show');
                document.getElementById("Cstep1").style.display = "block";
                document.getElementById("Cstep2").style.display = "none";
                document.getElementById("Cstep3").style.display = "none";
                document.getElementById("Cstep4").style.display = "none";    
               
            }
        },
    });


}

function Step2(e){

    blockUI();

    txtStep = "step2";
    var txtParam = e.dataPoint.label;
    var HeaderDetail = "Periode: "+txtParam;
    $("#headerModal").html('<h4>APRV->PO, Detail from '+HeaderDetail+'</h4>')

    var dataTable = $('#step2').DataTable({
        "oLanguage": {
                    "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Search",
                    "sLengthMenu": "Show :  _MENU_ entries",
        },
        stripeClasses: [],
        lengthMenu: [5, 10, 20, 50],
        pageLength: 10,
        destroy : true,
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            'url':'{!!url("getPurchaseAnalysisDetail")!!}',
            'type': 'post',
            data: {
                '_token': '{{ csrf_token() }}',
                'txtOfficeID': QtxtOfficeID,
                'txtUserID': QtxtUserID,
                'txtParam': txtParam, 
                'txtStatus': QtxtStatus, 
                'txtRaw': QtxtRaw,
                'txtStep': txtStep
            }
        },
        columns: [
            { data: 'period', name: 'period'},
            { data: 'pru_id', name: 'pru_id'},
            { data: 'pru_item', name: 'pru_item'},
            { data: 'descr', name: 'descr'},
            { data: 'po_id', name: 'po_id'},
            { data: 'dt_aprv', name: 'dt_aprv'},
            { data: 'dt_po', name: 'dt_po' },
            { data: 'DayInterval', name: 'DayInterval' }
        ],
        initComplete: function(settings, json) {

            if (!dataTable.rows().data().length) {

                $.unblockUI();

                swal("Whops", "Data not available", "error");
            }

            else {

                $.unblockUI();
                $('#detailAnalysisModal').modal('show');
                document.getElementById("Cstep1").style.display = "none";
                document.getElementById("Cstep2").style.display = "block";
                document.getElementById("Cstep3").style.display = "none";
                document.getElementById("Cstep4").style.display = "none";    
               
            }
        },
    });



}

function Step3(e){

    blockUI();

    txtStep = "step3";
    var txtParam = e.dataPoint.label;
    var HeaderDetail = "Periode: "+txtParam;
    $("#headerModal").html('<h4>PO->RCV, Detail from '+HeaderDetail+'</h4>')

    var dataTable = $('#step3').DataTable({
        "oLanguage": {
                    "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Search",
                    "sLengthMenu": "Show :  _MENU_ entries",
        },
        stripeClasses: [],
        lengthMenu: [5, 10, 20, 50],
        pageLength: 10,
        destroy : true,
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            'url':'{!!url("getPurchaseAnalysisDetail")!!}',
            'type': 'post',
            data: {
                '_token': '{{ csrf_token() }}',
                'txtOfficeID': QtxtOfficeID,
                'txtUserID': QtxtUserID,
                'txtParam': txtParam, 
                'txtStatus': QtxtStatus, 
                'txtRaw': QtxtRaw,
                'txtStep': txtStep
            }
        },
        columns: [
            { data: 'period', name: 'period'},
            { data: 'pru_id', name: 'pru_id'},
            { data: 'pru_item', name: 'pru_item'},
            { data: 'descr', name: 'descr'},
            { data: 'po_id', name: 'po_id'},
            { data: 'po_item', name: 'po_item'},
            { data: 'rcv_id', name: 'rcv_id'},
            { data: 'dt_po', name: 'dt_po'},
            { data: 'dt_rcv', name: 'dt_rcv' },
            { data: 'DayInterval', name: 'DayInterval' }
        ],
        initComplete: function(settings, json) {

            if (!dataTable.rows().data().length) {

                $.unblockUI();

                swal("Whops", "Data not available", "error");
            }

            else {

                $.unblockUI();
                $('#detailAnalysisModal').modal('show');
                document.getElementById("Cstep1").style.display = "none";
                document.getElementById("Cstep2").style.display = "none";
                document.getElementById("Cstep3").style.display = "block";
                document.getElementById("Cstep4").style.display = "none";    
               
            }
        },
    });


}

function Step4(e){

    blockUI();

    txtStep = "step4";
    var txtParam = e.dataPoint.label;
    var HeaderDetail = "Periode: "+txtParam;
    $("#headerModal").html('<h4>PR->RCV, Detail from '+HeaderDetail+'</h4>')

    var dataTable = $('#step4').DataTable({
        "oLanguage": {
                    "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Search",
                    "sLengthMenu": "Show :  _MENU_ entries",
        },
        stripeClasses: [],
        lengthMenu: [5, 10, 20, 50],
        pageLength: 10,
        destroy : true,
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            'url':'{!!url("getPurchaseAnalysisDetail")!!}',
            'type': 'post',
            data: {
                '_token': '{{ csrf_token() }}',
                'txtOfficeID': QtxtOfficeID,
                'txtUserID': QtxtUserID,
                'txtParam': txtParam, 
                'txtStatus': QtxtStatus, 
                'txtRaw': QtxtRaw,
                'txtStep': txtStep
            }
        },
        columns: [
            { data: 'period', name: 'period'},
            { data: 'pru_id', name: 'pru_id'},
            { data: 'pru_item', name: 'pru_item'},
            { data: 'descr', name: 'descr'},
            { data: 'po_id', name: 'po_id'},
            { data: 'po_item', name: 'po_item'},
            { data: 'rcv_id', name: 'rcv_id'},
            { data: 'dt_pru', name: 'dt_pru'},
            { data: 'dt_rcv', name: 'dt_rcv' },
            { data: 'DayInterval', name: 'DayInterval' }
        ],
        initComplete: function(settings, json) {

            if (!dataTable.rows().data().length) {

                $.unblockUI();

                swal("Whops", "Data not available", "error");
            }

            else {

                $.unblockUI();
                $('#detailAnalysisModal').modal('show');
                document.getElementById("Cstep1").style.display = "none";
                document.getElementById("Cstep2").style.display = "none";
                document.getElementById("Cstep3").style.display = "none";
                document.getElementById("Cstep4").style.display = "block";    
               
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
    $('#PurchaseAnalysis').addClass('active');

    var ReportAnalysis = document.getElementById("ReportAnalysis");

    DefListOffice(); DefListUser(); DefStat(); DefRaw();

    $('.basic').on('select2:open', function() {
        if (Modernizr.touch) {
            $('.select2-search__field').prop('focus', false);
        }
    });

    var f1 = flatpickr(document.getElementById('txtStartDate'), {
        static: true,
        altInput: true,
        plugins: [new monthSelectPlugin({shorthand: false, dateFormat: "Ym", altFormat: "Ym"})],
        disableMobile: "true",
    });

    var f2 = flatpickr(document.getElementById('txtEndDate'), {
        static: true,
        altInput: true,
        plugins: [new monthSelectPlugin({shorthand: false, dateFormat: "Ym", altFormat: "Ym"})],
        disableMobile: "true",
    });

    
    $('#txtOfficeID').change(function(){

        txtOfficeID = $('#txtOfficeID').val();
        txtUserID = $('#txtUserID').val();

        if (txtOfficeID && !txtUserID) {
            
            listUserOffice(txtOfficeID);
        }

        if (txtUserID && !txtOfficeID) {
            
            listOfficeUser(txtUserID);
         }

        if (!txtOfficeID && !txtUserID) {
            
            DefListUser();
            DefListOffice();
        }

    });  

    $('#txtUserID').change(function(){

        
        txtUserID = $('#txtUserID').val();
        txtOfficeID = $('#txtOfficeID').val();

        if (txtUserID && !txtOfficeID) {
            
           listOfficeUser(txtUserID);
        }

        if (txtOfficeID && !txtUserID) {
            
            listUserOffice(txtOfficeID);
        }

        if (!txtUserID && !txtOfficeID) {

            DefListOffice();
            DefListUser();
        }
        
      

    });  

    $('#go').on('click', function() {

        label = '';
        title = 'Summary';

        QtxtOfficeID = $('#txtOfficeID').val();
        if(QtxtOfficeID) {

            var e = document.getElementById("txtOfficeID");
            var OfficeName = e.options[e.selectedIndex].text;
            title = OfficeName+' Summary';
           
        }
        QtxtUserID = $('#txtUserID').val();
        if(QtxtUserID) {
            label = label+'Req. by: '+QtxtUserID.trim();
        }
        QtxtStartDate = $('#txtStartDate').val();
        QtxtEndDate = $('#txtEndDate').val();
        if(QtxtStartDate && !QtxtEndDate) {
            label = label+', Periode >= '+QtxtStartDate.trim();
        } 
        if(QtxtEndDate && !QtxtStartDate) {
            label = label+', Periode <= '+QtxtEndDate.trim();
        }
        if(QtxtEndDate && QtxtStartDate) {
            label = label+', Periode: '+QtxtStartDate+' - '+QtxtEndDate.trim();
        }
        QtxtStatus = $('#txtStatus').val();
        if(QtxtStatus) {
            label = label+', PR Status: '+QtxtStatus.trim();
        }
        QtxtRaw = $('#txtRaw').val();
        if(QtxtRaw) {
            label = label+', Rawmat/General: '+QtxtRaw.trim();
        }

        blockUI();

        $.ajax({
            type: "POST",
            url: "{{ url('chartPurchaseAnalysis') }}",
            data: {
                '_token': '{{ csrf_token() }}',
                'txtOfficeID': QtxtOfficeID,
                'txtUserID': QtxtUserID,
                'txtStartDate': QtxtStartDate,
                'txtEndDate': QtxtEndDate,
                'txtStatus': QtxtStatus, 
                'txtRaw': QtxtRaw
            },
            success: function (data) {

                ReportAnalysis.style.display = "block";

                if (data['result'].length > 0) {

                    dp1 = []; dp2 = []; dp3 = []; dp4 = [];

                    for (var i = 0; i < data['result'].length; i++) {

                        dp1.push({  label: data['result'][i].period,  y: parseFloat(data['result'][i].step1) });
                        dp2.push({  label: data['result'][i].period,  y: parseFloat(data['result'][i].step2) });
                        dp3.push({  label: data['result'][i].period,  y: parseFloat(data['result'][i].step3) });
                        dp4.push({  label: data['result'][i].period,  y: parseFloat(data['result'][i].step4) });

                    }
                    container = 'container1';
                    getChart(dp1, dp2, dp3, dp4, container, title, label);
                    $.unblockUI();

                    $('html, body').animate({
                        scrollTop: $("#ReportAnalysis").offset().top
                    }, 1200)
                }

                else {
                    
                    dp1 = []; dp2 = []; dp3 = []; dp4 = [];
                    dp1.push({ y: 0 }); dp2.push({ y: 0 }); dp3.push({ y: 0 }); dp4.push({ y: 0 });
                    container = 'container1';
                    getChart(dp1, dp2, dp3, dp4, container, title, label);
                    $.unblockUI();

                    $('html, body').animate({
                        scrollTop: $("#ReportAnalysis").offset().top
                    }, 1200)
                }
                
            }
        });




        

    
    });

    $('#reset').on('click', function() {

        ReportAnalysis.style.display = "none";
        DefListOffice();
        DefListUser();
        f1.clear();
        f2.clear();
        $('#txtStatus').val('All').trigger('change');
        $('#txtRaw').val('General').trigger('change');

        

    });











});


</script>

@endsection
{{-- Content Page JS End--}}
