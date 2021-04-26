@extends('main')

{{-- Content Page CSS Begin--}}
@section('contentcss')

<link href="{{ asset('outside/plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.4/css/responsive.dataTables.min.css" />

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
                            <h4>Machine Order Capacity</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">

                    <div class="row">

                        <div class="col-lg-3 col-6 form-group">
                            <label for="txtMillID">Mill ID</label>
                            <select id='txtMillID' name='txtMillID' class="form-control">
                            <option value='' selected>-- Mill ID --</option>
                            @if(isset($millId))
                                @foreach($millId as $mill)
                                <option value='{{ $mill->mill }}'>{{ $mill->mill_name }}</option>
                                @endforeach
                            @endif
                            </select>
                        </div>

                        <div class="col-lg-3 col-6 form-group">
                            <label for="txtMachType">Mach Type <span class="badge badge-info badgeMill" style="display: none;"></span></label>
                            <select id='txtMachType' name='txtMachType' class="form-control">
                            <option value='' selected>-- Mach Type --</option>
                            </select>
                        </div>

                        <div class="col-lg-3 col-6 form-group">
                            <label for="dtStart">Date Start</label>
                            <input id="dtStart" name="dtStart" class="form-control flatpickr flatpickr-input active text-black" type="text" style="width: 100%;" placeholder="Start Date">
                        </div>

                        <div class="col-lg-3 col-6 form-group">
                            <label for="dtEnd">Date End</label>
                            <input id="dtEnd" name="dtEnd" class="form-control flatpickr flatpickr-input active text-black" type="text" style="width: 100%;" placeholder="End Date">
                        </div>

                        <div class="col-lg-12 col-12 form-group">
                            <button type="submit" id="submit" class="btn btn-primary btn-block" >FIND</button>
                        </div>

                        <div class="col-lg-12 col-12 form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rdResult" id="rdResultGrid" checked>
                                <label class="form-check-label" for="rdResultGrid">
                                    Show result in table.
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rdResult" id="rdResultGraph">
                                <label class="form-check-label" for="rdResultGraph">
                                    Show result in graph.
                                </label>
                            </div>
                        </div>
                    
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 layout-spacing tResultGrid">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>TABLE RESULT</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">

                <span class="badge badge-info badgeWeekStart" style="display: none;"></span>
                <span class="badge badge-info badgeWeekEnd" style="display: none;"></span>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="ResultTable">
                            <thead>
                                <tr>
                                    <th>Year</th>
                                    <th>Week</th>
                                    <th>Mill</th>
                                    <th>Machine</th>
                                    <th>Mach. Total Capacity</th>
                                    <th>Total Order Length(m)</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 layout-spacing tResultGraph">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>GRAPH RESULT</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">

                    <div id="chartContainer1" style="height: 500px; width: 100%;"></div>

                </div>
            </div>
        </div>

    </div>
</div>


@endsection
{{-- Content Page End--}}

{{-- Content Page JS Begin--}}
@section('contentjs')

<script src="{{ asset('outside/plugins/flatpickr/flatpickr.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.4/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.4/js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript" src="{{ asset('canvasjs.min.js') }}"></script>

<script>

var dataPoints1, dataPoints2;
var x = window.matchMedia("(max-width: 991px)");

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function renderChart1(datapoints1, datapoints2){

    var chart1 = new CanvasJS.Chart("chartContainer1", {
        animationEnabled: true,
        theme: "light2",
        title:{
            text: "Machine Capacity Graph"
        },
        axisX:{
            crosshair: {
                enabled: true,
                snapToDataPoint: true
            }
        },
        axisY: {
            title: "Length(m)",
            titleFontSize: 24,
            crosshair: {
                enabled: true,
                snapToDataPoint: true
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
                type: "spline",
                indexLabel: "{y}",
                name: "Total Order",
                indexLabelFontSize: 12,
                showInLegend: true, 
                indexLabelOrientation: "horizontal",
                lineColor: "#3a34eb",
                indexLabelFontColor: "#3a34eb"
            },
            {
                type: "spline",
                indexLabel: "{y}",
                name: "Mach. Capacity",
                indexLabelFontSize: 12,
                showInLegend: true, 
                indexLabelOrientation: "horizontal",
                lineColor: "#5f34eb",
                indexLabelFontColor: "#5f34eb"
            }
        ]
    });

    chart1.options.data[0].dataPoints = datapoints1;
    chart1.options.data[1].dataPoints = datapoints2;

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

    $('#homeNav').attr('data-active','false');
    $('#homeNav').attr('aria-expanded','false');
    $('#ReportNav').attr('data-active','true');
    $('#ReportNav').attr('aria-expanded','true');
    $('.ReportTreeView').addClass('show');
    $('#MachOrderCapacity').addClass('active');

    $('#txtMillID').val("");
    $('#txtMachType').val("");
    $('#txtYear').val("");
    $('#txtWeek').val("");

    var d = new Date();

    $("#dtStart").flatpickr({
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        time_24hr: "true",
        defaultDate: d
    });

    $("#dtEnd").flatpickr({
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        time_24hr: "true",
        defaultDate: d
    });

    $(".tResultGrid").hide();
    $(".tResultGraph").hide();

    $('#txtMillID').change(function(){

        var millID = $('#txtMillID').val();
        var e = document.getElementById("txtMillID");
        var millName = e.options[e.selectedIndex].text;

        $(".badgeMill").show();

        $(".badgeMill").html("loading..");

        if(millID) {
            $.ajax({
                url: 'getMachID',
                type: "GET",
                dataType: "json",
                data:{
                    'txtMillID' : millID
                },
                beforeSend: function(){
                    $('.ajax-loader').css("visibility", "visible");
                },
                success:function(data) {
					$(".badgeMill").html(millName);
                    $('select[name="txtMachType"]').empty();
                    $('select[name="txtMachType"]').append('<option value="">-- Mach Type --</option>');
                    $.each(data, function(index, element) {
                        $('select[name="txtMachType"]').append('<option value="'+ element.mach_type.trim() +'">'+ element.descr.trim() +'</option>');
                    });
                },
                complete: function(){
                    $('.ajax-loader').css("visibility", "hidden");
                }
            });
        }
        else{
            $(".badgeMill").hide();
            $('select[name="txtMachType"]').empty();
            $('select[name="txtMachType"]').append('<option value="">-- Mach Type --</option>');
        }


    });

    $("#submit").click(function(){

        var rdResultGrid = $('#rdResultGrid').prop('checked');

        if(rdResultGrid){

            if($('#dtStart').val() != '' && $('#dtEnd').val() != '' ){
                populateTable();
            }
            else{
                swal("Alert", "Please choose date start and date end", "warning");
            }

        }
        else{

            if($('#dtStart').val() != '' && $('#dtEnd').val() != '' && $('#txtMillID').val() != '' && $('#txtMachType').val() != '' ){
                populateTableGraph();
            }
            else{
                swal("Alert", "Please choose mach. type", "warning");
            }

        }        

    });

});

