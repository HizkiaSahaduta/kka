@extends('main')

{{-- Content Page CSS Begin--}}
@section('contentcss')
<link href="{{ asset('outside/plugins/notification/snackbar/snackbar.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('outside/plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/style.css">
<link href="{{ asset('outside/assets/css/components/tabs-accordian/custom-tabs.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/select2/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.4/css/responsive.dataTables.min.css" />
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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('PerformanceAnalysis') }}">Performance Analysis</a></li>
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
                            <h4>Performance Analysis</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">

                    <div class="form-row mb-6">
                        <div class="form-group col-md-2">
                            <label class="text-dark" for="txtMill">Mill</label>
                            <div id="txtMill_loading">
                            <select class="form-control basic" name="txtMill" id="txtMill">
                                <option></option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="text-dark" for="txtSP">No. SP</label>
                            {{-- <a id="txtSP_badge"><span class="badge badge-danger">N/A</span></a> --}}
                            {{-- <div id="txtSP_loading"> --}}
                            <select class="form-control basic" name="txtSP" id="txtSP">
                                <option></option>
                            </select>
                            {{-- </div> --}}
                        </div>
                        <div class="form-group col-md-4">
                            <label class="text-dark" for="txtItemNum">ItemNum/ItemDescr</label>
                            <a id="txtItemNum_badge"><span class="badge badge-danger">N/A</span></a>
                            <div id="txtItemNum_loading">
                            <select class="form-control basic" name="txtItemNum" id="txtItemNum">
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
                            <h4>Chart Performance Analysis (Monthly Summary)</h4>
                            {{-- <p style="padding: 0px 15px; font-size: 11px; font-style: italic;">K: thousand, M: million, B: billion</p> --}}
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
                            <h4>Chart Performance Analysis (Daily Summary)</h4>
                            {{-- <p style="padding: 0px 15px; font-size: 11px; font-style: italic;">K: thousand, M: million, B: billion</p> --}}
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">

                    <div id="chartContainer2" style="height: 370px; width: 100%;"></div>

                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="detailDaily" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" id="modalLoad">
            <div class="modal-header">
                <div id="modalTitle"></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">

                <div class="table-responsive">
                    <table id="detail" class="table mb-4" style="width:100%">
                        <thead>
                            <tr>
                                <th>Mill</th>
                                <th>DtRcv</th>
                                <th>DtPlan</th>
                                <th>DtProd</th>
                                <th>DtShip</th>
                                <th>No.SP</th>
                                <th>Num</th>
                                <th>Descr</th>
                                <th>Recv to Plan</th>
                                <th>Plan to Prod</th>
                                <th>Prod to Ship</th>
                            </tr>
                        </thead>
                    </table>
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

var txtTanggal, txtPeriode, txtMill, txtSP, txtItemNum, txtStartDate, txtEndDate, dp1, dp2, dp3, container, title, subtitle, x = window.matchMedia("(max-width: 991px)");

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

function listMill(){

    var block = $('#txtMill_loading');
    blockElement(block);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('listMillDowntime')}}",
       success: function (data) {

            count = Object.keys(data).length;

            if (count < 2) { 

                $(block).unblock();
                $('select[name="txtMill"]').empty();
                $('select[name="txtMill"]').prepend('<option></option>');
                $.each(data, function(index, element) {
                $('select[name="txtMill"]').append('<option value="'+element.mill_id+'" selected>'+element.mill_name+'</option>');
                });
                $('#txtMill').prop('disabled', true);

            }

            else {

                $(block).unblock();
                $('select[name="txtMill"]').empty();
                $('select[name="txtMill"]').prepend('<option></option>');
                $.each(data, function(index, element) {
                $('select[name="txtMill"]').append('<option value="'+element.mill_id+'">'+element.mill_name+'</option>');
                });

            }
            
        }
    });

    $('#txtMill').select2({
        placeholder: 'Choose Mill below',
        allowClear: true
    });

}

function searchSP(){

    $('#txtSP').select2({
    placeholder: "Type any existing No.SP ...",
    allowClear: true,
        minimumInputLength: 3,
        ajax: {
            url: "{{url('searchSP')}}",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
            return {
                results:  $.map(data, function (item) {
                return {
                    text: item.CustomerOrderNo,
                    id: item.CustomerOrderNo,
                }
                })
            };

            },
            cache: false
        }
    });
}

function listSP(){
    $('#txtSP').select2({
        placeholder: "Choose Mill first",
    });
}

function listItem(){
    $('#txtItemNum').select2({
        placeholder: "Choose No. SP first",
    });
}

