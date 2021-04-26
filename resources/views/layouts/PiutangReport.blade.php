@extends('main')

{{-- Content Page CSS Begin--}}
@section('contentcss')

<link href="{{ asset('outside/plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.4/css/responsive.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/select2/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('outside/assets/css/widgets/modules-widgets.css') }}"> 
<style>
.widget-content-area {
  box-shadow: none !important; }

.badge {
  background: transparent; }

.badge-primary {
  color: #1b55e2; 
  border: 1px dashed #1b55e2;  }

.badge-warning {
  color: #e2a03f; 
  border: 1px dashed #e2a03f;   }

.badge-danger {
  color: #e7515a;
  border: 1px dashed #e7515a;  }

.badge-success {
  color: #8dbf42;
  border: 1px dashed #8dbf42;  }

.badge-info {
  color: #2196f3; 
  border: 1px dashed #2196f3;  }


.modal-content {
  border: none;
  box-shadow: 0px 0px 15px 1px rgba(113, 106, 202, 0.2); }
  .modal-content .modal-footer {
    border-top: none; }
    .modal-content .modal-footer [data-dismiss="modal"] {
      background-color: #fff;
      color: #1b55e2;
      font-weight: 700;
      border: 1px solid #e8e8e8;
      padding: 10px 25px; }
    .modal-content .modal-footer .btn[data-dismiss="modal"] svg {
      margin-right: 5px;
      width: 18px;
      vertical-align: bottom; }
    .modal-content .modal-footer #btn-n-add {
      background-color: #1b55e2;
      color: #fff;
      font-weight: 600;
      border: 1px solid #1b55e2;
      padding: 10px 25px; }
    .modal-content .modal-footer #btn-n-save {
      font-weight: 600;
      padding: 10px 25px; }

.modal-backdrop {
  background-color: #ebedf2; }

.modal-content svg.close {
  position: absolute;
  right: 15px;
  top: 10px;
  font-size: 12px;
  font-weight: 600;
  padding: 3px;
  background: #fff;
  border-radius: 5px;
  opacity: 1;
  box-shadow: 0 6px 10px 0 rgba(0, 0, 0, 0.14), 0 1px 18px 0 rgba(0, 0, 0, 0.12), 0 3px 5px -1px rgba(0, 0, 0, 0.2);
  cursor: pointer;
  transition: .600s;
  color: #3b3f5c; }

@media (max-width: 991px) {
    
    .table > tbody > tr > td {
        font-size: 11px;
    }

    .table > thead > tr > th {
        font-size: 11px;
    }

    div.dataTables_wrapper div.dataTables_info {
        font-size: 11px; 
    }

    .widget-account-invoice-one .invoice-box [class*="info-detail-"]:not(.info-sub) p {
        margin-bottom: 13px;
        font-weight: 700;
        font-size: 11px;
    }

    .widget-account-invoice-one .invoice-box .acc-amount {
        text-align: center;
        font-size: 19px;
        font-weight: 700;
        margin-bottom: 0;
        color: #009688;
    }

    .widget-account-invoice-one .invoice-box h5 {
        text-align: center;
        font-size: 19px;
        letter-spacing: 1px;
        margin-bottom: 10px;
        color: #1b55e2;
    }
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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('Piutang') }}">Accounts Receivable</a></li>
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
                                <h4>Accounts Receivable Report</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content-area">

                        <div class="form-row mb-6">
                            <div class="form-group col-md-4">
                                <label class="text-dark" for="txtCustomer">Choose Customer</label>
                                <select class="form-control basic" name="txtCustomer" id="txtCustomer">
                                    <option></option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="text-dark" for="txtCustomer">Choose Salesman</label>
                                <div id="txtSalesLoading">
                                    <select class="form-control basic" name="txtSalesman" id="txtSalesman">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="text-dark" for="txtFlag">Paid Flag</label>
                                <select class="form-control basic" name="txtFlag" id="txtFlag">
                                    <option></option>
                                    <option value='All'>All</option>
                                    <option value='Y'>Y</option>
                                    <option value='N'>N</option>
                                </select>
                            </div>
                        </div>
    
                        <div class="form-row mb-6">
                            <div class="form-group col-md-5">
                                <label class="text-dark" for="txtStartDate">Start Date</label>
                                <span class="badge badge-info" id="spanStartDate">byInvoiceDate</span>
                                <input id="txtStartDate" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select start date">
                            </div>
                            <div class="form-group col-md-5">
                                <label class="text-dark" for="txtEndDate">End Date</label>
                                <span class="badge badge-info" id="spanEndDate">byInvoiceDate</span>
                                <input id="txtEndDate" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select end date">
                            </div>
                        </div>
                      
                        <div class="custom-control custom-radio">
                            <input type="radio" id="byInvoiceDate" name="dateBy" value="byInvoiceDate" class="custom-control-input" checked>
                            <label class="custom-control-label" for="byInvoiceDate">by Invoice Date</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="byDueDate" name="dateBy" value ="byDueDate" class="custom-control-input">
                            <label class="custom-control-label" for="byDueDate">by Due Date</label>
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

            <div class="col-lg-12 layout-spacing layout-spacing" id="divResult" style="display: none">
				<div class="statbox widget box box-shadow">
					<div class="widget-content widget-content-area">

                        <div class="widget-account-invoice-one">
                        
                            <div class="widget-content">
                                <div class="invoice-box">
                                    
                                    <div class="acc-total-info">
                                        <h5>Unpaid Accounts Receivable</h5>
                                        <p class="acc-amount" id="TotalAccountsReceivable"></p>
                                    </div>
        
                                    <div class="inv-detail">      
                                        <div class="info-detail-1">
                                            <p>Total Invoices</p>
                                            <p id="TotalInvoices"></p>
                                        </div>                                  
                                        <div class="info-detail-1">
                                            <p>Total Billing</p>
                                            <p id="TotalBilling"></p>
                                        </div>
                                        <div class="info-detail-1">
                                            <p>Total Paid</p>
                                            <p id="TotalPaid"></p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table mb-4" style="width:100%" id="SummaryPiutang">
                              <thead>
                                  <tr>
                                      <th>Total Inv.</th>
                                      <th>Cust. ID</th>
                                      <th>Cust. Name</th>
                                      <th>Paid Off</th>
                                      <th>Amt. Billing</th>
                                      <th>Amt. Paid</th>
                                      <th>Amt. Unpaid</th>
                                      <th>Detail</th>
                                  </tr>
                              </thead>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            
            

        </div>
    </div>


    <div class="modal fade" id="detail" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="header"></h6>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="modal"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </div>
                <div class="modal-body">
            
                    <table id="OverviewPiutang" class="table mb-4" style="width:100%">
                        <thead>
                            <tr>
                                <th>Cust. Id</th>
                                <th>Cust. Name</th>
                                <th>Paid Off</th>
                                <th>Salesman</th>
                                <th>Invoice</th>
                                <th>OrderNo</th>
                                <th>Inv. Date</th>
                                <th>Due. Date</th>
                                <th>Inv. Amt</th>
                                <th>Disc</th>
                                <th>Receipt</th>
                                <th>Billing</th>
                                <th>Amt. Paid</th>
                                <th>Amt. Unpaid</th>
                                <th>Office</th>
                                <th>Region</th>
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
<script src="{{ asset('outside/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('outside/plugins/blockui/jquery.blockUI.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js" integrity="sha512-lOtDAY9KMT1WH9Fx6JSuZLHxjC8wmIBxsNFL6gJPaG7sLIVoSO9yCraWOwqLLX+txsOw0h2cHvcUJlJPvMlotw==" crossorigin="anonymous"></script>

<script type="text/javascript">

var selectedValue, txtCustomer, txtSalesman, txtFlag, txtStartDate, txtEndDate, allreq; 

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

function listSalesman(){
    var block = $('#txtSalesLoading');
    blockElement(block);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('getSalesman')}}",
        success: function (data) {
            $(block).unblock()
            $('select[name="txtSalesman"]').empty();
            $('select[name="txtSalesman"]').prepend('<option></option>');
            $.each(data, function(index, element) {
            $('select[name="txtSalesman"]').append('<option value="'+element.SalesId+'">'+element.NamaSales+'</option>');
            });
        }
    });

    $('#txtSalesman').select2({
        placeholder: 'Choose Sales below',
        allowClear: true
    });

}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function getAllSummary(a){

    $.ajax({
        type: "POST",
        dataType: "json",
        url:'{!!url("getAllSummaryPiutang")!!}'+'?'+a,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function (data) {

            if (data['error']) {
                swal("Error", (data['error']) , "error");
            } else {

                $.each(data, function(index, element) {

                    $('#TotalInvoices').text(numberWithCommas(Math.round(element.total_faktur))+" invoices")
                    $('#TotalAccountsReceivable').text('IDR. '+numberWithCommas(Math.round(element.total_piutang)))
                    $('#TotalBilling').text('IDR. '+ numberWithCommas(Math.round(element.total_tagihan)))
                    $('#TotalPaid').text('IDR. '+ numberWithCommas(Math.round(element.total_bayar)))
                                
                });

                
            }
                        
        }
    });
}

