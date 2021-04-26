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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('OrderAnalysis') }}">Order Analysis</a></li>
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
                            <h4>Order Analysis</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">

                    <div class="form-row mb-6">
                        <div class="form-group col-md-3">
                            <label class="text-dark" for="txtMill">Mill</label>
                            <div id="mill_loading">
                            <select class="form-control basic" name="txtMill" id="txtMill">
                                <option></option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="text-dark" for="brand">Brand</label>
                            <div id="brand_loading">
                            <select class="form-control basic" name="txtBrand" id="txtBrand">
                                <option></option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="text-dark" for="division">Division</label>
                            <div id="div_loading">
                            <select class="form-control basic" name="txtDivision" id="txtDivision">
                                <option></option>
                            </select>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="form-row mb-6">
                        <div class="form-group col-md-10">
                            <label class="text-dark" for="txtCustomer">Customer</label>
                            <select class="form-control basic" name="txtCustomer" id="txtCustomer">
                                <option></option>
                            </select>
                        </div>
                    </div> --}}

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
                            <h4>Order Analysis</h4>
                            <p style="padding: 0px 15px; font-size: 11px; font-style: italic;">K: thousand, M: million, B: billion</p>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">

                    <div id="chartContainer1" style="height: 370px; width: 100%;"></div>

                </div>
            </div>
        </div>

        <div class="col-lg-4 layout-spacing layout-spacing" id="result4" style="display: none">
            <div class="statbox widget box box-shadow chartContainer4">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4 id="TitleDetail3"></h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div id="chartContainer4" style="height: 370px; width: 100%;"></div>

                </div>
            </div>
        </div>

        <div class="col-lg-4 layout-spacing layout-spacing" id="result2" style="display: none">
            <div class="statbox widget box box-shadow chartContainer2">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4 id="TitleDetail1"></h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div id="chartContainer2" style="height: 370px; width: 100%;"></div>

                </div>
            </div>
        </div>
        
        <div class="col-lg-4 layout-spacing layout-spacing" id="result3" style="display: none">
            <div class="statbox widget box box-shadow chartContainer3">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4 id="TitleDetail2"></h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div id="chartContainer3" style="height: 370px; width: 100%;"></div>

                </div>
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

var x = window.matchMedia("(max-width: 991px)")
var title1, label1, dp1, dp2, dp3, container1;
var title_pie, label_pie, dp_pie, container_pie;
var txtMill, txtBrand, txtDivision, txtCustomer, txtStartDate, txtEndDate;
label1 = "-";

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

function blockContainer(block){
    
    $(block).block({ 
        message: 'Please Wait...',
        overlayCSS: {
            backgroundColor: '#000',
            opacity: 0.6,
            cursor: 'wait'
        },
        css: {
            border: 0,
            color: '#fff',
            padding: 0,
            backgroundColor: 'transparent'
        }
    });
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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

function listDivision(){
    var block = $('#div_loading');
    blockElement(block);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('listDivisionOrder')}}",
        success: function (data) {
            $(block).unblock()
            $('select[name="txtDivision"]').empty();
            $('select[name="txtDivision"]').prepend('<option></option>');
            $.each(data, function(index, element) {
            $('select[name="txtDivision"]').append('<option value="'+element.class+'">'+element.descr+'</option>');
            });
        }
    });

    $('#txtDivision').select2({
        placeholder: 'Choose Division below',
        allowClear: true
    });

}

function listBrand(){
    
    var block = $('#brand_loading');
    blockElement(block);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('listBrand')}}",
        success: function (data) {
            $(block).unblock()
            $('select[name="txtBrand"]').empty();
            $('select[name="txtBrand"]').prepend('<option></option>');
            $.each(data, function(index, element) {
            $('select[name="txtBrand"]').append('<option value="'+element.brand_id+'">'+element.brand_id+'</option>');
            });
        }
    });

    $('#txtBrand').select2({
        placeholder: 'Choose Brand below',
        allowClear: true
    });

}

function searchCustomer(){

    $('#txtCustomer').select2({
    placeholder: "Type any existing CustId or CustName . . .",
    allowClear: true,
        minimumInputLength: 3,
        ajax: {
            url: "{{url('listAllCustomer')}}",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
            return {
                results:  $.map(data, function (item) {
                return {
                    text: item.CustomerID + " || " + item.NamaCustomer,
                    id: item.CustomerID,
                }
                })
            };

            },
            cache: false
        }
    });
}

