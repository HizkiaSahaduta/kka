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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('QualityPerformance') }}">Quality Performance</a></li>
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
                            <h4>Production Quality Performance Analysis</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">

                    <div class="form-row mb-6">
                        <div class="form-group col-md-4">
                            <label class="text-dark" for="txtMill">Mill</label>
                            <div id="txtMillLoading">
                            <select class="form-control basic" name="txtMill" id="txtMill">
                                <option></option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="text-dark" for="txtDivision">Division</label>
                            <div id="txtDivisionLoading">
                            <select class="form-control basic" name="txtDivision" id="txtDivision">
                                <option></option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="text-dark" for="txtQuality">Quality</label>
                            <div id="txtQualityLoading">
                            <select class="form-control basic" name="txtQuality" id="txtQuality">
                                <option></option>
                            </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row mb-6">
                        <div class="form-group col-md-5">
                            <label class="text-dark" for="txtMachType">Mach Type</label>
                            <a id="txtMachTypeBadge"><span class="badge badge-danger">N/A</span></a>
                            <div id="txtMachTypeLoading">
                            <select class="form-control basic" name="txtMachType" id="txtMachType">
                                <option></option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group col-md-5">
                            <label class="text-dark" for="txtMachID">Mach ID</label>
                            <a id="txtMachIDBadge"><span class="badge badge-danger">N/A</span></a>
                            <div id="txtMachIDLoading">
                            <select class="form-control basic" name="txtMachID" id="txtMachID">
                                <option></option>
                            </select>
                            </div>
                        </div>
                    </div>


                    <div class="form-row mb-6">
                        <div class="form-group col-md-5">
                            <label class="text-dark" for="txtDtStart">Start Date</label>
                            <span class="badge badge-info">Period Date</span>
                            <input id="txtStartDate" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select start date">
                        </div>
                        <div class="form-group col-md-5">
                            <label class="text-dark" for="txtDtEnd">End Date</label>
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


        <div class="col-lg-4 layout-spacing layout-spacing" id="result1" style="display: none">
            <div class="statbox widget box box-shadow" id="resultLoading1">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Production Quality Performance Analysis % (Periodic)</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <select class="form-control basic" name="txtPeriode" id="txtPeriode">
                        <option></option>
                    </select>

                    <br>
                    <br>

                    <div id="chartContainer1" style="height: 370px; width: 100%;"></div>

                </div>
            </div>
        </div>

        <div class="col-lg-8 layout-spacing layout-spacing" id="result2" style="display: none">
            <div class="statbox widget box box-shadow" id="resultLoading2">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Production Quality Performance Analysis (Periodic)</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div id="chartContainer2" style="height: 443px; width: 100%;"></div>

                </div>
            </div>
        </div>

        <div class="col-lg-4 layout-spacing layout-spacing" id="result3" style="display: none">
            <div class="statbox widget box box-shadow" id="resultLoading3">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Production Quality Performance Analysis % (Daily)</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <select class="form-control basic" name="txtTanggal" id="txtTanggal">
                        <option></option>
                    </select>
                    
                    <br>
                    <br>

                    <div id="chartContainer3" style="height: 370px; width: 100%;"></div>

                </div>
            </div>
        </div>

        <div class="col-lg-8 layout-spacing layout-spacing" id="result4" style="display: none">
            <div class="statbox widget box box-shadow" id="resultLoading4">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Production Quality Performance Analysis (Daily)</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div id="chartContainer4" style="height: 443px; width: 100%;"></div>

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
var act;
var html, html2, txtMill, txtDivision, txtQuality, txtMachType, txtMachID, txtStartDate, txtEndDate, allreq;
var label, title, dp_total, dp_prime, dp_nonprime, dp_scrap, container, colorset;
var label2, title2, dp_total2, dp_prime2, dp_nonprime2, dp_scrap2, container2, colorset2;
var result1, result2, result3, result4;
var gb_dp_prime, gb_dp_nonprime, gb_dp_scrap;
var gb_dp_prime2, gb_dp_nonprime2, gb_dp_scrap2;


CanvasJS.addColorSet("colorSet1",[

    "#34626c",
    "#f05454",
    "#af6b58",
    "#c6b497"
]);

