@extends('main')

{{-- Content Page CSS Begin--}}
@section('contentcss')

<link href="{{ asset('outside/plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.4/css/responsive.dataTables.min.css" />

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
                    <!-- <div class="page-title">
                        <h3>Blank Page</h3>
                    </div> -->

                    <nav class="breadcrumb-one" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">KKK System</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('CustomerVisit') }}">Data Logger</li>
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

			<div class="col-lg-12 layout-spacing layout-spacing">
				<div class="statbox widget box box-shadow">
					<div class="widget-header">
						<div class="row">
							<div class="col-xl-12 col-md-12 col-sm-12 col-12">
								<h4>Datalogger Per Shift</h4>
							</div>
						</div>
					</div>
					<div class="widget-content widget-content-area">
                        <div class="row">

                            <div class="col-lg-3 col-6 form-group">
                                <p>MILL ID</p>
                                <select id='txtMillID' name='txtMillID' class="form-control">
                                <option value='' selected>-- MILL ID --</option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-6 form-group">
                                <p>MACHINE</p>
                                <select id='txtMachType' name='txtMachType' class="form-control">
                                    <option value='' selected>-- MACH TYPE --</option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-6 form-group">
                                <p>MACHINE ID</p>
                                <select id='txtMachId' name='txtMachId' class="form-control">
                                    <option value='' selected>-- MACH ID --</option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-6 form-group">
                                <p>ROUND VALUE</p>
                                <select id='txtRound' name='txtRound' class="form-control">
                                    <option value='50' selected>50</option>
                                    <option value='100'>100</option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-6 form-group">
                                <p>SHIFT HOUR</p>
                                <select id='txtShiftMode' name='txtShiftMode' class="form-control">
                                    <option value='short' selected>Short (8hrs)</option>
                                    <option value='long'>Long (12hrs)</option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-6 form-group">
                                <p>DATE</p>
                                <input id="dtStart" name="dtStart" class="form-control flatpickr flatpickr-input active text-black" type="text" style="width: 100%;" placeholder="Select Date">
                                <!-- <button class="input-button" id="clrStart" title="clear" data-clear>RESET</button> -->
                            </div>

                            <div class="col-lg-3 col-6 form-group">
                                <p>Shift Start Hour</p>
                                <input id="dtHour" name="dtHour" class="form-control flatpickr flatpickr-input active text-black" type="text" style="width: 100%;" placeholder="Select Hour">
                                <!-- <button class="input-button" id="clrEnd" title="clear" data-clear>RESET</button> -->
                            </div>
                          

                            <div class="col-lg-12 col-12 form-group">
                                <button type="button" class="btn btn-success btn-block" id="btnSearch" name="btnSearch" >SUBMIT</button>
                            </div>

                        </div>
					</div>
				</div>
            </div>

            <div class="col-lg-12 layout-spacing layout-spacing tSearch">
				<div class="statbox widget box box-shadow">
					<div class="widget-header">
						<div class="row">
							<div class="col-xl-12 col-md-12 col-sm-12 col-12">
								<h4>Result</h4>
							</div>
						</div>
					</div>
					<div class="widget-content widget-content-area">

                        <table class="table" id="dataLoggerTable">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Mill</th>
                                <th>Shift</th>
                                <th>Machine</th>
                                <th>Mach ID</th>
                                <th>Cut Total Logger</th>
                                <th>Cut Total Mill</th>
                                <th>Total(m) Logger</th>
                                <th>Total(m) Mill</th>
                                <th>Details</th>
                                <th>Details KKA</th>
                            </tr>
                            </thead>
                        </table>

                    </div>
				</div>
            </div>
            
			
		</div>
	</div>

    <div class="modal fade" id="ShiftItemModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="header"></h6>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="modal"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </div>
                <div class="modal-body">
            
                    <table id="OverviewShiftDetail" class="table mb-4" style="width:100%">
                        <thead>
                            <tr>
                                <th>Shift</th>
                                <th>Qty</th>
                                <th>Cut Length(mm)</th>
                                <th>Total Length(m)</th>
                            </tr>
                        </thead>
                    </table>
                  
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ShiftItemModalKKA" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="header"></h6>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="modal"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </div>
                <div class="modal-body">
            
                    <table id="OverviewShiftDetailKKA" class="table mb-4" style="width:100%">
                        <thead>
                            <tr>
                                <th>Shift</th>
                                <th>Qty</th>
                                <th>Cut Length(mm)</th>
                                <th>Total Length(m)</th>
                            </tr>
                        </thead>
                    </table>
                  
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal">Close</button>
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


<script type="text/javascript">

// $("#dtHourStart").flatpickr({
//     enableTime: true,
//     noCalendar: true,
//     time_24hr: true,
//     dateFormat: "H:i",
// });