function getChart1(title1, label1, dp1, dp2, dp3, container1){
    var chart1 = new CanvasJS.Chart(container1, {
	    animationEnabled: true,
        exportEnabled: true,
        theme: "light2",
        title: {
            text: title1,
            fontFamily: "Calibri",
            fontSize: 20
        },
        subtitles:[
            {
                text: label1,
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
            title: "Weight in Ton",
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
                click: onClick1,
                name: "Order Summary",
                showInLegend: true,
                indexLabel: "{y}",
                indexLabelPlacement: "inside",
                indexLabelOrientation: "vertical",
                indexLabelFontColor: "#fff",
                // indexLabelFontWeight: "bold",
                indexLabelFontSize: 12,
                indexLabelFontFamily: "calibri",
                color: "#00b7c2", //ijo
                // yValueFormatString: "#,###,,,.##"
            },
            {
                type: "column",
                click: onClick2,
                name: "Production Summary",
                showInLegend: true,
                indexLabel: "{y}",
                indexLabelPlacement: "inside",
                indexLabelOrientation: "vertical",
                indexLabelFontColor: "#fff",
                // indexLabelFontWeight: "bold",
                indexLabelFontSize: 12,
                indexLabelFontFamily: "calibri",
                color: "#ee6f57", //oranye
                // yValueFormatString: "#,###,,,.##"
            },
            {
                type: "column",
                click: onClick3,
                name: "Shipment Summary",
                showInLegend: true,
                indexLabel: "{y}",
                indexLabelPlacement: "inside",
                indexLabelOrientation: "vertical",
                indexLabelFontColor: "#fff",
                // indexLabelFontWeight: "bold",
                indexLabelFontSize: 12,
                indexLabelFontFamily: "calibri",
                color: "#132743", //biru dongker
                // yValueFormatString: "#,###,,,.##"
            },
        ]
    });
    chart1.options.data[0].dataPoints = dp1;
    chart1.options.data[1].dataPoints = dp2;
    chart1.options.data[2].dataPoints = dp3;
    // showDefaultText(chart1, "No Data Found!");

    if (x.matches) {

        for(var i = 0; i < chart1.options.data.length; i++){
            chart1.options.data[i].indexLabelFontSize = 8;
        }
        chart1.render();
    }
    chart1.render();
}