CanvasJS.addColorSet("colorSet2",[
    "#0db39e",
    "#efea5a",
    "#f1c453",
    "#f29e4c",
    "#16db93",
    "#83e377",
    "#b9e769",
    "#54478c",
    "#2c699a",
    "#048ba8"
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

function listMill(){

    var block = $('txtMillLoading');
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
    var block = $('#txtDivisionLoading');
    blockElement(block);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('listDivisionQP')}}",
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

function listQuality(){
    var block = $('#txtQualityLoading');
    blockElement(block);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('listQualityQP')}}",
        success: function (data) {
            $(block).unblock()
            $('select[name="txtQuality"]').empty();
            $('select[name="txtQuality"]').prepend('<option></option>');
            $.each(data, function(index, element) {
            $('select[name="txtQuality"]').append('<option value="'+element.grade+'">'+element.grade+'</option>');
            });
        }
    });

    $('#txtQuality').select2({
        placeholder: 'Choose Quality below',
        allowClear: true
    });

}

function listMachType(){
    $('#txtMachType').select2({
        placeholder: "Choose Mill first",
    });
}

function listMachTypeMill(txtMill){
    var block = $('#txtMachTypeLoading');
    blockElement(block);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('listMachTypeMillQP/mill=')}}"+txtMill,
        success: function (data) {
            $(block).unblock();
            $('select[name="txtMachType"]').empty();
            $('select[name="txtMachType"]').prepend('<option></option>');
            $.each(data, function(index, element) {
            $('select[name="txtMachType"]').append('<option value="'+element.mach_type+'">'+element.mach_type+' || '+element.descr+'</option>');
            });
        }
    });

    $('#txtMachType').select2({
        placeholder: 'Choose MachType below',
        allowClear: true
    });

}

function listMachTypeMillDiv(txtMilll, txtDivision){
    var block = $('#txtMachTypeLoading');
    blockElement(block);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('listMachTypeMillDivQP/mill=')}}"+txtMilll+ "&div=" +txtDivision,
        success: function (data) {
            $(block).unblock();
            $('select[name="txtMachType"]').empty();
            $('select[name="txtMachType"]').prepend('<option></option>');
            $.each(data, function(index, element) {
            $('select[name="txtMachType"]').append('<option value="'+element.mach_type+'">'+element.mach_type+' || '+element.descr+'</option>');
            });
        }
    });

    $('#txtMachType').select2({
        placeholder: 'Choose MachType below',
        allowClear: true
    });

}

function listMachID(){
    $('#txtMachID').select2({
        placeholder: "Choose Mach Type first",
    });
}

function listMachIDMillType(txtMill, txtMachType){
    var block = $('#txtMachIDLoading');
    blockElement(block);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('listMachIDMillType/mill=')}}"+txtMill+ "&type=" +txtMachType,
        success: function (data) {
            $(block).unblock();
            $('select[name="txtMachID"]').empty();
            $('select[name="txtMachID"]').prepend('<option></option>');
            $.each(data, function(index, element) {
            $('select[name="txtMachID"]').append('<option value="'+element.mach_id+'">'+element.descr+'</option>');
            });
        }
    });

    $('#txtMachID').select2({
        placeholder: 'Choose Mach ID below',
        allowClear: true
    });
}

function getChart(container, title, label, dp_prime, dp_nonprime, dp_scrap, colorset){
    chart = new CanvasJS.Chart(container, {
        colorSet: colorset,
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
                text: label,
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
            title: "Weight in KG",
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
                type: "stackedBar",
                click: onClick,
                name: "Prime",
                showInLegend: true,
            },
            {

                type: "stackedBar",
                click: onClick,
                name: "NonPrime",
                showInLegend: true,
            },
            {

                type: "stackedBar",
                click: onClick,
                name: "Scrap",
                showInLegend: true,
            },
        ]
    });
    chart.options.data[0].dataPoints = dp_prime;
    chart.options.data[1].dataPoints = dp_nonprime;
    chart.options.data[2].dataPoints = dp_scrap;
    // showDefaultText(chart1, "No Data Found!");

    if (x.matches) {

        for(var i = 0; i < chart.options.data.length; i++){
            chart.options.data[i].indexLabelFontSize = 6;
        }
        chart.render();
    }
    chart.render();
}

