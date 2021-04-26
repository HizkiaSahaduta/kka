@extends('main')

{{-- Content Page CSS Begin--}}
@section('contentcss')
<link href="{{ asset('outside/assets/css/elements/infobox.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('outside/plugins/notification/snackbar/snackbar.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('outside/assets/css/components/custom-modal.css') }}" rel="stylesheet" type="text/css" />
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
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('home') }}">Dashboard</a></li>
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


        
        @if(Session::get('GROUPID') == 'SALES')
        <div class="col-lg-12 col-md-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Welcome
                                {{ Session::get('NAME1') }}
                                {{ Session::get('NAME2') }}
                                {{ Session::get('NAME3') }}
                                {{-- @if(session()->has('MILLID'))
                                    {{ Session::get('MILLID') }}
                                @endif --}}
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">
                    <div class="widget-one">
                        <div class="infobox-3" style="margin-left: 0px">
                            <div class="info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                            </div>
                            <h5 class="info-heading">KKA Web Dashboard</h5>
                            <p class="info-text">Here we are, providing anything you want :)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        @if(Session::get('GROUPID') != 'SALES')
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing" id="result1">
            <div class="statbox widget box box-shadow" id="block1">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Production Performa</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">

                    <div id="chartContainer1" style="height: 400px; width: 100%;"></div>

                </div>
            </div>
        </div>


        <div class="col-lg-6 layout-spacing layout-spacing" id="result2" style="display: none">
            <div class="statbox widget box box-shadow" id="block2">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4 class="m-0">Production Performance in <b>{{ $curr_monthName.", ".$year }}</b> </h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div id="chartContainer4" style="height: 370px; width: 100%;"></div>

                </div>
            </div>
        </div>
        
        <div class="col-lg-6 layout-spacing layout-spacing" id="result3" style="display: none">
            <div class="statbox widget box box-shadow" id="block3">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4 class="m-0">Production Performance in <b> 
                            @if($prev_month = 12)
                                {{ $prev_monthName.", ".$prev_year }} </b> </h4>
                            @else
                                {{ $prev_monthName.", ".$year }} </b> </h4>
                            @endif
                            
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div id="chartContainer5" style="height: 370px; width: 100%;"></div>

                </div>
            </div>
        </div>
        @endif



    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="chartCustGroup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" id="modalLoad">
            <div class="modal-header">
                <h4 class="modal-title">Production Performa by Cust.Group (Monthly)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">

                <div id="chartContainer3" style="height: 400px; width: 100%;"></div>

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
<script src="{{ asset('outside/plugins/blockui/jquery.blockUI.min.js') }}"></script>
<script src="{{ asset('canvasjs.min.js') }}"></script>

@if(\Session::has('success'))
    <script>
        var success = "{{ Session::get('success') }}"
        Snackbar.show({
            text: success,
            pos: 'top-center'
        });

    </script>
@endif
<script type="text/javascript">

var x = window.matchMedia("(max-width: 991px)")
var curr_year = {{$year}};
var prev_year = {{$prev_year}}
var curr_month = {{$curr_month}};
var prev_month = {{$prev_month}}
var subtittle;
var dt3;
var dt_val;
var dt4, dt5, container;


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

function getChart1(dt1_prev_year, dt1_curr_year, subtittle){
    chart1 = new CanvasJS.Chart("chartContainer1", {
        animationEnabled: true,
        theme: "light2",
        title: {
            text: subtittle,
            fontFamily: "Calibri",
            fontSize: 20
        },
        exportEnabled: true,
        axisY: {
            crosshair: {
			    enabled: true,
                snapToDataPoint: true
		    },
            title: "Tons",
            labelFormatter: addSymbols,
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
                click: onClick1,
                showInLegend: true,
                name: "Sum.Result ("+prev_year+")",
                indexLabel: "{y}",
                indexLabelPlacement: "inside",
                indexLabelOrientation: "vertical",
                indexLabelFontSize: 12,
                indexLabelFontFamily: "calibri",
                indexLabelFontColor: "#fff",
                color: "#0e9aa7"
            },
            {
                type: "column",
                click: onClick2,
                showInLegend: true,
                name: "Sum.Result ("+curr_year+")",
                indexLabel: "{y}",
                indexLabelPlacement: "inside",
                indexLabelOrientation: "vertical",
                indexLabelFontSize: 12,
                indexLabelFontFamily: "calibri",
                indexLabelFontColor: "#fff",
                color: "#c70039"
            }
        ]
    });
    chart1.options.data[0].dataPoints = dt1_prev_year;
    chart1.options.data[1].dataPoints = dt1_curr_year;

    if (x.matches) {

        for(var i = 0; i < chart1.options.data.length; i++){
            chart1.options.data[i].indexLabelFontSize = 6;
        }
        chart1.render();
    }

    chart1.render();

}