function getPieChart(title_pie, label_pie, dp_pie, container_pie){
    var pie_chart = new CanvasJS.Chart(container_pie, {
	    animationEnabled: true,
        title: {
            text: title_pie,
            fontFamily: "Calibri",
            fontSize: 20
        },
        subtitles:[
            {
                text: label_pie,
                fontFamily: "Calibri",
                fontColor: "red",
                fontSize: 12
            }
        ],
        exportEnabled: true,
        theme: "light2",
        exportEnabled: true,
		// legend: {
		// 	itemclick: toggleDataPointVisibility
		// },
        data: [{

            type: "pie",
            percentFormatString: "#0.##",
            indexLabel: "{label} #percent%",
            indexLabelFontSize: 12,
			// showInLegend: true

        }]
    });
    pie_chart.options.data[0].dataPoints = dp_pie;
    showDefaultText(pie_chart, "No Data Found!");

    if (x.matches) {

        for(var i = 0; i < pie_chart.options.data.length; i++){
            pie_chart.options.data[i].indexLabelFontSize = 8;
        }
        pie_chart.render();
    }
    pie_chart.render();
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

function toggleDataPointVisibility(e) {
	if(e.dataPoint.hasOwnProperty("actualYValue") && e.dataPoint.actualYValue !== null) {
    e.dataPoint.y = e.dataPoint.actualYValue;
    e.dataPoint.actualYValue = null;
    e.dataPoint.indexLabelFontSize = null;
    e.dataPoint.indexLabelLineThickness = null;
    e.dataPoint.legendMarkerType = "circle";
  } 
  else {
    e.dataPoint.actualYValue = e.dataPoint.y;
    e.dataPoint.y = 0;
    e.dataPoint.indexLabelFontSize = 0;
    e.dataPoint.indexLabelLineThickness = 0; 
    e.dataPoint.legendMarkerType = "cross";
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

function onClick1(e){

    var txtPeriode = e.dataPoint.label;

    var block2 = $('.chartContainer2');
    var block3 = $('.chartContainer3');
    var block4 = $('.chartContainer4');

    blockContainer(block2);
    blockContainer(block3);
    blockContainer(block4);

    result2.style.display="block";
    result3.style.display="block";
    result4.style.display="block";

    $('html, body').animate({
        scrollTop: $("#result3").offset().top
    }, 1200);


    $.ajax({
        type: "POST",
        url: "{{ url('chartOrderAnalysisByBrand') }}",
        data: {
            '_token': '{{ csrf_token() }}',
            'txtMill': txtMill,
            'txtBrand': txtBrand,
            'txtDivision': txtDivision,
            'txtCustomer': txtCustomer,
            'txtStartDate': txtStartDate,
            'txtEndDate': txtEndDate,
            'txtPeriode': txtPeriode
        },
        success: function(data) {

            if (data.length > 0) {

                dp_pie = [];
                for (var i = 0; i < data.length; i++) {
                    dp_pie.push({  label: data[i].brand_id,  y: Math.round(data[i].wgt_order * 10) / 10 });
                }

                label_pie = label1;
                title_pie = 'Date Period '+txtPeriode;
                container_pie = 'chartContainer4';
                getPieChart(title_pie, label_pie, dp_pie, container_pie)
                block4.unblock();

            }

            else{

                swal("Order Analysis by Brand", "Data not available",  "error");
                dp_pie = [];
                dp_pie.push({ y: 0 });
                label_pie = label1;
                title_pie = 'Date Period '+txtPeriode;
                container_pie = 'chartContainer4';
                getPieChart(title_pie, label_pie, dp_pie, container_pie)
                block4.unblock();
            }
        }
    });


    $.ajax({
        type: "POST",
        url: "{{ url('chartOrderAnalysisByClass') }}",
        data: {
            '_token': '{{ csrf_token() }}',
            'txtMill': txtMill,
            'txtBrand': txtBrand,
            'txtDivision': txtDivision,
            // 'txtCustomer': txtCustomer,
            'txtStartDate': txtStartDate,
            'txtEndDate': txtEndDate,
            'txtPeriode': txtPeriode
        },
        success: function(data) {

            if (data.length > 0) {

                dp_pie = [];
                for (var i = 0; i < data.length; i++) {
                    dp_pie.push({  label: data[i].descr,  y: Math.round(data[i].wgt_order * 10) / 10 });
                }

                label_pie = label1;
                title_pie = 'Date Period '+txtPeriode;
                container_pie = 'chartContainer2';
                getPieChart(title_pie, label_pie, dp_pie, container_pie)
                block2.unblock();

            }

            else{

                swal("Order Analysis by Class", "Data not available",  "error");
                dp_pie = [];
                dp_pie.push({ y: 0 });
                label_pie = label1;
                title_pie = 'Date Period '+txtPeriode;
                container_pie = 'chartContainer2';
                getPieChart(title_pie, label_pie, dp_pie, container_pie)
                block2.unblock();
            }
        }
    });

    $.ajax({
        type: "POST",
        url: "{{ url('chartOrderAnalysisByCust') }}",
        data: {
            '_token': '{{ csrf_token() }}',
            'txtMill': txtMill,
            'txtBrand': txtBrand,
            'txtDivision': txtDivision,
            'txtCustomer': txtCustomer,
            'txtStartDate': txtStartDate,
            'txtEndDate': txtEndDate,
            'txtPeriode': txtPeriode
        },
        success: function(data) {

            if (data.length > 0) {

                dp_pie = [];
                for (var i = 0; i < data.length; i++) {
                    dp_pie.push({  label: data[i].NamaCustomer,  y: Math.round(data[i].wgt_order * 10) / 10 });
                }

                label_pie = label1;
                title_pie = 'Date Period '+txtPeriode;
                container_pie = 'chartContainer3';
                getPieChart(title_pie, label_pie, dp_pie, container_pie)
                block3.unblock();

            }

            else{

                swal("Order Analysis by Cust", "Data not available",  "error");
                dp_pie = [];
                dp_pie.push({ y: 0 });
                label_pie = label1;
                title_pie = 'Date Period '+txtPeriode;
                container_pie = 'chartContainer3';
                getPieChart(title_pie, label_pie, dp_pie, container_pie)
                block3.unblock();
            }
        }
    });

    var html1 = 'Order Analysis by Class/Division';
    var html2 = 'Order Analysis by Customer';
    var html3 = 'Order Analysis by Brand';

    $('#TitleDetail1').text(html1);
    $('#TitleDetail2').text(html2);
    $('#TitleDetail3').text(html3);

}

function onClick2(e){

    var txtPeriode = e.dataPoint.label;

    var block2 = $('.chartContainer2');
    var block3 = $('.chartContainer3');
    var block4 = $('.chartContainer4');

    blockContainer(block2);
    blockContainer(block3);
    blockContainer(block4);

    result2.style.display="block";
    result3.style.display="block";
    result4.style.display="block";

    $('html, body').animate({
        scrollTop: $("#result3").offset().top
    }, 1200);


    $.ajax({
        type: "POST",
        url: "{{ url('chartProdAnalysisByBrand') }}",
        data: {
            '_token': '{{ csrf_token() }}',
            'txtMill': txtMill,
            'txtBrand': txtBrand,
            'txtDivision': txtDivision,
            'txtCustomer': txtCustomer,
            'txtStartDate': txtStartDate,
            'txtEndDate': txtEndDate,
            'txtPeriode': txtPeriode
        },
        success: function(data) {

            if (data.length > 0) {

                dp_pie = [];
                for (var i = 0; i < data.length; i++) {
                    dp_pie.push({  label: data[i].brand_id,  y: Math.round(data[i].wgt_prod * 10) / 10 });
                }

                label_pie = label1;
                title_pie = 'Date Period '+txtPeriode;
                container_pie = 'chartContainer4';
                getPieChart(title_pie, label_pie, dp_pie, container_pie)
                block4.unblock();

            }

            else{

                swal("Production Analysis by Brand", "Data not available",  "error");
                dp_pie = [];
                dp_pie.push({ y: 0 });
                label_pie = label1;
                title_pie = 'Date Period '+txtPeriode;
                container_pie = 'chartContainer4';
                getPieChart(title_pie, label_pie, dp_pie, container_pie)
                block4.unblock();
            }
        }
    });


    $.ajax({
        type: "POST",
        url: "{{ url('chartProdAnalysisByClass') }}",
        data: {
            '_token': '{{ csrf_token() }}',
            'txtMill': txtMill,
            'txtDivision': txtDivision,
            // 'txtCustomer': txtCustomer,
            'txtStartDate': txtStartDate,
            'txtEndDate': txtEndDate,
            'txtPeriode': txtPeriode
        },
        success: function(data) {

            if (data.length > 0) {

                dp_pie = [];
                for (var i = 0; i < data.length; i++) {
                    dp_pie.push({  label: data[i].descr,  y: Math.round(data[i].wgt_prod * 10) / 10 });
                }

                label_pie = label1;
                title_pie = 'Date Period '+txtPeriode;
                container_pie = 'chartContainer2';
                getPieChart(title_pie, label_pie, dp_pie, container_pie)
                block2.unblock();

            }

            else{

                swal("Production Analysis by Class", "Data not available",  "error");
                dp_pie = [];
                dp_pie.push({ y: 0 });
                label_pie = label1;
                title_pie = 'Date Period '+txtPeriode;
                container_pie = 'chartContainer2';
                getPieChart(title_pie, label_pie, dp_pie, container_pie)
                block2.unblock();
            }
        }
    });

    $.ajax({
        type: "POST",
        url: "{{ url('chartProdAnalysisByCust') }}",
        data: {
            '_token': '{{ csrf_token() }}',
            'txtMill': txtMill,
            'txtDivision': txtDivision,
            // 'txtCustomer': txtCustomer,
            'txtStartDate': txtStartDate,
            'txtEndDate': txtEndDate,
            'txtPeriode': txtPeriode
        },
        success: function(data) {

            if (data.length > 0) {

                dp_pie = [];
                for (var i = 0; i < data.length; i++) {
                    dp_pie.push({  label: data[i].custGroup,  y: Math.round(data[i].wgt_prod * 10) / 10 });
                }

                label_pie = label1;
                title_pie = 'Date Period '+txtPeriode;
                container_pie = 'chartContainer3';
                getPieChart(title_pie, label_pie, dp_pie, container_pie)
                block3.unblock();

            }

            else{

                swal("Production Analysis by CustGroup", "Data not available",  "error");
                dp_pie = [];
                dp_pie.push({ y: 0 });
                label_pie = label1;
                title_pie = 'Date Period '+txtPeriode;
                container_pie = 'chartContainer3';
                getPieChart(title_pie, label_pie, dp_pie, container_pie)
                block3.unblock();
            }
        }
    });

    var html1 = 'Production Analysis by Class/Division';
    var html2 = 'Production Analysis by Customer Group';
    var html3 = 'Production Analysis by Brand';

    $('#TitleDetail1').text(html1);
    $('#TitleDetail2').text(html2);
    $('#TitleDetail3').text(html3);

}

function onClick3(e){

    var txtPeriode = e.dataPoint.label;

    var block2 = $('.chartContainer2');
    var block3 = $('.chartContainer3');
    var block4 = $('.chartContainer4');

    blockContainer(block2);
    blockContainer(block3);
    blockContainer(block4);

    result2.style.display="block";
    result3.style.display="block";
    result4.style.display="block";

    $('html, body').animate({
        scrollTop: $("#result3").offset().top
    }, 1200);


    $.ajax({
        type: "POST",
        url: "{{ url('chartShipAnalysisByBrand') }}",
        data: {
            '_token': '{{ csrf_token() }}',
            'txtMill': txtMill,
            'txtBrand': txtBrand,
            'txtDivision': txtDivision,
            'txtCustomer': txtCustomer,
            'txtStartDate': txtStartDate,
            'txtEndDate': txtEndDate,
            'txtPeriode': txtPeriode
        },
        success: function(data) {

            if (data.length > 0) {

                dp_pie = [];
                for (var i = 0; i < data.length; i++) {
                    dp_pie.push({  label: data[i].brand_id,  y: Math.round(data[i].wgt_ship * 10) / 10 });
                }

                label_pie = label1;
                title_pie = 'Date Period '+txtPeriode;
                container_pie = 'chartContainer4';
                getPieChart(title_pie, label_pie, dp_pie, container_pie)
                block4.unblock();

            }

            else{

                swal("Shipment Analysis by Brand", "Data not available",  "error");
                dp_pie = [];
                dp_pie.push({ y: 0 });
                label_pie = label1;
                title_pie = 'Date Period '+txtPeriode;
                container_pie = 'chartContainer4';
                getPieChart(title_pie, label_pie, dp_pie, container_pie)
                block4.unblock();
            }
        }
    });

    $.ajax({
        type: "POST",
        url: "{{ url('chartShipAnalysisByClass') }}",
        data: {
            '_token': '{{ csrf_token() }}',
            'txtMill': txtMill,
            'txtDivision': txtDivision,
            // 'txtCustomer': txtCustomer,
            'txtStartDate': txtStartDate,
            'txtEndDate': txtEndDate,
            'txtPeriode': txtPeriode
        },
        success: function(data) {

            if (data.length > 0) {

                dp_pie = [];
                for (var i = 0; i < data.length; i++) {
                    dp_pie.push({  label: data[i].descr,  y: Math.round(data[i].wgt_ship * 10) / 10 });
                }

                label_pie = label1;
                title_pie = 'Date Period '+txtPeriode;
                container_pie = 'chartContainer2';
                getPieChart(title_pie, label_pie, dp_pie, container_pie)
                block2.unblock();

            }

            else{

                swal("Shipment Analysis by Class", "Data not available",  "error");
                dp_pie = [];
                dp_pie.push({ y: 0 });
                label_pie = label1;
                title_pie = 'Date Period '+txtPeriode;
                container_pie = 'chartContainer2';
                getPieChart(title_pie, label_pie, dp_pie, container_pie)
                block2.unblock();
            }
        }
    });

    $.ajax({
        type: "POST",
        url: "{{ url('chartShipAnalysisByCust') }}",
        data: {
            '_token': '{{ csrf_token() }}',
            'txtMill': txtMill,
            'txtDivision': txtDivision,
            // 'txtCustomer': txtCustomer,
            'txtStartDate': txtStartDate,
            'txtEndDate': txtEndDate,
            'txtPeriode': txtPeriode
        },
        success: function(data) {

            if (data.length > 0) {

                dp_pie = [];
                for (var i = 0; i < data.length; i++) {
                    dp_pie.push({  label: data[i].NamaCustomer,  y: Math.round(data[i].wgt_ship * 10) / 10 });
                }

                label_pie = label1;
                title_pie = 'Date Period '+txtPeriode;
                container_pie = 'chartContainer3';
                getPieChart(title_pie, label_pie, dp_pie, container_pie)
                block3.unblock();

            }

            else{

                swal("Shipment Analysis by Customer", "Data not available",  "error");
                dp_pie = [];
                dp_pie.push({ y: 0 });
                label_pie = label1;
                title_pie = 'Date Period '+txtPeriode;
                container_pie = 'chartContainer3';
                getPieChart(title_pie, label_pie, dp_pie, container_pie)
                block3.unblock();
            }
        }
    });

    var html1 = 'Shipment Analysis by Class/Division';
    var html2 = 'Shipment Analysis by Customer';
    var html3 = 'Shipment Analysis by Brand';

    $('#TitleDetail1').text(html1);
    $('#TitleDetail2').text(html2);
    $('#TitleDetail3').text(html3);

}


$(document).ready(function() {

    $('#homeNav').attr('data-active','false');
    $('#homeNav').attr('aria-expanded','false');
    $('#ReportNav').attr('data-active','true');
    $('#ReportNav').attr('aria-expanded','true');
    $('.ReportTreeView').addClass('show');
    $('#OrderAnalysis').addClass('active');

    $('.basic').on('select2:open', function() {
        if (Modernizr.touch) {
            $('.select2-search__field').prop('focus', false);
        }
    });

    listMill(); listDivision(); listBrand();
    // searchCustomer();
  

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


    $('#go').on('click', function() {

        label1 = "-";

        event.preventDefault();
        txtMill = $('#txtMill').val();
        txtBrand = $('#txtBrand').val();
        txtDivision = $('#txtDivision').val();
        txtCustomer = $('#txtCustomer').val();
        txtStartDate = $('#txtStartDate').val();
        txtEndDate = $('#txtEndDate').val();

         if (!txtEndDate) {

            var today = new Date();
            //var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();
            txtEndDate = yyyy+mm;
            //end = yyyy+mm+dd;
        }

        if (!txtStartDate) {
            swal("Whops", "You must choose Start Date first", "error")

        }

        else {

            if (txtMill){
                label1 = 'Mill #'+txtMill;
            }

            if (txtBrand){
                label1 = label1+', Brand #'+txtBrand.trim();
            }

            if (txtDivision){
                label1 = label1+', Div #'+txtDivision.trim();
            }

            if (txtCustomer){
                var e = document.getElementById("txtCustomer");
                var txtCustName = e.options[e.selectedIndex].text;
                label1 = label1+', Cust #'+txtCustName.trim();
            }

            blockUI();

            $.ajax({
                type: "POST",
                url: "{{ url('chartOrderAnalysis') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'txtMill': txtMill,
                    'txtBrand': txtBrand,
                    'txtDivision': txtDivision,
                    'txtCustomer': txtCustomer,
                    'txtStartDate': txtStartDate,
                    'txtEndDate': txtEndDate
                },
                success: function(data) {

                    if (data.length > 0) {


                        dp1 = [];
                        dp2 = [];
                        dp3 = [];
                        for (var i = 0; i < data.length; i++) {
                            dp1.push({  label: data[i].periode,  y: Math.round(data[i].wgt_order * 10) / 10 });
                            dp2.push({  label: data[i].periode,  y: Math.round(data[i].wgt_prod * 10) / 10 });
                            dp3.push({  label: data[i].periode,  y: Math.round(data[i].wgt_ship * 10) / 10 });
                        }
                        title1 = 'Date Period '+data[0].periode+' - '+data[data.length-1].periode;
                        result.style.display="block";
                        result2.style.display="none";
                        result3.style.display="none";
                        result4.style.display="none";
                        $.unblockUI();
                        $('html, body').animate({
                            scrollTop: $("#result").offset().top
                        }, 1200);
                        container1 = 'chartContainer1';
                        getChart1(title1 , label1, dp1, dp2, dp3, container1);

                    }

                    else{

                        $.unblockUI();
                        swal("Order Analysis Chart", "Data not available",  "error");
                        result.style.display="block";
                        result2.style.display="none";
                        result3.style.display="none";
                        result4.style.display="none";
                        $('html, body').animate({
                            scrollTop: $("#result").offset().top
                        }, 1200);
                        dp1 = []; dp2 = []; dp3= [];
                        dp1.push({ y: 0 });
                        dp2.push({ y: 0 });
                        dp3.push({ y: 0 });
                        title1 = 'Date Period N/A';
                        container1 = 'chartContainer1';
                        getChart1(title1 , label1, dp1, dp2, dp3, container1);
                    }
                }
            });

        }

        //alert(txtStartDate);

    
    });


    $('#reset').on('click', function() {

        $('#txtDivision').val(null).trigger('change');
        listMill();
        $('#txtCustomer').val(null).trigger('change');
        f1.clear();
        f2.clear();
        result.style.display="none";
        result2.style.display="none";
        result3.style.display="none";
    
    });
    

});


</script>

@endsection
{{-- Content Page JS End--}}