function getChart2(container, title, label, dp_prime, dp_nonprime, dp_scrap, colorset){
    chart = new CanvasJS.Chart(container, {
        colorSet: colorset,
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
                text: label,
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
            title: "Weight in KG",
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
                type: "stackedBar",
                name: "Prime",
                showInLegend: true,
            },
            {

                type: "stackedBar",
                name: "NonPrime",
                showInLegend: true,
            },
            {

                type: "stackedBar",
                name: "Scrap",
                showInLegend: true,
            },
        ]
    });
    chart.options.data[0].dataPoints = dp_prime;
    chart.options.data[1].dataPoints = dp_nonprime;
    chart.options.data[2].dataPoints = dp_scrap;
    // showDefaultText(chart1, "No Data Found!");

    if (x.matches) {

        for(var i = 0; i < chart.options.data.length; i++){
            chart.options.data[i].indexLabelFontSize = 6;
        }
        chart.render();
    }
    chart.render();
}

function getPieChart(container2, title2, label2, dp_prime2, dp_nonprime2, dp_scrap2, colorset2){
    var pie_chart = new CanvasJS.Chart(container2, {
        colorSet: colorset2,
	    animationEnabled: true,
        title: {
            text: title2,
            fontFamily: "Calibri",
            fontSize: 20
        },
        subtitles:[
            {
                text: label2,
                fontFamily: "Calibri",
                fontColor: "red",
                fontSize: 12
            }
        ],
        exportEnabled: true,
        theme: "light2",
        exportEnabled: true,
        legend:{
            cursor: "pointer",
            itemclick: toggleDataPointVisibility
        },
        data: [{
            type: "pie",
            percentFormatString: "#0.0#",
            indexLabel: "{label} #percent%",
            indexLabelFontSize: 11,
            dataPoints: [
			{y: dp_prime2, label: "Prime", legendText: "Prime"},
			{y: dp_nonprime2, label: "NonPrime", legendText: "NonPrime"},
			{y: dp_scrap2, label: "Scrap", legendText: "Scrap"}
		]
           
        }]
    });
    showDefaultText(pie_chart, "No Data Found!");

    if (x.matches) {

        for(var i = 0; i < pie_chart.options.data.length; i++){
            pie_chart.options.data[i].indexLabelFontSize = 8;
        }
        pie_chart.render();
    }
    pie_chart.render();
}

