<?php
use App\Http\Controllers\Helper;
use App\Http\Controllers\Controller;
$controller = new Controller();
?>
@extends('layouts-side-bar.master')
@section('css')
    <!---jvectormap css-->
    <link href="{{ URL::asset('assets/plugins/jvectormap/jqvmap.css') }}" rel="stylesheet" />
    <!-- Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <!--Daterangepicker css-->
    <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <!-- Student Dashboard -->
    <div class="side-app">

        <div class="page-header">
            <h1 class="page-title">Welcome, {{ $student->name }}</h1>
        </div>

        <div class="row">
            <!-- Summary Cards -->
            <div class="col-sm-6 col-xl-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Courses Enrolled</h5>
                        <h2>{{ $coursesCount }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card text-white bg-secondary">
                    <div class="card-body">
                        <h5 class="card-title">Modules</h5>
                        <h2>{{ $modulesCount }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Lessons Completed</h5>
                        <h2>{{ $completedLessons }}/{{ $totalLessons }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h5 class="card-title">Quizzes Passed</h5>
                        <h2>{{ $quizzesPassed }}/{{ $quizzesTaken }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
            <!-- Pie Chart for Lessons -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Lesson Completion</div>
                    <div class="card-body">
                        <div id="lessonsPieChart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

            <!-- Bar Chart for Assignments -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Assignments</div>
                    <div class="card-body">
                        <div id="assignmentsBarChart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    </div>
    </div>
    </div>
@endsection
@section('js')
    <script>
        var lessonsChart = echarts.init(document.getElementById('lessonsPieChart'));
        var lessonsOption = {
            tooltip: {
                trigger: 'item'
            },
            legend: {
                top: '5%',
                left: 'center'
            },
            series: [{
                name: 'Lessons',
                type: 'pie',
                radius: '50%',
                data: [{
                        value: {{ $completedLessons }},
                        name: 'Completed'
                    },
                    {
                        value: {{ $totalLessons - $completedLessons }},
                        name: 'Remaining'
                    }
                ],
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }]
        };
        lessonsChart.setOption(lessonsOption);

        var assignmentsChart = echarts.init(document.getElementById('assignmentsBarChart'));
        var assignmentsOption = {
            xAxis: {
                type: 'category',
                data: ['Total', 'Submitted', 'Pending']
            },
            yAxis: {
                type: 'value'
            },
            series: [{
                data: [{{ $quizzesTaken }}, {{ $quizzesPassed }},
                    {{ $quizzesTaken - $quizzesPassed }}
                ],
                type: 'bar',
                color: '#007bff'
            }]
        };
        assignmentsChart.setOption(assignmentsOption);
    </script>

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
