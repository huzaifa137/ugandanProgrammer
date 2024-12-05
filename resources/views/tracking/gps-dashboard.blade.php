@extends('layouts.master')
@section('css')
    <!---jvectormap css-->
    <link href="{{ URL::asset('assets/plugins/jvectormap/jqvmap.css') }}" rel="stylesheet" />
    <!-- Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <!--Daterangepicker css-->
    <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
		<div class="page-leftheader">
			<h4 class="page-title">GPS Dashboard</h4>
		</div>
	</div>	
    <!--End Page header-->
@endsection
@section('content')
    <!-- Row -->


    <div class="row">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="row">
                <!-- Tracking Links -->
                <div class="col-xl-4 col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Link for Tracking Links -->
                            <a href="{{ url('/tracking/generate-link') }}" >
                                <i class="fas fa-link card-custom-icon text-info icon-dropshadow-info" style="font-size: 36px;"></i>
                                <h2 class="mb-1">Tracking Links</h2>
                                <h4 class="mb-1">0</h4>
                                <div class="progress progress-sm mt-3 bg-info-transparent">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" style="width: 100%"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Active Links -->
                <div class="col-xl-4 col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Link for Active Links -->
                            <a href="https://example.com/active-links" >
                                <i class="fas fa-check-circle card-custom-icon text-success icon-dropshadow-success" style="font-size: 36px;"></i>
                                <h2 class="mb-1">Active Links</h2>
                                <h4 class="mb-1">0</h4>
                                <div class="progress progress-sm mt-3 bg-success-transparent">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: 100%"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- De-activated Links -->
                <div class="col-xl-4 col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Link for De-activated Links -->
                            <a href="https://example.com/deactivated-links" >
                                <i class="fas fa-times-circle card-custom-icon text-danger icon-dropshadow-danger" style="font-size: 36px;"></i>
                                <h2 class="mb-1">De-activated Links</h2>
                                <h4 class="mb-1">0</h4>
                                <div class="progress progress-sm mt-3 bg-danger-transparent">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" style="width: 100%"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

    </div>


    </div>
    </div><!-- end app-content-->
    </div>
@endsection
@section('js')
    <!-- ECharts js -->
    <script src="{{ URL::asset('assets/plugins/echarts/echarts.js') }}"></script>
    <!-- Peitychart js-->
    <script src="{{ URL::asset('assets/plugins/peitychart/jquery.peity.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/peitychart/peitychart.init.js') }}"></script>
    <!-- Apexchart js-->
    <script src="{{ URL::asset('assets/js/apexcharts.js') }}"></script>
    <!--Moment js-->
    <script src="{{ URL::asset('assets/plugins/moment/moment.js') }}"></script>
    <!-- Daterangepicker js-->
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/js/daterange.js') }}"></script>
    <!---jvectormap js-->
    <script src="{{ URL::asset('assets/plugins/jvectormap/jquery.vmap.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jvectormap/jquery.vmap.world.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jvectormap/jquery.vmap.sampledata.js') }}"></script>
    <!-- P-scroll js-->
    <script src="{{ URL::asset('assets/plugins/p-scrollbar/p-scrollbar.js') }}"></script>
    <!-- Index js-->
    <script src="{{ URL::asset('assets/js/index1.js') }}"></script>
    <!-- Data tables js-->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/datatables.js') }}"></script>
    <!--Counters -->
    <script src="{{ URL::asset('assets/plugins/counters/counterup.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/counters/waypoints.min.js') }}"></script>
    <!--Chart js -->
    <script src="{{ URL::asset('assets/plugins/chart/chart.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart/utils.js') }}"></script>
@endsection