function populateTable(){

    $("#submit").attr("disabled", true);
    document.getElementById("submit").textContent = 'Loading...';
    $(".tResultGrid").hide();
    

    var dataTable = $('#ResultTable').DataTable({
        destroy: true,
        responsive: true,
        processing: true,
        "bFilter": false,
        "bLengthChange": false,
        serverSide: true,
        autoWidth: false,
        pageLength: 20,
        ajax: {
            url:'{!!url("FindOrderCapacity")!!}',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                '_token': '{{ csrf_token() }}',
                'txtMillID': $('#txtMillID').val(),
                'txtMachType': $('#txtMachType').val(),
                'dtStart': $('#dtStart').val(),
                'dtEnd': $('#dtEnd').val()
            }
        },
        columns: [
            { data: 'tahun', name: 'tahun', className: "text-right", orderable:false },
            { data: 'minggu', name: 'minggu', className: "text-right", orderable:false },
            { data: 'mill', name: 'mill', className: "text-right", orderable:false },
            { data: 'NamaMesin', name: 'NamaMesin', className: "text-right", orderable:false },
			{ data: 'mach_cap_week', className: "text-right", render: $.fn.dataTable.render.number(',', '.', 0, ''), name: 'mach_cap_week',orderable:false },
            { data: 'TotPanjangOrder', className: "text-right", render: $.fn.dataTable.render.number(',', '.', 0, ''), name: 'TotPanjangOrder',orderable:false }
        ],
        initComplete: function(settings, json) {

            if (dataTable.rows().data().length) 
            {

                $(".badgeWeekStart").show();
                $(".badgeWeekStart").html("Start Week : " + json.weekStart);

                $(".badgeWeekEnd").show();
                $(".badgeWeekEnd").html("End Week : " + json.weekEnd);

                $(".tResultGrid").show();
                $(".tResultGraph").hide();
                $("#submit").attr("disabled", false);
                document.getElementById("submit").textContent = 'FIND';
                swal("Done!", "Data loaded successfully", "success");
            }
            if (!dataTable.rows().data().length) 
            {
                $(".tResultGrid").hide();
                $(".tResultGraph").hide();
                $("#submit").attr("disabled", false);
                document.getElementById("submit").textContent = 'FIND';
                swal("Oops! :(", "Data not available", "error");
            }
        },
    });

}

function populateTableGraph(){

    $txtMillID = $("#txtMillID").val();
    $txtMachType = $("#txtMachType").val();
    $dtStart = $("#dtStart").val();
    $dtEnd = $("#dtEnd").val();

    $.ajax({
        url: "{{ url('FindOrderCapacityGraph') }}",
        type: "post",
        dataType: "json",
        data: {
            'txtMillID' : $txtMillID,
            'txtMachType' : $txtMachType,
            'dtStart' : $dtStart,
            'dtEnd' : $dtEnd
        },
        success: function(data) {

            if (data.length > 0) {

                dataPoints1 = [];
                dataPoints2 = [];

                for (var i = 0; i < data.length; i++) {

                    dataPoints1.push({ label: 'week: ' + data[i].minggu, y: parseFloat(data[i].TotPanjangOrder) });
                    dataPoints2.push({ label: 'week: ' + data[i].minggu, y: parseFloat(data[i].mach_cap_week) });

                }

                // console.log(dataPoints1);

                $(".tResultGrid").hide();
                $(".tResultGraph").show();
                renderChart1(dataPoints1, dataPoints2);

                swal('SUCCESS', 'Data populated successfully','success');
                
            }
            else
            {
                swal('WARNING', 'Data not found !','warning');
                $(".tResultGrid").hide();
                $(".tResultGraph").hide();
            }

        }
    });

}




</script>

@endsection
{{-- Content Page JS End--}}
