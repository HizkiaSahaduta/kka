@extends('main')

{{-- Content Page CSS Begin--}}
@section('contentcss')
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.4/css/responsive.dataTables.min.css" />
<link href="{{ asset('outside/plugins/notification/snackbar/snackbar.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('outside/plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('outside/fa/css/font-awesome.min.css') }}">
<link href="{{ asset('outside/assets/css/elements/tooltip.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('outside/assets/css/components/custom-modal.css') }}" rel="stylesheet" type="text/css" />
<style>
.widget-content-area {
  box-shadow: none !important; }

#DNHdr .badge {
  background: transparent; }

#DNHdr .badge-primary {
  color: #1b55e2;
  border: 2px dashed #1b55e2; }

#DNHdr .badge-warning {
  color: #e2a03f;
  border: 2px dashed #e2a03f; }

#DNHdr .badge-danger {
  color: #e7515a;
  border: 2px dashed #e7515a; }

#DNHdr .badge-success {
  color: #8dbf42;
  border: 2px dashed #8dbf42; }

#DNHdr .badge-info {
  color: #2196f3;
  border: 2px dashed #2196f3; }


td.details-control {
    background: url("{{ asset('img/etc/details_open.png') }}") no-repeat center center;
    cursor: pointer;
}
tr.shown td.details-control {
    background: url("{{ asset('img/etc/details_close.png') }}") no-repeat center center;
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
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Delivery Note</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('DNConfirm') }}">P.O Confirm</a></li>
                        </ol>
                    </nav>
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

        <div class="col-lg-12 col-md-12 layout-spacing" id="satu">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Form of Delivery Note Confirm</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">

                    <div class="form-row mb-6">
                        <div class="form-group col-md-5">
                            <label for="po_id">P.O Number</label>
                            <input id="po_id" type="text" placeholder="P.O Number goes here" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="flag">Status Confirm</label>
                            <select class="form-control" id='flag'>
				                <option value='O' selected>Open</option>
                                <option value='Y'>Confirmed</option>
                                <option value='All'>All</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row mb-6">
                        <div class="form-group col-md-5">
                            <label for="start">Start Date (ShipDate)</label>
                            <input id="start" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select start date">
                        </div>
                        <div class="form-group col-md-5">
                            <label for="end">End Date (ShipDate)</label>
                            <input id="end" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select end date">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success mt-4" id="reset">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                        &nbsp;Reset
                    </button>

                    <button type="submit" class="btn btn-primary mt-4" id="search_po">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        &nbsp;Search
                    </button>

                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 layout-spacing" id="dua" style="visibility: hidden">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Your Search Result :</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">
                    <div class="table-responsive">
                        <table id="DNHdr" class="table mb-4" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Deliv ID</th>
                                    <th>Status</th>
                                    <th>Order ID</th>
                                    <th>Receiver</th>
                                    <th>ShipDate</th>
                                    <th>Dt.Confirm</th>
                                    <th>Action</th>
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
<div class="modal fade" id="detailDN" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="modalLoad">
            <div class="modal-header">
                <h5 class="modal-title" id="headerModal"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">

                <table id="DNDtl" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Item.Num</th>
                            <th>Descr</th>
                            <th>Qty</th>

                        </tr>
                    </thead>
                </table>

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
<script src="{{ asset('outside/plugins/blockui/jquery.blockUI.min.js') }}"></script>

@if(isset($success))
    <script>
        var success = "{!! $success !!}"
        const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1000,
            padding: '2em'
        });

        toast({
            type: 'success',
            title: success,
            padding: '2em',
        })

    </script>
@endif

@if(isset($error))
    <script>
        var error = '{!! $error !!}'
        swal("Whoops", error, "error");
    </script>
@endif

<script>
var deliv_id;
var order_id;


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

