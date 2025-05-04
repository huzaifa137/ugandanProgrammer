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
            <h4 class="page-title">Quizzes and Assignments</h4>
        </div>
    </div>
    <!--End Page header-->
@endsection
@section('content')
    <!-- Row -->

    <div class="row">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="row">
                <!-- Quizzes Card -->
                <div class="col-xl-6 col-lg-6 col-md-12">
                    {{-- <a href="{{ url('/quiz/create-quiz') }}" class="text-decoration-none"> --}}
                        <a href="{{ url('/quiz/all-quizzes') }}" class="text-decoration-none">
                        <div class="card">
                            <div class="card-body">
                                <svg class="card-custom-icon text-primary icon-dropshadow-primary" viewBox="0 0 24 24">
                                    <path
                                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z">
                                    </path>
                                </svg>
                                <p class="mb-1">Quizzes</p>
                                <h2 class="mb-1 font-weight-bold">1,257</h2>
                                <div class="progress progress-sm mt-3 bg-primary-transparent">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                        style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Assignments Card -->
                <div class="col-xl-6 col-lg-6 col-md-12">
                    {{-- <a href="{{ url('/assignments/create-assignment') }}" class="text-decoration-none"> --}}
                        <a href="{{ url('/assignments/create-assignment') }}" class="text-decoration-none">
                        <div class="card">
                            <div class="card-body">
                                <svg class="card-custom-icon text-success icon-dropshadow-success" viewBox="0 0 24 24">
                                    <path
                                        d="M16 0H8c-1.1 0-1.99.89-1.99 1.99L6 22.01c0 1.1.89 1.99 1.99 1.99h8c1.1 0 1.99-.89 1.99-1.99L18 1.99c0-1.1-.89-1.99-1.99-1.99zm0 18H8V4h8v14z">
                                    </path>
                                </svg>
                                <p class="mb-1">Assignments</p>
                                <h2 class="mb-1 font-weight-bold">3,205</h2>
                                <div class="progress progress-sm mt-3 bg-success-transparent">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                    </a>
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