// $("#hourEnd").flatpickr({
//     enableTime: true,
//     noCalendar: true,
//     time_24hr: true,
//     dateFormat: "H:i",
// });

    var d = new Date();
    var e = new Date();
    d.setHours(06);
    d.setMinutes(00);
    d.setSeconds(00);
    e.setHours(23);
    e.setMinutes(59);
    e.setSeconds(59);

$("#dtStart").flatpickr({
    altInput: true,
    altFormat: "F j, Y",
    dateFormat: "Y-m-d",
    time_24hr: "true",
    //defaultDate: "today",
    defaultDate: d,
    // defaultHour: 00,
    // defaultMinute: 00,
});

$("#dtHour").flatpickr({
    altInput: true,
    altFormat: "H:i",
    noCalendar: true,
    enableTime: true,
    dateFormat: "H:i",
    time_24hr: "true",
    // defaultDate: "23:59",
    defaultDate: d,
    // defaultHour: 23,
    // defaultMinute: 59,
});


$(document).ready(function() {

    @if(isset($millname))
        @foreach($millname as $mill)
            
            $('select[name="txtMillID"]').append('<option value="{{ $mill->Key }}">{{ $mill->Lokasi }}</option>');
            
        @endforeach
    @endif

    $('#homeNav').attr('data-active','false');
    $('#homeNav').attr('aria-expanded','false');
    $('#DataLoggerNav').attr('data-active','true');
    $('#DataLoggerNav').attr('aria-expanded','true');
    $('.DataLoggerTreeView').addClass('show');
    $('#DataloggerPerShift').addClass('active');
    
    $('#txtMillID').change(function(){

        var millID = $(this).val();

        if(millID)
        {
            populateMachType(millID);
        }
        else
        {
            $('select[name="txtMachType"]').empty();
            $('select[name="txtMachType"]').append('<option value="">-- MACH TYPE --</option>');
        }

    });

    $('#txtMachType').change(function(){

        var machID = $(this).val();
        var millID = $('#txtMillID').val();

        if(machID)
        {
            populateMachId(millID, machID);
        }
        else
        {
            $('select[name="txtMachId"]').empty();
            $('select[name="txtMachId"]').append('<option value="">-- MACH ID --</option>');
        }

    });

    $('#btnSearch').on('click', function() {
        
        var millID = $('#txtMillID').val();

        if(millID != ''){
            populateTable();
        }
        else{
            swal("Oops! :(", "Please choose Mill !", "error");
        }

    });

    $('body').on('click', '#ShiftItemList', function(e) {

        var date = $(this).data('date');
        var shift = $(this).data('shift');
        var id = $(this).data('id');

        populateTableDetail(date, shift, id);

    });

    $('body').on('click', '#ShiftItemListKKA', function(e) {

        var date = $(this).data('date');
        var shift = $(this).data('shift');
        var mill = $(this).data('mill');
        var mach = $(this).data('mach');
        var id = $(this).data('id');

        populateTableDetailKKA(date, shift, mill, mach, id);

    });


});

function populateMachType(id)
{

    $.ajax({
        url: "{{ url('ProductionLoggerMach') }}",
        type: "GET",
        data: {
            'id' : id
        },
        dataType: "json",
        success:function(data) {

            $('select[name="txtMachType"]').empty();
            $('select[name="txtMachType"]').append('<option value="">-- MACH TYPE --</option>');
            $.each(data, function(index, element) {
                $('select[name="txtMachType"]').append('<option value="'+ element.Type_Key +'">'+ element.Type_Key + '</option>');
            });

        }
    });

}

function populateMachId(millID, machId)
{

    $.ajax({
        url: "{{ url('ProductionLoggerMachId') }}",
        type: "GET",
        data: {
            'machId' : machId,
            'millID' : millID
        },
        dataType: "json",
        success:function(data) {

            $('select[name="txtMachId"]').empty();
            $('select[name="txtMachId"]').append('<option value="">-- MACH ID --</option>');
            $.each(data, function(index, element) {
                $('select[name="txtMachId"]').append('<option value="'+ element.Id +'">'+ element.Id + '</option>');
            });

        }
    });

}