function listItemDescr(txtSP){

    var block = $('#txtItemNum_loading');
    blockElement(block);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('listItemDescr/txtSP=')}}"+txtSP,
        success: function (data) {
            $(block).unblock();
            $('select[name="txtItemNum"]').empty();
            $('select[name="txtItemNum"]').prepend('<option></option>');
            $.each(data, function(index, element) {
            $('select[name="txtItemNum"]').append('<option value="'+element.item_num+'">'+element.item_num+' | '+element.NamaBarang+'</option>');
            });
        }
    });

    $('#txtItemNum').select2({
        placeholder: 'Choose Item below',
        allowClear: true
    });
   
}

function listSPMill(txtMill){

    var block = $('#txtSP_loading');
    blockElement(block);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('listSP/txtMill=')}}"+txtMill,
        success: function (data) {
            $(block).unblock();
            $('select[name="txtSP"]').empty();
            $('select[name="txtSP"]').prepend('<option></option>');
            $.each(data, function(index, element) {
            $('select[name="txtSP"]').append('<option value="'+element.CustomerOrderNo+'">'+element.CustomerOrderNo+'</option>');
            });
        }
    });

    $('#txtSP').select2({
        placeholder: 'Choose No. SP below',
        allowClear: true
    });

}

function getChart1(dp1, dp2, dp3, container, title, subtitle){
    chart1 = new CanvasJS.Chart(container, {
        colorSet: "colorSet2",
        animationEnabled: true,
        theme: "light2",
        title: {
            text: title,
            fontFamily: "Calibri",
            fontSize: 20
        },
        exportEnabled: true,
        subtitles:[
            {
                text: subtitle,
                fontFamily: "Calibri",
                fontColor: "red",
                fontSize: 12
            }
        ],
        exportEnabled: true,
        axisY: {
            crosshair: {
			    enabled: true,
                snapToDataPoint: true
		    },
            title: "Day Interval"
        },
        toolTip:{
		    shared:true
	    },
        legend: {
            fontSize: 11,
            itemMaxWidth: 150,
			itemWrap: true ,
            cursor: "pointer",
            itemclick: toggleDataSeries
	    },
        data: [
            {
                type: "column",
                click: onClick,
                showInLegend: true,
                name: "RCV -> PLAN",
                indexLabel: "{y}",
                // indexLabelPlacement: "inside",
                // indexLabelOrientation: "vertical",
                indexLabelFontSize: 12,
                indexLabelFontFamily: "calibri",
                // indexLabelFontColor: "#fff",
                // color: "#325288"
            },
            {
                type: "column",
                click: onClick,
                showInLegend: true,
                name: "PLAN->PROD",
                indexLabel: "{y}",
                // indexLabelPlacement: "inside",
                // indexLabelOrientation: "vertical",
                indexLabelFontSize: 12,
                indexLabelFontFamily: "calibri",
                // indexLabelFontColor: "#fff",
                // color: "#5b6d5b"
            },
            {
                type: "column",
                click: onClick,
                showInLegend: true,
                name: "PROD->SHIP",
                indexLabel: "{y}",
                // indexLabelPlacement: "inside",
                // indexLabelOrientation: "vertical",
                indexLabelFontSize: 12,
                indexLabelFontFamily: "calibri",
                // indexLabelFontColor: "#fff",
                // color: "#a35709"
            }
        ]
    });
    chart1.options.data[0].dataPoints = dp1;
    chart1.options.data[1].dataPoints = dp2;
    chart1.options.data[2].dataPoints = dp3;

    if (x.matches) {

        for(var i = 0; i < chart1.options.data.length; i++){
            chart1.options.data[i].indexLabelFontSize = 6;
        }
        chart1.render();
    }

    chart1.render();

}