function onClick(e){

    var param = e.dataPoint.label;

    var block1 = $('#resultLoading3');
    var block2 = $('#resultLoading4');
    blockElement(block1);
    blockElement(block2);
    result3.style.display="block";
    result4.style.display="block";

    $('html, body').animate({
        scrollTop: $("#result4").offset().top
    }, 1200);

    $.ajax({
        type: "POST",
        url: "{{ url('chartQPRatioDaily') }}",
        data: {
            '_token': '{{ csrf_token() }}',
            'txtMill': txtMill,
            'txtDivision': txtDivision,
            'txtQuality': txtQuality,
            'txtMachType': txtMachType,
            'txtMachID': txtMachID,
            'txtPeriode': param
        },
        success: function (data) {


            if (data['error']) {
                swal("Error", (data['error']) , "error");
            }

            if (data.length > 0) {

                dp_prime = []; dp_nonprime = []; dp_scrap = [];

                dp_prime2 = 0; dp_nonprime2 = 0; dp_scrap2 = 0;

                for (var i = 0; i < data.length; i++) {
                    
                    dp_prime.push({  label: data[i].f_tanggal,  y: Math.round(data[i].prime * 10) / 10 });
                    dp_nonprime.push({  label: data[i].f_tanggal,  y: Math.round(data[i].nonprime * 10) / 10 });
                    dp_scrap.push({  label: data[i].f_tanggal,  y: Math.round(data[i].scrap * 10) / 10 });

                    dp_prime2 = dp_prime2 + Math.round(data[i].prime * 10) / 10;
                    dp_nonprime2 = dp_nonprime2 + Math.round(data[i].nonprime * 10) / 10;
                    dp_scrap2 = dp_scrap2 + Math.round(data[i].scrap * 10) / 10;

                }

                title = 'Date Period '+param;
                result3.style.display="block";
                result4.style.display="block";
               
                $('html, body').animate({
                    scrollTop: $("#result4").offset().top
                }, 1200);
                container = 'chartContainer4';
                colorset = 'colorSet1';
                getChart2(container, title, label, dp_prime, dp_nonprime, dp_scrap, colorset);

                // dp_prime2 = Math.round(dp_prime2 * 10) / 10;
                // dp_nonprime2 = Math.round(dp_nonprime2 * 10) / 10;
                // dp_scrap2 = Math.round(dp_scrap2 * 10) / 10;

                gb_dp_prime2 = dp_prime2;
                gb_dp_nonprime2 = dp_nonprime2;
                gb_dp_scrap2 = dp_scrap2;

                container2  = 'chartContainer3';
                colorset2 = 'colorSet1';
                title2 = title;
                label2 = label;
                getPieChart(container2, title2, label2, dp_prime2, dp_nonprime2, dp_scrap2, colorset2)


                $('select[name="txtTanggal"]').empty();
                $('select[name="txtTanggal"]').append('<option></option>');
                $.each(data, function(index, element) {
                    $('select[name="txtTanggal"]').append('<option value="'+element.tanggal+'">'+element.f_tanggal+'</option>');
                });

                $('#txtTanggal').select2({
                    placeholder: 'Choose Periode below',
                    allowClear: true
                });

                $(block1).unblock()
                $(block2).unblock()

            }
            
            if (data.length < 1){

                swal("Whops", "Data not available",  "error");

                result3.style.display="block";
                result4.style.display="block";
                container = 'chartContainer4';
                dp_prime = []; dp_nonprime = []; dp_scrap = [];
                dp_prime2 = 0; dp_nonprime2 = 0; dp_scrap2 = 0;
                dp_total.push({ y: 0 }); dp_prime.push({ y: 0 }); dp_nonprime.push({ y: 0 }); dp_scrap.push({ y: 0 });
                title = 'Date Period N/A';
                colorset = 'colorSet1';
                getChart(container, title, label, dp_prime, dp_nonprime, dp_scrap, colorset);
                
                container2  = 'chartContainer3';
                colorset2 = 'colorSet1';
                title2 = title;
                label2 = label;
                getPieChart(container2, title2, label2, dp_prime2, dp_nonprime2, dp_scrap2, colorset2)

                $('select[name="txtTanggal"]').empty();
                
                s$('#txtTanggal').select2({
                    placeholder: 'Choose Periode below',
                    allowClear: true
                });

                $(block1).unblock()
                $(block2).unblock()
                
            }
                  
                
            
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
    chart.options.data[0].showInLegend = true;
  }
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

$(document).ready(function() {

    $('#homeNav').attr('data-active','false');
    $('#homeNav').attr('aria-expanded','false');
    $('#ReportNav').attr('data-active','true');
    $('#ReportNav').attr('aria-expanded','true');
    $('.ReportTreeView').addClass('show');
    $('#QualityPerformance').addClass('active');

    result1 = document.getElementById("result1");
    result2 = document.getElementById("result2");
    result3 = document.getElementById("result3");
    result4 = document.getElementById("result4");


    @if(Session::has('MILLID'))

        txtMill = '{{ Session::get('MILLID') }}';

        if (txtMill){

            $('#txtMachTypeBadge').empty();
            html = "<span class='badge badge-success'>Mill ID #"+txtMill+"</span>";
            $('#txtMachTypeBadge').empty();
            $('#txtMachTypeBadge').append(html);
            listMachTypeMill(txtMill);

            $('#txtMachIDBadge').empty();
            html2 = "<span class='badge badge-danger'>N/A</span>";
            $('#txtMachIDBadge').empty();
            $('#txtMachIDBadge').append(html2);
            listMachID();

        }

        $('#txtDivision').change(function(){

            txtDivision = $('#txtDivision').val();
            $('select[name="txtMachID"]').empty();
            $('select[name="txtMachType"]').empty();

            if (!txtDivision){

                $('#txtMachTypeBadge').empty();
                html = "<span class='badge badge-success'>Mill ID #"+txtMill+"</span>";
                $('#txtMachTypeBadge').empty();
                $('#txtMachTypeBadge').append(html);
                listMachTypeMill(txtMill);

                $('#txtMachIDBadge').empty();
                html2 = "<span class='badge badge-danger'>N/A</span>";
                $('#txtMachIDBadge').empty();
                $('#txtMachIDBadge').append(html2);
                listMachID();

            }

            else if (txtMill && txtDivision){

                $('#txtMachTypeBadge').empty();
                html = "<span class='badge badge-success'>Mill ID #"+txtMill+" & Division #"+txtDivision+"</span>";
                $('txtMachTypeBadge').empty();
                $('#txtMachTypeBadge').append(html);
                listMachTypeMillDiv(txtMill, txtDivision);

                $('#txtMachIDBadge').empty();
                html2 = "<span class='badge badge-danger'>N/A</span>";
                $('#txtMachIDBadge').empty();
                $('#txtMachIDBadge').append(html2);
                listMachID();

            }
            else if (!txtMill && txtDivision){

                $('#txtMachTypeBadge').empty();
                html = "<span class='badge badge-danger'>N/A</span>";
                $('#txtMachTypeBadge').empty();
                $('#txtMachTypeBadge').append(html);
                listMachType();

                $('#txtMachIDBadge').empty();
                html2 = "<span class='badge badge-danger'>N/A</span>";
                $('#txtMachIDBadge').empty();
                $('#txtMachIDBadge').append(html2);
                listMachID();

            }

        
        });   

        $('#txtMachType').change(function(){

            txtMachType = $('#txtMachType').val();
            $('select[name="txtMachID"]').empty();

            if (!txtMachType){

                $('#txtMachIDBadge').empty();
                html = "<span class='badge badge-danger'>N/A</span>";
                $('#txtMachIDBadge').empty();
                $('#txtMachIDBadge').append(html);
                listMachID();

            }

            else {

                $('#txtMachIDBadge').empty();
                html = "<span class='badge badge-success'>Mill ID #"+txtMill+" & Mach #"+txtMachType+"</span>";
                $('#txtMachIDBadge').empty();
                $('#txtMachIDBadge').append(html);
                listMachIDMillType(txtMill, txtMachType);

            }




        });

       
    @else

        listMachType(); listMachID();

        $('#txtMill').change(function(){

            txtMill = $('#txtMill').val();
            txtDivision = $('#txtDivision').val();
            $('select[name="txtMachID"]').empty();
            $('select[name="txtMachType"]').empty();

            if (!txtMill && !txtDivision){

                $('#txtMachTypeBadge').empty();
                html = "<span class='badge badge-danger'>N/A</span>";
                $('#txtMachTypeBadge').empty();
                $('#txtMachTypeBadge').append(html);
                listMachType();

                $('#txtMachIDBadge').empty();
                html2 = "<span class='badge badge-danger'>N/A</span>";
                $('#txtMachIDBadge').empty();
                $('#txtMachIDBadgee').append(html2);
                listMachID();

            }

            else if (txtMill && !txtDivision){

                $('#txtMachTypeBadge').empty();
                html = "<span class='badge badge-success'>Mill ID #"+txtMill+"</span>";
                $('#txtMachTypeBadge').empty();
                $('#txtMachTypeBadge').append(html);
                listMachTypeMill(txtMill);

                $('#txtMachIDBadge').empty();
                html2 = "<span class='badge badge-danger'>N/A</span>";
                $('#txtMachIDBadge').empty();
                $('#txtMachIDBadge').append(html2);
                listMachID();

            }

            else if (txtMill && txtDivision){

                $('#txtMachTypeBadge').empty();
                html = "<span class='badge badge-success'>Mill ID #"+txtMill+" & Division #"+txtDivision+"</span>";
                $('txtMachTypeBadge').empty();
                $('#txtMachTypeBadge').append(html);
                listMachTypeMillDiv(txtMill, txtDivision);

                $('#txtMachIDBadge').empty();
                html2 = "<span class='badge badge-danger'>N/A</span>";
                $('#txtMachIDBadge').empty();
                $('#txtMachIDBadge').append(html2);
                listMachID();

            }
            else if (!txtMill && txtDivision){

                $('#txtMachTypeBadge').empty();
                html = "<span class='badge badge-danger'>N/A</span>";
                $('#txtMachTypeBadge').empty();
                $('#txtMachTypeBadge').append(html);
                listMachType();

                $('#txtMachIDBadge').empty();
                html2 = "<span class='badge badge-danger'>N/A</span>";
                $('#txtMachIDBadge').empty();
                $('#txtMachIDBadge').append(html2);
                listMachID();

            }

            

        });  

        $('#txtDivision').change(function(){

            txtMill = $('#txtMill').val();
            txtDivision = $('#txtDivision').val();
            $('select[name="txtMachID"]').empty();
            $('select[name="txtMachType"]').empty();

            if (!txtMill && !txtDivision){

                $('#txtMachTypeBadge').empty();
                html = "<span class='badge badge-danger'>N/A</span>";
                $('#txtMachTypeBadge').empty();
                $('#txtMachTypeBadge').append(html);
                listMachType();

                $('#txtMachIDBadge').empty();
                html2 = "<span class='badge badge-danger'>N/A</span>";
                $('#txtMachIDBadge').empty();
                $('#txtMachIDBadgee').append(html2);
                listMachID();

            }

            else if (txtMill && !txtDivision){

                $('#txtMachTypeBadge').empty();
                html = "<span class='badge badge-success'>Mill ID #"+txtMill+"</span>";
                $('#txtMachTypeBadge').empty();
                $('#txtMachTypeBadge').append(html);
                listMachTypeMill(txtMill);

                $('#txtMachIDBadge').empty();
                html2 = "<span class='badge badge-danger'>N/A</span>";
                $('#txtMachIDBadge').empty();
                $('#txtMachIDBadge').append(html2);
                listMachID();

            }

            else if (txtMill && txtDivision){

                $('#txtMachTypeBadge').empty();
                html = "<span class='badge badge-success'>Mill ID #"+txtMill+" & Division #"+txtDivision+"</span>";
                $('txtMachTypeBadge').empty();
                $('#txtMachTypeBadge').append(html);
                listMachTypeMillDiv(txtMill, txtDivision);

                $('#txtMachIDBadge').empty();
                html2 = "<span class='badge badge-danger'>N/A</span>";
                $('#txtMachIDBadge').empty();
                $('#txtMachIDBadge').append(html2);
                listMachID();

            }
            else if (!txtMill && txtDivision){

                $('#txtMachTypeBadge').empty();
                html = "<span class='badge badge-danger'>N/A</span>";
                $('#txtMachTypeBadge').empty();
                $('#txtMachTypeBadge').append(html);
                listMachType();

                $('#txtMachIDBadge').empty();
                html2 = "<span class='badge badge-danger'>N/A</span>";
                $('#txtMachIDBadge').empty();
                $('#txtMachIDBadge').append(html2);
                listMachID();

            }

        
        });   

        $('#txtMachType').change(function(){

            txtMachType = $('#txtMachType').val();
            txtMill = $('#txtMill').val();
            $('select[name="txtMachID"]').empty();

            if (!txtMachType){

                $('#txtMachIDBadge').empty();
                html = "<span class='badge badge-danger'>N/A</span>";
                $('#txtMachIDBadge').empty();
                $('#txtMachIDBadge').append(html);
                listMachID();

            }

            else {

                $('#txtMachIDBadge').empty();
                html = "<span class='badge badge-success'>Mill ID #"+txtMill+" & Mach #"+txtMachType+"</span>";
                $('#txtMachIDBadge').empty();
                $('#txtMachIDBadge').append(html);
                listMachIDMillType(txtMill, txtMachType);

            }




        });

        

    @endif

    listMill(); listDivision(); listQuality();

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


    $('#go').on('click', function() {

        @if(Session::has('MILLID'))

            txtMill = '{{ Session::get('MILLID') }}';

        @else

            txtMill = $('#txtMill').val();

        @endif

        txtDivision =  $('#txtDivision').val();
        txtQuality =  $('#txtQuality').val();
        txtMachType = $('#txtMachType').val();
        txtMachID = $('#txtMachID').val();
        txtStartDate = $('#txtStartDate').val();
        txtEndDate = $('#txtEndDate').val();
        allreq = '';

        if (!txtStartDate && !txtEndDate) {

            swal('Whops', 'At least you must choose start date/end date first', 'error');

        }

        else {

            blockUI();

            result1.style.display="none";
            result2.style.display="none";
            result3.style.display="none";
            result4.style.display="none";

            if (txtMill){

                label = 'Mill #'+txtMill;
            }

            if (txtDivision){

                label = label+', Div #'+txtDivision.trim();
            }

            if (txtQuality){

                label = label+', Grade #'+txtQuality.trim();
            }

            if (txtMachType){

                label = label+', MachType #'+txtMachType.trim();
            }

            if (txtMachID){

                label = label+', MachID #'+txtMachID.trim();
            }

            $.ajax({
                type: "POST",
                url: "{{ url('chartQPRatio') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'txtMill': txtMill,
                    'txtDivision': txtDivision,
                    'txtQuality': txtQuality,
                    'txtMachType': txtMachType,
                    'txtMachID': txtMachID,
                    'txtStartDate': txtStartDate,
                    'txtEndDate': txtEndDate
                },
                success: function (data) {

                    if (data['error']) {
                        swal("Error", (data['error']) , "error");
                    }

                    if (data.length > 0) {

                        dp_prime = []; dp_nonprime = []; dp_scrap = [];

                        dp_prime2 = 0; dp_nonprime2 = 0; dp_scrap2 = 0;

                        for (var i = 0; i < data.length; i++) {
                            
                            dp_prime.push({  label: data[i].Periode,  y: Math.round(data[i].prime * 10) / 10 });
                            dp_nonprime.push({  label: data[i].Periode,  y: Math.round(data[i].nonprime * 10) / 10 });
                            dp_scrap.push({  label: data[i].Periode,  y: Math.round(data[i].scrap * 10) / 10 });

                            dp_prime2 = dp_prime2 + Math.round(data[i].prime * 10) / 10;
                            dp_nonprime2 = dp_nonprime2 + Math.round(data[i].nonprime * 10) / 10;
                            dp_scrap2 = dp_scrap2 + Math.round(data[i].scrap * 10) / 10;

                        }
                        title = 'Date Period '+data[0].Periode+' - '+data[data.length-1].Periode;
                        result1.style.display="block";
                        result2.style.display="block";
                        $.unblockUI();
                        $('html, body').animate({
                            scrollTop: $("#result2").offset().top
                        }, 1200);
                        container = 'chartContainer2';
                        colorset = 'colorSet2';
                        act = "onClick";
                        getChart(container, title, label, dp_prime, dp_nonprime, dp_scrap, colorset, act);


                        // dp_prime2 = Math.round(dp_prime2 * 10) / 10;
                        // dp_nonprime2 = Math.round(dp_nonprime2 * 10) / 10;
                        // dp_scrap2 = Math.round(dp_scrap2 * 10) / 10;

                        gb_dp_prime = dp_prime2;
                        gb_dp_nonprime = dp_nonprime2;
                        gb_dp_scrap = dp_scrap2;

                        container2  = 'chartContainer1';
                        colorset2 = 'colorSet2';
                        title2 = title;
                        label2 = label;
                        getPieChart(container2, title2, label2, dp_prime2, dp_nonprime2, dp_scrap2, colorset2)

    
                        $('select[name="txtPeriode"]').empty();
                        $('select[name="txtPeriode"]').append('<option></option>');
                        $.each(data, function(index, element) {
                            $('select[name="txtPeriode"]').append('<option value="'+element.Periode+'">'+element.Periode+'</option>');
                        });

                        $('#txtPeriode').select2({
                            placeholder: 'Choose Periode below',
                            allowClear: true
                        });
                       



                    }
                    
                    if (data.length < 1){
                        $.unblockUI();
                        swal("Whops", "Data not available",  "error");
                        result1.style.display="block";
                        result2.style.display="block";
                        dp_prime = []; dp_nonprime = []; dp_scrap = [];
                        dp_prime2 = 0; dp_nonprime2 = 0; dp_scrap2 = 0;
                        dp_total.push({ y: 0 }); dp_prime.push({ y: 0 }); dp_nonprime.push({ y: 0 }); dp_scrap.push({ y: 0 });
                        title = 'Date Period N/A';
                        colorset = 'colorSet2';
                        act = " ";
                        getChart(container, title, label, dp_prime, dp_nonprime, dp_scrap, colorset, act);
                        
                        container2  = 'chartContainer1';
                        colorset2 = 'colorSet2';
                        title2 = title;
                        label2 = label;
                        getPieChart(container2, title2, label2, dp_prime2, dp_nonprime2, dp_scrap2, colorset2)

                        $('select[name="txtPeriode"]').empty();
                        
                        s$('#txtPeriode').select2({
                            placeholder: 'Choose Periode below',
                            allowClear: true
                        });
                        
                    }
                  
                }
            });

        }

    
    });

    $('#txtPeriode').change(function(){  

        var param = $('#txtPeriode').val();   

        var block = $('#resultLoading1');
        blockElement(block)

        if (param) {

            $.ajax({
                type: "POST",
                url: "{{ url('chartQPRatioPctPeriodic') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'txtMill': txtMill,
                    'txtDivision': txtDivision,
                    'txtQuality': txtQuality,
                    'txtMachType': txtMachType,
                    'txtMachID': txtMachID,
                    'txtPeriode': param
                },
                success: function (data) {

                    if (data['error']) {
                        swal("Error", (data['error']) , "error");
                    }

                    if (data.length > 0) {

                        dp_prime2 = 0; dp_nonprime2 = 0; dp_scrap2 = 0;

                        for (var i = 0; i < data.length; i++) {
                                
                            dp_prime2 = dp_prime2 + Math.round(data[i].prime * 10) / 10;
                            dp_nonprime2 = dp_nonprime2 + Math.round(data[i].nonprime * 10) / 10;
                            dp_scrap2 = dp_scrap2 + Math.round(data[i].scrap * 10) / 10;

                        }

                        $(block).unblock()
                        container2  = 'chartContainer1';
                        colorset2 = 'colorSet2';
                        title2 = 'Date Periode '+param;
                        label2 = label;
                        getPieChart(container2, title2, label2, dp_prime2, dp_nonprime2, dp_scrap2, colorset2)
                
                        
                    }
                    
                    if (data.length < 1){

                        $(block).unblock()
                        dp_prime2 = 0; dp_nonprime2 = 0; dp_scrap2 = 0;
                        container2  = 'chartContainer1';
                        colorset2 = 'colorSet2';
                        title2 = 'Date Periode N/A'
                        label2 = label;
                        getPieChart(container2, title2, label2, dp_prime2, dp_nonprime2, dp_scrap2, colorset2)

                    }
                    
                }
            }); 

        }

        else {

            $(block).unblock()
            dp_prime2 = Math.round(gb_dp_prime * 10) / 10;
            dp_nonprime2 = Math.round(gb_dp_nonprime * 10) / 10;
            dp_scrap2 = Math.round(gb_dp_scrap * 10) / 10;
            container2  = 'chartContainer1';
            colorset2 = 'colorSet2';
            title2 = title;
            label2 = label;
            getPieChart(container2, title2, label2, dp_prime2, dp_nonprime2, dp_scrap2, colorset2)



        }

        

    }); 

    $('#txtTanggal').change(function(){  

        var param = $('#txtTanggal').val();   


        var e = document.getElementById("txtTanggal");
        var txtTanggal = e.options[e.selectedIndex].text;

        var block = $('#resultLoading3');
        blockElement(block)

        if (param) {

            $.ajax({
                type: "POST",
                url: "{{ url('chartQPRatioPctDaily') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'txtMill': txtMill,
                    'txtDivision': txtDivision,
                    'txtQuality': txtQuality,
                    'txtMachType': txtMachType,
                    'txtMachID': txtMachID,
                    'txtTanggal': param
                },
                success: function (data) {

                    if (data['error']) {
                        swal("Error", (data['error']) , "error");
                    }

                    if (data.length > 0) {

                        dp_prime2 = 0; dp_nonprime2 = 0; dp_scrap2 = 0;

                        for (var i = 0; i < data.length; i++) {
                                
                            dp_prime2 = dp_prime2 + Math.round(data[i].prime * 10) / 10;
                            dp_nonprime2 = dp_nonprime2 + Math.round(data[i].nonprime * 10) / 10;
                            dp_scrap2 = dp_scrap2 + Math.round(data[i].scrap * 10) / 10;

                        }

                        $(block).unblock()
                        container2  = 'chartContainer3';
                        colorset2 = 'colorSet1';
                        title2 = 'Date Periode '+txtTanggal;
                        label2 = label;
                        getPieChart(container2, title2, label2, dp_prime2, dp_nonprime2, dp_scrap2, colorset2)
                
                        
                    }
                    
                    if (data.length < 1){

                        $(block).unblock()
                        dp_prime2 = 0; dp_nonprime2 = 0; dp_scrap2 = 0;
                        container2  = 'chartContainer3';
                        colorset2 = 'colorSet1';
                        title2 = 'Date N/A'
                        label2 = label;
                        getPieChart(container2, title2, label2, dp_prime2, dp_nonprime2, dp_scrap2, colorset2)

                    }
                    
                }
            }); 

        }

        else {

            $(block).unblock()
            dp_prime2 = Math.round(gb_dp_prime2 * 10) / 10;
            dp_nonprime2 = Math.round(gb_dp_nonprime2 * 10) / 10;
            dp_scrap2 = Math.round(gb_dp_scrap2 * 10) / 10;
            container2  = 'chartContainer3';
            colorset2 = 'colorSet1';
            title2 = title;
            label2 = label;
            getPieChart(container2, title2, label2, dp_prime2, dp_nonprime2, dp_scrap2, colorset2)



        }

        

    }); 

    $('#reset').on('click', function() {

        listMill();
        $('#txtDivision').val(null).trigger('change');
        $('#txtQuality').val(null).trigger('change');
        $('#txtMachType').val(null).trigger('change');
        $('#txtMachID').val(null).trigger('change');
        f1.clear();
        f2.clear();
        result1.style.display="none";
        result2.style.display="none";
        result3.style.display="none";
        result4.style.display="none";

    });




});


</script>

@endsection
{{-- Content Page JS End--}}
