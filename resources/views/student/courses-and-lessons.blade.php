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
@section('page-header')
@endsection
@section('content')
    <style>
       
        .item-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .item-card:hover {
            transform: scale(1.03);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            z-index: 2;
        }

        .item-card img {
            transition: transform 0.4s ease;
        }

        .item-card:hover img {
            transform: scale(1.05);
        }

        .item-card:hover .btn-primary {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
            transition: background-color 0.3s ease;
        }

        .item-card:hover .shop-title {
            color: #007bff;
            transition: color 0.3s ease;
        }
    </style>
    <br> <br>
    <!-- Row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="row">

                <?php
                use App\Models\Course;
                ?>

                @foreach ($allCourses as $course)
                    @php

                        $courseInformation = Course::with('modules.lessons')->find($course->id);
                        $courseModules = $courseInformation->modules;
                        $courseLessons = $courseInformation->lessons;

                        $courseModuleCount = @$courseModules->count();
                        $courseLessonsCount = @$courseLessons->count();

                    @endphp

                    <div class="col-xl-4 col-lg-6 col-sm-6">
                        <div class="card item-card">
                            <div class="card-body pb-0">
                                <div class="text-center">
                                    <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : asset('assets/images/products/default.jpg') }}"
                                        alt="Course Thumbnail" class="img-fluid w-100">
                                </div>
                                <div class="card-body px-0">
                                    <div class="cardtitle">
                                        <div>
                                            <a href="#"><i class="fa fa-star text-yellow fs-16"></i></a>
                                            <a href="#"><i class="fa fa-star text-yellow fs-16"></i></a>
                                            <a href="#"><i class="fa fa-star text-yellow fs-16"></i></a>
                                            <a href="#"><i class="fa fa-star text-yellow fs-16"></i></a>
                                            <a href="#"><i class="fa fa-star text-yellow fs-16"></i></a>
                                        </div>
                                        <a class="shop-title">{{ $course->title }} ({{ $courseLessonsCount ?? 0 }})</a>
                                        <h5 style="margin-top: 0.2rem; text-align: left !important;color:green;">
                                            Ugx{{ $course->selling_price }}
                                        </h5>
                                    </div>

                                    <div class="cardprice"
                                        style="display: flex; flex-direction: column; align-items: flex-start; text-align: left !important;">

                                        <span class="type--strikethrough"
                                            style="text-align: left !important; margin-bottom: 4px;color:red;">
                                            Ugx{{ $course->old_price }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center border-top p-4">
                                <a href="{{ url('/' . ($page = 'shop-des')) }}"
                                    class="btn btn-light btn-svgs mt-1 mb-1"><svg class="svg-icon"
                                        xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                                        width="24">
                                        <path d="M0 0h24v24H0V0z" fill="none" />
                                        <path
                                            d="M12 6c-3.79 0-7.17 2.13-8.82 5.5C4.83 14.87 8.21 17 12 17s7.17-2.13 8.82-5.5C19.17 8.13 15.79 6 12 6zm0 10c-2.48 0-4.5-2.02-4.5-4.5S9.52 7 12 7s4.5 2.02 4.5 4.5S14.48 16 12 16z"
                                            opacity=".3" />
                                        <path
                                            d="M12 4C7 4 2.73 7.11 1 11.5 2.73 15.89 7 19 12 19s9.27-3.11 11-7.5C21.27 7.11 17 4 12 4zm0 13c-3.79 0-7.17-2.13-8.82-5.5C4.83 8.13 8.21 6 12 6s7.17 2.13 8.82 5.5C19.17 14.87 15.79 17 12 17zm0-10c-2.48 0-4.5 2.02-4.5 4.5S9.52 16 12 16s4.5-2.02 4.5-4.5S14.48 7 12 7zm0 7c-1.38 0-2.5-1.12-2.5-2.5S10.62 9 12 9s2.5 1.12 2.5 2.5S13.38 14 12 14z" />
                                    </svg> View More</a>
                                <a href="{{ url('/' . ($page = 'cart')) }}" class="btn btn-primary btn-svgs mt-1 mb-1"><svg
                                        class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24"
                                        viewBox="0 0 24 24" width="24">
                                        <path d="M0 0h24v24H0V0z" fill="none" />
                                        <path d="M15.55 11l2.76-5H6.16l2.37 5z" opacity=".3" />
                                        <path
                                            d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.37-.66-.11-1.48-.87-1.48H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z" />
                                    </svg> Add to cart</a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="d-flex justify-content-end">
                <div class="card-footer">
                    <div class="d-flex justify-content-center">
                        {{ $allCourses->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End  Row -->
    </div>
    </div>
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