$(document).ready(function() {

    var dua = document.getElementById("dua");
    var block = $('#modalLoad');

    $('#homeNav').attr('data-active','false');
    $('#homeNav').attr('aria-expanded','false');
    $('#ConfirmationNav').attr('data-active','true');
    $('#ConfirmationNav').attr('aria-expanded','true');
    $('.ConfirmationTreeView').addClass('show');
    $('#DNConfirm').addClass('active');

    var f1 = flatpickr(document.getElementById('start'), {
        dateFormat: "Ymd",
        disableMobile: "true",
    });

    var f2 = flatpickr(document.getElementById('end'), {
        dateFormat: "Ymd",
        disableMobile: "true",
    });


    $('#search_po').on('click', function() {

        event.preventDefault();

        var a = document.getElementById("flag");
        var flag = a.options[a.selectedIndex].value;
        // var po_id = $("#po_id").val();
        var dt_start = $("#start").val();
        var dt_end = $("#end").val();
        var po_id = $("#po_id").val();
        var allreq = '';

        if ((dt_start == '' && dt_end == '') || (dt_start == null && dt_end == null)){

            const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-primary',
                cancelButtonClass: 'btn btn-danger mr-3',
                buttonsStyling: false,
            })

            swalWithBootstrapButtons({
                title: 'Are you sure?',
                text: "If you wanna search without adding any date, it will searching whole data's and maybe will take a long time to be completed.",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sure, go ahead',
                cancelButtonText: 'Nope',
                reverseButtons: true,
                padding: '2em'
            }).then(function(result) {
                if (result.value) {

                    if (flag != "All"){

                        allreq = allreq+'&flag='+flag.trim();
                    }

                    if (po_id){

                        allreq = allreq+'&po_id='+po_id.trim();
                    }

                    blockUI();

                    var dataTable = $('#DNHdr').DataTable({
                        "oLanguage": {
                            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                            "sInfo": "Showing page _PAGE_ of _PAGES_",
                            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                            "sSearchPlaceholder": "Search...",
                            "sLengthMenu": "Show :  _MENU_ entries",
                        },
                        "drawCallback": function( settings ) {
                            $('.bs-tooltip').tooltip();
                        },
                        stripeClasses: [],
                        lengthMenu: [5, 10, 20, 50],
                        pageLength: 5,
                        destroy : true,
                        responsive: true,
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        ajax: {
                            'url':'{!!url("getDNHdr")!!}'+'?a=a'+allreq,
                            'type': 'post',
                            'headers': {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        },
                        columns: [
                        {data: 'deliv_id', name: 'deliv_id'},
                        {data: 'stat', name: 'stat'},
                        {data: 'order_id', name: 'order_id'},
                        {data: 'receiver', name: 'receiver'},
                        {data: 'ship_date', name: 'ship_date'},
                        {data: 'dt_confirm1', name: 'dt_confirm1'},
                        {data: 'Detail', name: 'Detail',orderable:false,searchable:false}
                        ],
                        initComplete: function(settings, json) {
                            if (dataTable.rows().data().length) {


                                $.unblockUI();

                                swal("Success", "Data retrieved", "success");

                                dua.style.visibility = 'visible';
                                $('html, body').animate({
                                    scrollTop: $("#dua").offset().top
                                }, 1200);


                            }
                            if (!dataTable.rows().data().length) {

                                $.unblockUI();

                                swal("Whops", "Data not available", "error");

                                dua.style.visibility = 'visible';
                                $('html, body').animate({
                                    scrollTop: $("#dua").offset().top
                                }, 1200);


                            }
                        },
                    });

                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swalWithBootstrapButtons(
                        "Cancelled",
                        "Cancel searching for whole data's",
                        "error"
                    )
                }
            })
        }

        else {

            if (po_id){

                allreq = allreq+'&po_id='+po_id.trim();
            }

            if (flag != "All"){

                allreq = allreq+'&flag='+flag.trim();
            }

            if (dt_start && !dt_end){

                allreq = allreq+'&dt_start='+dt_start.trim();
            }

            if (!dt_start && dt_end){

                allreq = allreq+'&dt_end='+dt_end.trim();
            }

            if (dt_start && dt_end){

                allreq = allreq+'&dt_start='+dt_start.trim();
                allreq = allreq+'&dt_end='+dt_end.trim();
            }

            blockUI();

            var dataTable = $('#DNHdr').DataTable({
                "oLanguage": {
                        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                        "sInfo": "Showing page _PAGE_ of _PAGES_",
                        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                        "sSearchPlaceholder": "Search",
                        "sLengthMenu": "Show :  _MENU_ entries",
                },
                "drawCallback": function( settings ) {
                    $('.bs-tooltip').tooltip();
                },
                stripeClasses: [],
                lengthMenu: [5, 10, 20, 50],
                pageLength: 5,
                destroy : true,
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax:{
                        'url':'{!!url("getDNHdr")!!}'+'?a=a'+allreq,
                        'type': 'post',
                        'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                {data: 'deliv_id', name: 'deliv_id'},
                {data: 'order_id', name: 'order_id'},
                {data: 'stat', name: 'stat'},
                {data: 'receiver', name: 'receiver'},
                {data: 'ship_date', name: 'ship_date'},
                {data: 'dt_confirm1', name: 'dt_confirm1'},
                {data: 'Detail', name: 'Detail',orderable:false,searchable:false}
                ],
                    initComplete: function(settings, json) {
                        if (dataTable.rows().data().length) {

                            $.unblockUI();

                            swal("Success", "Data retrieved", "success");

                            dua.style.visibility = 'visible';
                            $('html, body').animate({
                                scrollTop: $("#dua").offset().top
                            }, 1200);

                        }
                        if (!dataTable.rows().data().length) {

                           $.unblockUI();

                           swal("Whops", "Data not available", "error");

                            dua.style.visibility = 'visible';
                            $('html, body').animate({
                                scrollTop: $("#dua").offset().top
                            }, 1200);


                        }
                    },
            });

        }

    });

    $('#reset').on('click', function() {

        $('#start').val('');
        $('#end').val('');
        $('#flag').val('O').change();
    });

    $('body').on('click', '.viewDelivDtl', function(e) {


        deliv_id = $(this).data('id1');
        order_id = $(this).data('id2');
        var title = "<h5 class='modal-title'>Detail Item of "+deliv_id+"</h5>";
        $('#headerModal').html(title);

        $(block).block({
            centerY: false,
            centerX: false,
            message: '<span class="text-semibold"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin position-left"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg></i>&nbsp; Loading</span>',
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.8,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: '10px 15px',
                color: '#fff',
                width: 'auto',
                '-webkit-border-radius': 2,
                '-moz-border-radius': 2,
                backgroundColor: '#0e1726'
            }
        });

        var load = $('#DNDtl').DataTable().ajax.url('getDNDtl?deliv_id='+deliv_id+'&order_id='+order_id).load();

    });

    $('body').on('click', '.setDelivConfirm', function(e) {


        deliv_id = $(this).data('id1');
        order_id = $(this).data('id2');

        const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-danger mr-3',
            buttonsStyling: false,
        })

        swalWithBootstrapButtons({
                title: 'Are you sure?',
                text: "Confirm Delivery #"+deliv_id,
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sure, go ahead',
                cancelButtonText: 'Nope',
                reverseButtons: true,
                padding: '2em'
            }).then(function(result) {
                if (result.value) {

                    $.ajax({
                    url: "{{ url('setDelivConfirm') }}",
                    method: 'POST',
                    data: {
                        deliv_id: deliv_id,
                        order_id: order_id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                        success: function(data) {

                            var response = data['response'];

                            if(response.indexOf('Failed')>-1){

                                swal("Whops", response, "error")
                                $('#DNHdr').DataTable().ajax.reload();
                            }
                            else{

                                swal("Success", response, "success")
                                $('#DNHdr').DataTable().ajax.reload();

                            }

                        }
                    });

                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swalWithBootstrapButtons(
                        "Cancelled",
                        "Cancel confirm",
                        "error"
                    )
                }
            })



    });



    var table = $('#DNDtl').DataTable({
        "oLanguage": {
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search",
        },
        "drawCallback": function(settings) {
            $(block).unblock();
        },
        stripeClasses: [],
        paging: false,
        destroy : true,
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        info: false,
        ajax: {
            'url': '{!!url("getDNDtl")!!}' + '?deliv_id=' + deliv_id + '&order_id=' +order_id,
            'type': 'post',
            'headers': {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        columns: [
            {
                data: 'item_num',
                name: 'item_num'
            },
            {
                data: 'descr',
                name: 'descr'
            },
            {

                data: 'qty_ship',
                name: 'qty_ship',
                render: $.fn.dataTable.render.number( ',', '.', 2, '')

            },
        ]
    });



});


</script>

@endsection
{{-- Content Page JS End--}}
