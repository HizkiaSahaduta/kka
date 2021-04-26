@extends('main')

{{-- Content Page CSS Begin--}}
@section('contentcss')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<style>

.form-group label, label {
    color: #000 !important;
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
                            <li class="breadcrumb-item"><a href="javascript:void(0);">User Management</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('ChangePass') }}">Change Password</a></li>
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

        <div class="col-lg-12 col-md-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Blank</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">
                
                    <div class="row">

                        <div class="col-lg-3 col-6 form-group">
                            <p>TIMELINE</p>
                                <select id='txtTimeline' name='txtTimeline' class="form-control">
                                    <option value='minute1'>-- 1 Minutes --</option>
                                    <option value='minute5'>-- 5 minutes --</option>
                                    <option value='minute10'>-- 10 minutes --</option>
                                    <option value='minute15'>-- 15 minutes --</option>
                                    <option value='minute20'>-- 20 minutes --</option>
                                    <option value='minute30'>-- 30 minutes --</option>
                                    <option value='hour1'>-- 1 hour --</option>
                                    <option value='hour2'>-- 2 hours --</option>
                                    <option value='hour3'>-- 3 hours --</option>
                                    <option value='hour4'>-- 4 hours --</option>
                                    <option value='hour6'>-- 6 hours --</option>
                                    <option value='hour8'>-- 8 hours --</option>
                                    <option value='hour12'>-- 12 hours --</option>
                                    <option value='hour24' selected>-- 24 hours --</option>
                                </select>
                        </div>

                        <div class="col-lg-3 col-6 form-group">
                            <p>DATE</p>
                            <input id="dtStart" class="form-control flatpickr flatpickr-input active text-black" type="text" placeholder="Select Date.." data-input>
                        </div>

                        <div class="col-lg-3 col-6 form-group">
                            <button type="button" class="btn btn-success btn-block" id="btnSearch" name="btnSearch" >SUBMIT</button>
                        </div>

                    </div>

                    <div class="row">

                        <div id="chartContainer1" style="height: 500px; width: 100%;"></div>
                    
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>


@endsection
{{-- Content Page End--}}

{{-- Content Page JS Begin--}}
@section('contentjs')

<script type="text/javascript" src="{{ asset('canvasjs.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>

var dataPoints1, dataPoints2;
var x = window.matchMedia("(max-width: 991px)");

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$("#dtStart").flatpickr({
    enableTime: true,
    altFormat: "F j, Y",
    dateFormat: "Y-m-d",
});

function renderChart1(datapoints1){

    var chart1 = new CanvasJS.Chart("chartContainer1", {
        animationEnabled: true,
        zoomEnabled: true,
        theme: "light2",
        title:{
            text: "Machine Capacity Graph"
        },
        axisX:{
			labelFontSize: 10,
            interval: 1,
            crosshair: {
                enabled: true,
                snapToDataPoint: true,
                
            }
        },
        axisY: {
            title: "Length(m)",
            titleFontSize: 24,
            crosshair: {
                enabled: true,
                snapToDataPoint: true
            },
            labelFormatter: function(){
            return " ";
            },
        },
        legend: {
            fontColor: "red",
            cursor: "pointer"
        },
        toolTip:{
            shared:true
        },
        data: [
            {
                type: "column",
                // indexLabel: "{y}",
                name: "Length",
                indexLabelFontSize: 12,
                showInLegend: true, 
                indexLabelOrientation: "horizontal",
                lineColor: "#3a34eb",
                indexLabelFontColor: "#3a34eb"
            }
        ]
    });

    chart1.options.data[0].dataPoints = datapoints1;

    if (x.matches) {
        for(var i = 0; i < chart1.options.data.length; i++){
            chart1.options.data[i].indexLabelFontSize = 6;
        }
        chart1.render();
    }

    chart1.render();

}

function toggleDataSeries(e) {
    if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    } else {
        e.dataSeries.visible = true;
    }
    e.chart.render();
}


$(document).ready(function() {

    

    $('#btnSearch').on('click', function() {

        populateTableGraph();

    }); 

});

function populateTableGraph(){

    var txtTimeline = $('#txtTimeline').val();
    var dtStart = $('#dtStart').val();

    $.ajax({
        url: "{{ url('populateTest') }}",
        type: "get",
        dataType: "json",
        data:{
            'txtTimeline' : txtTimeline,
            'dtStart' : dtStart
        },
        success: function(data) {

            if (data.length > 0) {

                dataPoints1 = [];

                for (var i = 0; i < data.length; i++) {

                    dataPoints1.push({ label: data[i].waktu, y: parseFloat(data[i].length) });

                }
                renderChart1(dataPoints1);
                
            }
            else
            {
                swal('WARNING', 'Data not found !','warning');
            }

        }
    });

}




</script>

@endsection
{{-- Content Page JS End--}}