function getTable1 (a, b){
    var dataTable = $(a).DataTable({
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
            'url':'{!!url("getSummaryPiutang")!!}'+'?'+b,
            'type': 'post',
            'headers': {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        columns: [

                {data: 'total_faktur', name: 'total_faktur', render: $.fn.dataTable.render.number(',', '.', 0, '')},
                {data: 'CustomerId', name: 'CustomerId'},
                {data: 'NamaCustomer', name: 'NamaCustomer'},
                {data: 'Pelunasan', name: 'Pelunasan'},
                {data: 'total_tagihan', name: 'total_tagihan', render: $.fn.dataTable.render.number(',', '.', 0, 'IDR. ')},
                {data: 'total_bayar', name: 'total_bayar', render: $.fn.dataTable.render.number(',', '.', 0, 'IDR. ')},
                {data: 'total_piutang', name: 'total_piutang', render: $.fn.dataTable.render.number(',', '.', 0, 'IDR. ')},
                {data: 'Detail', name: 'Detail',orderable:false,searchable:false}
        ],
        initComplete: function(settings, json) {
            if (dataTable.rows().data().length) {
                $.unblockUI();
                divResult.style.display = 'block';

                $('html, body').animate({
                    scrollTop: $("#divResult").offset().top
                }, 1200);
            
            }
            if (!dataTable.rows().data().length) {
                swal("Oops! :(", "Data not available", "error");
                $.unblockUI();
                divResult.style.display = 'block';

                $('html, body').animate({
                    scrollTop: $("#divResult").offset().top
                }, 1200);
                
            }
        },
    });
}

function getTable2 (a, b){
    var dataTable = $(a).DataTable({
        "oLanguage": {

                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search",
                "sLengthMenu": "Show :  _MENU_ entries",
        },
        stripeClasses: [],
        lengthMenu: [5, 10, 20, 50],
        pageLength: 3,
        destroy : true,
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            'url':'{!!url("getOverviewPiutang")!!}'+'?'+b,
            'type': 'post',
            'headers': {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        columns: [
                {data: 'CustomerId', name: 'CustomerId'},
                {data: 'NamaCustomer', name: 'NamaCustomer'},
                {data: 'Pelunasan', name: 'Pelunasan'},
                {data: 'NamaSales', name: 'NamaSales'},
                {data: 'faktur', name: 'faktur'},
                {data: 'CustomerOrderNo', name: 'CustomerOrderNo'},
                {data: 'tglfaktur', name: 'tglfaktur'},
                {data: 'TglJTempo', name: 'TglJTempo'},
                {data: 'NominalFaktur', name: 'NominalFaktur', render: $.fn.dataTable.render.number(',', '.', 0, 'IDR. ')},
                {data: 'Discount', name: 'Discount', render: $.fn.dataTable.render.number(',', '.', 0, 'IDR. ')},
                {data: 'kwitansi', name: 'kwitansi', render: $.fn.dataTable.render.number(',', '.', 0, 'IDR. ')},
                {data: 'tagihan', name: 'tagihan', render: $.fn.dataTable.render.number(',', '.', 0, 'IDR. ')},
                {data: 'bayar', name: 'bayar', render: $.fn.dataTable.render.number(',', '.', 0, 'IDR. ')},
                {data: 'piutang', name: 'piutang', render: $.fn.dataTable.render.number(',', '.', 0, 'IDR. ')},
                {data: 'office', name: 'office'},
                {data: 'region', name: 'region'},
        ],
        initComplete: function(settings, json) {
            if (dataTable.rows().data().length) {
                $.unblockUI();
            }
            if (!dataTable.rows().data().length) {
                swal("Oops! :(", "Data not available", "error");
                $.unblockUI();
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
    $('#Piutang').addClass('active');

    var divResult = document.getElementById("divResult");

    listSalesman();

    $('#txtFlag').select2({
        placeholder: 'Choose Paid Flag below',
        allowClear: true
    });

    $('input[type=radio][name=dateBy]').change(function() {
        if (this.value == 'byInvoiceDate') {
            document.getElementById("spanStartDate").textContent="byInvoiceDate";
            document.getElementById("spanEndDate").textContent="byInvoiceDate";
        }
        else  {
            document.getElementById("spanStartDate").textContent="byDueDate";
            document.getElementById("spanEndDate").textContent="byDueDate";
        }
    });

    var f1 = flatpickr(document.getElementById('txtStartDate'), {
            dateFormat: "Ymd",
            disableMobile: "true",
    });

    var f2 = flatpickr(document.getElementById('txtEndDate'), {
            dateFormat: "Ymd",
            disableMobile: "true",
    });

    $("#txtCustomer").select2({
        placeholder: "Type any existing Customer ID or Customer Name...",
        allowClear: true,
        minimumInputLength: 3,
        ajax: {
            url: "{{ url('searchCustomer') }}",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
            return {
                results:  $.map(data, function (item) {
                return {
                    text: item.CustomerId + " || " + item.NamaCustomer,
                    id: item.CustomerId
                }
                })
            };
            
            },
            cache: true
        }
    });

    $('#go').on('click', function() {

        event.preventDefault();

        var rbs = document.querySelectorAll('input[name="dateBy"]');
        for (const rb of rbs) {
            if (rb.checked) {
                selectedValue = rb.value;
                break;
            }
        }
        txtCustomer = $("#txtCustomer").val();  
        txtSalesman = $("#txtSalesman").val(); 
        txtFlag = $("#txtFlag").val();
        txtStartDate = $("#txtStartDate").val();
        txtEndDate = $('#txtEndDate').val();
        allreq = '';

        if (!txtStartDate && !txtEndDate) {
            
            const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-danger mr-3',
            buttonsStyling: false,
            })

            swalWithBootstrapButtons({
                title: 'Are you sure, w/ adding any date?',
                text: "It will search a whole's data's",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sure, go ahead',
                cancelButtonText: 'Nope',
                reverseButtons: true,
                padding: '2em'
            }).then(function(result) {
                    if (result.value) {

                        blockUI();

                        if (txtCustomer){

                            allreq = allreq+'&txtCustomer='+txtCustomer.trim();
                        }

                        if (txtSalesman){

                            allreq = allreq+'&txtSalesman='+txtSalesman.trim();
                        }

                        if (txtFlag){

                            allreq = allreq+'&txtFlag='+txtFlag.trim();
                        }

                        if (selectedValue){

                            allreq = allreq+'&dateBy='+selectedValue.trim();
                        }

                        var a = '#SummaryPiutang';

                        getTable1(a, allreq);

                        getAllSummary(allreq);
                        

                    } else if (result.dismiss === swal.DismissReason.cancel) {
                        swalWithBootstrapButtons(
                            "Search data",
                            "Canceled",
                            "error"
                        )
                    }
                })
        }

        else {

            blockUI();

            if (txtCustomer){

                allreq = allreq+'&txtCustomer='+txtCustomer.trim();
            }

            if (txtSalesman){

                allreq = allreq+'&txtSalesman='+txtSalesman.trim();
            }

            if (txtFlag){

                allreq = allreq+'&txtFlag='+txtFlag.trim();
            }

            if (selectedValue){

                allreq = allreq+'&dateBy='+selectedValue.trim();
            }

            if (txtStartDate && !txtEndDate){

                allreq = allreq+'&txtStartDate='+txtStartDate.trim();
            }

            if (!txtStartDate && txtEndDate){

                allreq = allreq+'&txtEndDate='+txtEndDate.trim();
            }

            if (txtStartDate && txtEndDate){

                allreq = allreq+'&txtStartDate='+txtStartDate.trim();
                allreq = allreq+'&txtEndDate='+txtEndDate.trim();
            }

            var a = '#SummaryPiutang';

            getTable1(a, allreq);

            getAllSummary(allreq);


        }


    });

    $('#reset').on('click', function() {

        $('#txtCustomer').val(null).trigger('change');
        $('#txtSalesman').val(null).trigger('change');
        $('#txtFlag').val(null).trigger('change');
        f1.clear();
        f2.clear();
        divResult.style.display="none";
   
    });

    $('body').on('click', '.detail', function(e) {

        id = $(this).data('id1');
        id2 = $(this).data('id2');

        document.getElementById("header").textContent="Detail of "+id2;

        allreq = '';

        //blockUI();

        if (id){

            allreq = allreq+'&txtCustomer='+id.trim();
        }

        if (txtSalesman){

            allreq = allreq+'&txtSalesman='+txtSalesman.trim();
        }

        if (txtFlag){

            allreq = allreq+'&txtFlag='+txtFlag.trim();
        }

        if (selectedValue){

            allreq = allreq+'&dateBy='+selectedValue.trim();
        }

        if (txtStartDate && !txtEndDate){

            allreq = allreq+'&txtStartDate='+txtStartDate.trim();
        }

        if (!txtStartDate && txtEndDate){

            allreq = allreq+'&txtEndDate='+txtEndDate.trim();
        }

        if (txtStartDate && txtEndDate){

            allreq = allreq+'&txtStartDate='+txtStartDate.trim();
            allreq = allreq+'&txtEndDate='+txtEndDate.trim();
        }

        var a = '#OverviewPiutang';

        getTable2(a, allreq);

        // alert(allreq);


    });

    

});





</script>

@endsection
{{-- Content Page JS End--}}