function populateTable()
{

    var dataTable = $('#dataLoggerTable').DataTable({
        destroy: true,
        responsive: true,
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            if(aData.shift == "1"){
                $("td", nRow).css("background-color", "#44e3dd");
            }
            else if(aData.shift == "2"){
                 $("td", nRow).css("background-color", "#e5f57d");
            }
            else if(aData.shift == "3"){
                 $("td", nRow).css("background-color", "#a3abff");
            }
        },
        processing: true,
        "bFilter": false,
        "bLengthChange": false,
        serverSide: true,
        autoWidth: false,
        pageLength: 20,
        // scrollX: true,
        "order": [[ 0, "desc" ]],
        ajax: {
            url:'{!!url("FindDataloggerPerShift")!!}',
            type: 'post',
            headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                '_token': '{{ csrf_token() }}',
                'txtMillID': $('#txtMillID').val(),
                'txtMachType': $('#txtMachType').val(),
                'txtMachId': $('#txtMachId').val(),
                'txtRound': $('#txtRound').val(),
                'txtShiftMode': $('#txtShiftMode').val(),
                'dtStart': $('#dtStart').val(),
                'dtHour': $('#dtHour').val()
            }
        },
        columns: [
            { data: 'tanggal', name: 'tanggal', className: "text-right", orderable:false },
            { data: 'lokasi', name: 'lokasi', className: "text-right", orderable:false },
            { data: 'shift', name: 'shift', className: "text-right", orderable:false },
            { data: 'Type_Key', name: 'Type_Key', className: "text-right", orderable:false },
            { data: 'Id', name: 'Id', className: "text-right", orderable:false },
            { data: 'jumlah', name: 'jumlah', className: "text-right", orderable:false },
            { data: 'jmlhpotong', name: 'jmlhpotong', className: "text-right", orderable:false },
            { data: 'total_panjang', className: "text-right", render: $.fn.dataTable.render.number(',', '.', 0, ''), name: 'total_panjang',orderable:false },
            { data: 'totalPanjangTot', className: "text-right", render: $.fn.dataTable.render.number(',', '.', 0, ''), name: 'totalPanjangTot',orderable:false },
            { data: 'Actions', name: 'Actions',orderable:false,searchable:false,sClass:'text-center'},
            { data: 'Actions2', name: 'Actions2',orderable:false,searchable:false,sClass:'text-center'}
        ],
        initComplete: function(settings, json) {
            if (dataTable.rows().data().length) 
            {
                swal("Done!", "Data loaded successfully", "success");
            }
            if (!dataTable.rows().data().length) 
            {
                swal("Oops! :(", "Data not available", "error");
            }
        },
    });

}

function populateTableDetail(date, shift, id)
{

    var txtRound = $('#txtRound').val();
    var txtHour = $('#dtHour').val();

    var dataTable = $('#OverviewShiftDetail').DataTable({
        destroy: true,
        "bFilter": false,
        "bLengthChange": false,
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        pageLength: 20,
        // scrollX: true,
        "order": [[ 0, "desc" ]],
        ajax: {
            url:'{!!url("DataPerShiftDetail")!!}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                '_token': '{{ csrf_token() }}',
                'txtDate': date,
                'txtHour': txtHour,
                'txtShift': shift,
                'txtSiteMesinKey': id,
                'txtRound': txtRound
            }
        },
        columns: [
            { data: 'shift', name: 'shift', orderable:false },
            { data: 'jumlah', name: 'jumlah', className: "text-right", render: $.fn.dataTable.render.number(',', '.', 0, ''), orderable:false },
            { data: 'panjang', name: 'panjang', className: "text-right", render: $.fn.dataTable.render.number(',', '.', 0, ''), orderable:false },
            { data: 'total_panjang', name: 'total_panjang', className: "text-right", render: $.fn.dataTable.render.number(',', '.', 0, ''), orderable:false }
        ],
        initComplete: function(settings, json) {
            
        },
    });

}

function populateTableDetailKKA(date, shift, mill, mach, id)
{

    var txtHour = $('#dtHour').val();

    var dataTable = $('#OverviewShiftDetailKKA').DataTable({
        destroy: true,
        "bFilter": false,
        "bLengthChange": false,
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        pageLength: 20,
        // scrollX: true,
        "order": [[ 0, "desc" ]],
        ajax: {
            url:'{!!url("DataPerShiftDetailKKA")!!}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                '_token': '{{ csrf_token() }}',
                'txtDate': date,
                'txtHour': txtHour,
                'txtShift': shift,
                'txtMill': mill,
                'txtMach': mach,
                'txtMachId': id
            }
        },
        columns: [
            { data: 'shift', name: 'shift', orderable:false },
            { data: 'lembar', name: 'lembar', className: "text-right", render: $.fn.dataTable.render.number(',', '.', 0, ''), orderable:false },
            { data: 'panjang', name: 'panjang', className: "text-right", render: $.fn.dataTable.render.number(',', '.', 0, ''), orderable:false },
            { data: 'totalPanjang', name: 'totalPanjang', className: "text-right", render: $.fn.dataTable.render.number(',', '.', 0, ''), orderable:false }
        ],
        initComplete: function(settings, json) {
            
        },
    });

}


</script>

@endsection
{{-- Content Page JS End--}}