function getChart2(dp1, dp2, dp3, container, title, subtitle){
    chart1 = new CanvasJS.Chart(container, {
        colorSet: "colorSet2",
        animationEnabled: true,
        theme: "light2",
        title: {
            text: title,
            fontFamily: "Calibri",
            fontSize: 20
        },
        exportEnabled: true,
        subtitles:[
            {
                text: subtitle,
                fontFamily: "Calibri",
                fontColor: "red",
                fontSize: 12
            }
        ],
        exportEnabled: true,
        axisY: {
            crosshair: {
			    enabled: true,
                snapToDataPoint: true
		    },
            title: "Day Interval"
        },
        toolTip:{
		    shared:true
	    },
        legend: {
            fontSize: 11,
            itemMaxWidth: 150,
			itemWrap: true ,
            cursor: "pointer",
            itemclick: toggleDataSeries
	    },
        data: [
            {
                type: "column",
                click: onClick2,
                showInLegend: true,
                name: "RCV -> PLAN",
                indexLabel: "{y}",
                // indexLabelPlacement: "inside",
                // indexLabelOrientation: "vertical",
                indexLabelFontSize: 12,
                indexLabelFontFamily: "calibri",
                // indexLabelFontColor: "#fff",
                // color: "#325288"
            },
            {
                type: "column",
                click: onClick2,
                showInLegend: true,
                name: "PLAN->PROD",
                indexLabel: "{y}",
                // indexLabelPlacement: "inside",
                // indexLabelOrientation: "vertical",
                indexLabelFontSize: 12,
                indexLabelFontFamily: "calibri",
                // indexLabelFontColor: "#fff",
                // color: "#5b6d5b"
            },
            {
                type: "column",
                click: onClick2,
                showInLegend: true,
                name: "PROD->SHIP",
                indexLabel: "{y}",
                // indexLabelPlacement: "inside",
                // indexLabelOrientation: "vertical",
                indexLabelFontSize: 12,
                indexLabelFontFamily: "calibri",
                // indexLabelFontColor: "#fff",
                // color: "#a35709"
            }
        ]
    });
    chart1.options.data[0].dataPoints = dp1;
    chart1.options.data[1].dataPoints = dp2;
    chart1.options.data[2].dataPoints = dp3;

    if (x.matches) {

        for(var i = 0; i < chart1.options.data.length; i++){
            chart1.options.data[i].indexLabelFontSize = 6;
        }
        chart1.render();
    }

    chart1.render();

}

function onClick(e){

    blockUI();

    txtPeriode = e.dataPoint.label;

    $.ajax({
        type: "POST",
        url: "{{ url('chartPerformanceAnalysisDailySum') }}",
        data: {
            '_token': '{{ csrf_token() }}',
            'txtMill' : txtMill,
            'txtSP' : txtSP,
            'txtItemNum' : txtItemNum,
            'txtPeriode': txtPeriode
        },
        success: function(data) {

            if (data['result'].length > 0) {

                dp1 =  []; dp2 =  []; dp3 =  [];

                for (var i = 0; i < data['result'].length; i++) {

                    dp1.push({  label: data['result'][i].dt_rcv,  y: parseFloat(data['result'][i].xx) });
                    dp2.push({  label: data['result'][i].dt_rcv,  y: parseFloat(data['result'][i].yy) });
                    dp3.push({  label: data['result'][i].dt_rcv,  y: parseFloat(data['result'][i].zz) });

                }
                title = 'Daily Summary from '+txtPeriode;
                container  = "chartContainer2"; 
                if (txtMill) {

                    subtitle = 'Mill:'+txtMill.trim();
                }
                if (!txtMill)
                {
                    subtitle = subtitle+'Mill:'+data['mill'].trim();
                }

                $.unblockUI();
                result2.style.display="block";
                $('html, body').animate({
                    scrollTop: $("#result2").offset().top
                }, 1200);
                // alert(container);
                getChart2(dp1, dp2, dp3, container, title, subtitle)
                
            
        
            }
            else {

                dp1 =  []; dp2 =  []; dp3 =  [];
                title = 'Daily Summary from '+txtPeriode;
                container  = "chartContainer2"; 
                if (txtMill) {

                    subtitle = 'Mill:'+txtMill.trim();
                }
                if (!txtMill)
                {
                    subtitle = subtitle+'Mill:'+data['mill'].trim();
                }

                $.unblockUI();
                result2.style.display="block";
                $('html, body').animate({
                    scrollTop: $("#result2").offset().top
                }, 1200);
                getChart2(dp1, dp2, dp3, container, title, subtitle)
            
            }

           
        }
    });

}