function getChart3(dt3, subtittle, year, min, max){
    chart3 = new CanvasJS.Chart("chartContainer3", {
        animationEnabled: true,
        theme: "light2",
        title: {
            text: subtittle,
            fontFamily: "Calibri",
            fontSize: 20
        },
        exportEnabled: true,
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
            title: "Tons",
            labelFormatter: addSymbols,
        },
        toolTip:{
			content: "{label}: {y}"
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
                indexLabel: "{y}",
                indexLabelPlacement: "outside",
                indexLabelOrientation: "horizontal",
                indexLabelFontSize: 14,
                indexLabelFontFamily: "calibri",
                indexLabelFontWeight: "bold"
            }
        ]
    });
    chart3.options.data[0].dataPoints = dt3;

    if (x.matches) {

        for(var i = 0; i < chart3.options.data.length; i++){
            chart3.options.data[i].indexLabelFontSize = 8;
        }
        chart3.render();
    }


    chart3.render();
}

function getPieChart(dt, container){
    var pie_chart = new CanvasJS.Chart(container, {
	    animationEnabled: true,
        exportEnabled: true,
        theme: "light2",
        exportEnabled: true,
		legend: {
			itemclick: toggleDataPointVisibility
		},
        data: [{

            type: "pie",
            percentFormatString: "#0.##",
            indexLabel: "{label} {y} #percent%",
            indexLabelFontSize: 12,
			showInLegend: true

        }]
    });
    pie_chart.options.data[0].dataPoints = dt;
    showDefaultText(pie_chart, "No Data Found!");

    if (x.matches) {

        for(var i = 0; i < pie_chart.options.data.length; i++){
            pie_chart.options.data[i].indexLabelFontSize = 6;
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
    chart.options.data[0].showInLegend = true;
  }
}

function onClick1(e){

    $("#chartCustGroup").modal();
    blockModal(block);
    var param = e.dataPoint.x + 1;
    var label = e.dataPoint.label;

    $.ajax({
        type: "POST",
        url: "{{ url('ProduksiSumCustGroup') }}",
        data: {
            '_token': '{{ csrf_token() }}',
            'year': prev_year,
            'month': param

        },
        success: function(data) {

            if (data.length > 0) {

                dt3  = [];
                dt3_val = [];

                for (var i = 0; i < data.length; i++) {

                    if ( data[i].custGroup == 'KBT'){

                        dt3.push({ label: data[i].custGroup, y: parseFloat(data[i].wgt_prod), color: "#52575d" });

                    }

                    if ( data[i].custGroup == 'KMB'){

                        dt3.push({ label: data[i].custGroup, y: parseFloat(data[i].wgt_prod), color: "#0f3460" });

                    }

                    if ( data[i].custGroup == 'OTHER'){

                        dt3.push({ label: data[i].custGroup, y: parseFloat(data[i].wgt_prod), color: "#91d18b" });

                    }

                    if ( data[i].custGroup == 'MMM'){

                        dt3.push({ label: data[i].custGroup, y: parseFloat(data[i].wgt_prod), color: "#6f4a8e" });

                    }


                    if ( data[i].custGroup == 'STOCK KENCANA'){

                        dt3.push({ label: data[i].custGroup, y: parseFloat(data[i].wgt_prod), color: "#cf1b1b" });

                    }

                    if ( data[i].custGroup == 'STOCK VIVO' ){

                        dt3.push({ label: data[i].custGroup, y: parseFloat(data[i].wgt_prod), color: "#f6efa6" });

                    }

                    if ( data[i].custGroup == 'VIVO'){

                        dt3.push({ label: data[i].custGroup, y: parseFloat(data[i].wgt_prod), color: "#f6ab6c" });

                    }

                    dt3_val.push( data[i].wgt_prod );

                }


                $(block).unblock();

                subtittle = label+' '+prev_year;

                var year = prev_year;

                Array.prototype.max = function() {
                return Math.max.apply(null, this);
                };

                Array.prototype.min = function() {
                return Math.min.apply(null, this);
                };

                var min = dt3_val.min();
                var max = dt3_val.max();


                getChart3(dt3, subtittle, year, min, max);


                // alert(min+'-'+max);
                // console.log(dt3_val);

            }
            else {

                swal("Whops", "Error when loading data", "error")

            }
        }
    });


}

function onClick2(e){

    $("#chartCustGroup").modal();
    blockModal(block);
    var param = e.dataPoint.x + 1;
    var label = e.dataPoint.label;

    $.ajax({
        type: "POST",
        url: "{{ url('ProduksiSumCustGroup') }}",
        data: {
            '_token': '{{ csrf_token() }}',
            'year': curr_year,
            'month': param

        },
        success: function(data) {

            if (data.length > 0) {

                dt3  = [];
                dt3_val = [];

                for (var i = 0; i < data.length; i++) {

                    if ( data[i].custGroup == 'KBT'){

                        dt3.push({ label: data[i].custGroup, y: parseFloat(data[i].wgt_prod), color: "#52575d" });

                    }

                    if ( data[i].custGroup == 'KMB'){

                        dt3.push({ label: data[i].custGroup, y: parseFloat(data[i].wgt_prod), color: "#0f3460" });

                    }

                    if ( data[i].custGroup == 'OTHER'){

                        dt3.push({ label: data[i].custGroup, y: parseFloat(data[i].wgt_prod), color: "#91d18b" });

                    }

                    if ( data[i].custGroup == 'MMM'){

                        dt3.push({ label: data[i].custGroup, y: parseFloat(data[i].wgt_prod), color: "#6f4a8e" });

                    }


                    if ( data[i].custGroup == 'STOCK KENCANA'){

                        dt3.push({ label: data[i].custGroup, y: parseFloat(data[i].wgt_prod), color: "#cf1b1b" });

                    }

                    if ( data[i].custGroup == 'STOCK VIVO' ){

                        dt3.push({ label: data[i].custGroup, y: parseFloat(data[i].wgt_prod), color: "#f6efa6" });

                    }

                    if ( data[i].custGroup == 'VIVO'){

                        dt3.push({ label: data[i].custGroup, y: parseFloat(data[i].wgt_prod), color: "#f6ab6c" });

                    }

                    dt3_val.push( data[i].wgt_prod );

                }


                $(block).unblock();

                subtittle = label+' '+curr_year;

                var year = curr_year;

                Array.prototype.max = function() {
                return Math.max.apply(null, this);
                };

                Array.prototype.min = function() {
                return Math.min.apply(null, this);
                };

                var min = dt3_val.min();
                var max = dt3_val.max();


                getChart3(dt3, subtittle, year, min, max);


                // alert(min+'-'+max);
                // console.log(dt3_val);


            }
            else {

                swal("Whops", "Error when loading data", "error")

            }
        }
    });


}

$(document).ready(function() {


    var block1 = $('#block1');
    blockElement(block1);

    var block2 = $('#block2');
    blockElement(block2);

    var block3 = $('#block3');
    blockElement(block3);

    block = $('#modalLoad');

    // Column
    $.ajax({
        type: "POST",
        url: "{{ url('ProduksiSum') }}",
        data: {
            '_token': '{{ csrf_token() }}',
            'prev_year': prev_year,
            'curr_year': curr_year

        },
        success: function(data) {

            if (data.length > 0) {

                dt1_prev_year =  [];
                dt1_curr_year =  [];
                for (var i = 0; i < data.length; i++) {

                    if ( data[i].year == prev_year ){

                        dt1_prev_year.push({ label: data[i].bulan, y: parseFloat(data[i].wgt_prod) });

                    }

                    if ( data[i].year == curr_year ){

                        dt1_curr_year.push({ label: data[i].bulan, y: parseFloat(data[i].wgt_prod) });

                    }
                }
                $(block1).unblock();
                subtittle = prev_year+' - '+curr_year;
                getChart1(dt1_prev_year, dt1_curr_year, subtittle);

            }
            else {

                $(block1).unblock();
                swal("Whops", "Error when loading data", "error")
                dt1_prev_year =  [];
                dt1_curr_year =  [];
                dt1_prev_year.push({ y: 0 });
                dt1_curr_year.push({ y: 0 });
                subtittle = prev_year+' - '+curr_year;
                getChart1(dt1_prev_year, dt1_curr_year, subtittle);

            }
        }
    });

    @if(!Session::get('MILLID'))

        result2.style.display = "block";
        result3.style.display = "block";

         // Pie 1
        $.ajax({
            type: "POST",
            url: "{{ url('ProduksiSumCurrMonth') }}",
            data: {
                '_token': '{{ csrf_token() }}',
                'curr_month': curr_month,
                'curr_year': curr_year

            },
            success: function(data) {

                if (data.length > 0) {

                    dt4 =  [];
                    for (var i = 0; i < data.length; i++) {
                        
                        dt4.push({ label: data[i].mill_name, y: parseFloat(data[i].wgt_prod), legendText: data[i].mill_id});
                    }
                    container  = "chartContainer4";
                    color = "colorSet1"
                    $(block2).unblock();
                    getPieChart(dt4, container, color);

                }
                else {

                    $(block2).unblock();
                    swal("Whops", "Error when loading data", "error")
                    dt4 = [];
                    dt4.push({ y: 0 });
                    container  = "chartContainer4";
                    color = "colorSet1"
                    getPieChart(dt4, container, color);

                }
            }
        });

        // Pie 2
        $.ajax({
            type: "POST",
            url: "{{ url('ProduksiSumPrevMonth') }}",
            data: {
                '_token': '{{ csrf_token() }}',
                'prev_month': prev_month,
                'curr_year': curr_year

            },
            success: function(data) {

                if (data.length > 0) {

                    dt5 =  [];
                    for (var i = 0; i < data.length; i++) {
                        
                        dt5.push({ label: data[i].mill_name, y: parseFloat(data[i].wgt_prod), legendText: data[i].mill_id });
                    }
                    container  = "chartContainer5";
                    $(block3).unblock();
                    getPieChart(dt5, container);

                }
                else {

                    $(block3).unblock();
                    swal("Whops", "Error when loading data", "error")
                    dt5 = [];
                    dt5.push({ y: 0 });
                    container  = "chartContainer5";
                    getPieChart(dt5, container);

                }
            }
        });

    @endif

    @if(Session::get('MILLID'))

        result2.style.display = "none";
        result3.style.display = "none";

    @endif








});

</script>

@endsection
{{-- Content Page JS End--}}
