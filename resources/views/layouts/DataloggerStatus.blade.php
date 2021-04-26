@extends('main')

{{-- Content Page CSS Begin--}}
@section('contentcss')

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
                                <h4>Production Monitor</h4>
                            </div>
                        </div>
                    </div>
                    
                    <div class="widget-content widget-content-area">
                        <div class="row" id="summary-container">

                            

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

<script src="https://svr01.kencana.org/plc/bundles/moment?v=crdu6Cn9XFv86IaJoeVC22xmnSV8bTOYkliZEW2O16c1"></script>

<script type="text/javascript">

window.setInterval(function(){
    loadData();
}, 10000);

$(document).ready(function() {

    $('#homeNav').attr('data-active','false');
    $('#homeNav').attr('aria-expanded','false');
    $('#DataLoggerNav').attr('data-active','true');
    $('#DataLoggerNav').attr('aria-expanded','true');
    $('.DataLoggerTreeView').addClass('show');
    $('#DataloggerStatus').addClass('active');

    loadData();

});

function loadData() {

    $.ajax({
        url: "{{ url('DataloggerLiveStatus') }}",
        method: "GET",
        success: function (data) {

            // console.log(data);
           

            var dataLog = "";

            $.each(data, function(i) {

                dataLog = dataLog + "<div class=\"col-12 col-sm-6 col-md-6 col-lg-2 m-0 p-0\">";
                if(data[i].Kondisi == "Mesin Hidup") {
                    dataLog = dataLog + "<div class=\"card bg-success text-white\" style=\" margin: 4px 4px;\">";
                }
                else {
                    dataLog = dataLog + "<div class=\"card bg-danger text-white\" style=\" margin: 4px 4px;\">";
                }
                dataLog = dataLog + "<div class=\"card-body text-white\">"
                    + "<h5 class=\"card-title text-white\">" +  data[i].Lokasi + "</h5>"
                    + "<h5 class=\"card-title text-white\">" + data[i].Description + " " + "Machine: " + data[i].Id + "</h5> <hr />"
                    + "<p class=\"card-text text-white\">"
                    + "Date : " + data[i].Tanggal + "<br />"
                    // + "Lokasi: " + data[i].Lokasi + "<br/>"
                    + "Last cut: " + data[i].Length + " mm<br/>"
                    + "Status : " + data[i].Proses
                    + "</p > "
                    + "</div > "
                    + "</div>"
                    + "</div>";

                $("#summary-container").html(dataLog);

            });
            
            
        }
    });

}

</script>


@endsection
{{-- Content Page JS End--}}