function onClick2(e){

    $("#detailDaily").modal();
    var block = $('#modalLoad');
    blockModal(block);

    txtTanggal = e.dataPoint.label;

    var dataTable = $('#detail').DataTable({
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
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
                'headers': {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            'url':'{!!url("detailPerformanceAnalysisDaily")!!}',
            'type': 'post',
            data: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'txtMill' : txtMill,
                'txtSP' : txtSP,
                'txtItemNum' : txtItemNum,
                'txtTanggal': txtTanggal
            }
        },
        columns: [
            {data: 'mill_id', name: 'mill_id'},
            {data: 'dt_rcv', name: 'dt_rcv'},
            {data: 'dtPlan', name: 'dtPlan'},
            {data: 'dtProd', name: 'dtProd'},
            {data: 'dtShip', name: 'dtShip'},
            {data: 'CustomerOrderNo', name: 'CustomerOrderNo'},
            {data: 'item_num', name: 'item_num'},
            {data: 'NamaBarang', name: 'NamaBarang'},
            {data: 'x', name: 'x'},
            {data: 'y', name: 'y'},
            {data: 'z', name: 'z'}
        ],
        initComplete: function(settings, json) {

            if (!dataTable.rows().data().length) {

                $(block).unblock();
                swal("Whops", "Data not available", "error");
            }
            else {

                $(block).unblock();
                $("#modalTitle").html('<h4 class="modal-title">Detail from '+txtTanggal+'</h4>')

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
    $('#PerformanceAnalysis').addClass('active');

    var result = document.getElementById("result");
    var result2 = document.getElementById("result2");

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

    listMill(); listItem(); 
    searchSP();

    $('#txtSP').change(function(){
        
        txtSP =  $('#txtSP').val();
        $('select[name="txtItemNum"]').empty();

        if (txtSP) {

            $('#txtItemNum_badge').empty();
            html = "<span class='badge badge-success'>"+txtSP+"</span>";
            $('#txtItemNum_badge').empty();
            $('#txtItemNum_badge').append(html);
            listItemDescr(txtSP);

        }

        else {
           
            $('#txtItemNum_badge').empty();
            html = "<span class='badge badge-danger'>N/A</span>";
            $('#txtItemNum_badge').empty();
            $('#txtItemNum_badge').append(html);
            listItem()


        }

    });  

    $('#go').on('click', function() {

        txtMill =  $('#txtMill').val();
        txtSP = $('#txtSP').val();
        txtItemNum = $('#txtItemNum').val();
        txtStartDate = $('#txtStartDate').val();
        txtEndDate = $('#txtEndDate').val();
        subtitle = '';
        title = '';

        if (!txtMill && !txtSP) {
            swal("Error", "Please choose Mill or No.SP first", "error")
        }
        
        if (txtMill || txtSP)
        {

            if (txtStartDate && txtEndDate) {

                title = 'Periode '+txtStartDate+'-'+txtEndDate;
            }

            if (!txtStartDate && txtEndDate) {

                title = 'Periode <= '+txtEndDate;
            }

            if (txtStartDate && !txtEndDate) {

                title = 'Periode >= '+txtStartDate;
            }  

            if (txtSP) {

                subtitle = subtitle+'No.SP:'+txtSP+', '.trim();
            }

            if (txtItemNum) {

                subtitle = subtitle+'ItemNum:'+txtItemNum+', '.trim();
            }


            blockUI();

            $.ajax({
                type: "POST",
                url: "{{ url('chartPerformanceAnalysis') }}",
                // async: false,
                data: {
                    '_token': '{{ csrf_token() }}',
                    'txtMill' : txtMill,
                    'txtSP' : txtSP,
                    'txtItemNum' : txtItemNum,
                    'txtStartDate' : txtStartDate,
                    'txtEndDate' : txtEndDate
                    
                },
                success: function(data) {

                    // console.log(data['mill'])
                    
                    if (data['result'].length > 0) {

                        dp1 =  []; dp2 =  []; dp3 =  [];

                        for (var i = 0; i < data['result'].length; i++) {

                            dp1.push({  label: data['result'][i].Periode,  y: parseFloat(data['result'][i].xx) });
                            dp2.push({  label: data['result'][i].Periode,  y: parseFloat(data['result'][i].yy) });
                            dp3.push({  label: data['result'][i].Periode,  y: parseFloat(data['result'][i].zz) });

                        }
                        container  = "chartContainer1"; 
                        if (txtMill) {

                            subtitle = 'Mill:'+txtMill.trim();
                        }
                        if (!txtMill)
                        {
                            subtitle = subtitle+'Mill:'+data['mill'].trim();
                        }
                        if (!txtStartDate && !txtEndDate) {

                            title = 'Periode: '+data['periode'];
                        }
                        result.style.display = 'block';
                        getChart1(dp1, dp2, dp3, container, title, subtitle)
                        $.unblockUI();
                       
                
                    }
                    else {

                        dp1 =  []; dp2 =  []; dp3 =  [];
                        container  = "chartContainer1"; 
                        if (!txtStartDate && !txtEndDate) {

                            title = 'Periode: '+data['periode'];
                        }
                        if (txtMill) {

                            subtitle = 'Mill:'+txtMill.trim();
                        }
                        if (!txtMill)
                        {
                            subtitle = subtitle+'Mill:'+data['mill'].trim();
                        }
                        result.style.display = 'block';
                        getChart1(dp1, dp2, dp3, container, title, subtitle)
                        $.unblockUI();
                       
                    }

                    
                }
            });

        }

        
    
    
    
    });

    $('#reset').on('click', function() {

        listMill();
        $('#txtSP').val(null).trigger('change');
        $('#txtItemNum').val(null).trigger('change');
        f1.clear();
        f2.clear();
        result1.style.display="none";
        result2.style.display="none";

    });











});


</script>

@endsection
{{-- Content Page JS End--}}
