@extends('layouts.master')
@section('css')
    <!--Daterangepicker css-->
    <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
@endsection


<?php
use App\Http\Controllers\Helper;
use Carbon\Carbon;
?>

<div>
    @section('page-header')
        <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title">GPS Tracking Links</h4>
            </div>

        </div>
        <!--End Page header-->
    @endsection
    @section('content')
        <!--Row-->
        <div class="row">
            <div class="col-xl-4 col-md-12 col-lg-3">
                <div class="card expenses-card overflow-hidden">
                    <div class="card-body">
                        <div class="feature">
                            <i class="fas fa-link fa-2x"></i>
                            <h1 class="font-weight-bold mb-0 mt-4 fs-50">{{ Helper::countRecords($Links) }}</h1>
                            <p class="text-muted fs-18 mb-0">Total Links Generated</p>
                        </div>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="Chart" class="overflow-hidden"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-md-12 col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm d-flex mb-4 mb-sm-0">
                                <i class="mdi mdi-basket-fill fs-60 text-primary icon-dropshadow-success mr-3"></i>
                                <div class="mt-5">
                                    <h6>Total Links</h6>
                                    <h3 class="mb-0 font-weight-bold">{{ Helper::countRecords($Links) }}</h3>
                                </div>
                            </div>
                            <div class="col-12 col-sm d-flex mb-4 mb-sm-0">
                                <i class="mdi mdi-basket-fill fs-60 text-success icon-dropshadow-primary mr-3"></i>
                                <div class="mt-5">
                                    <h6>Active Links</h6>
                                    <h3 class="mb-0 font-weight-bold">{{ Helper::countRecords($Activated) }}</h3>
                                </div>
                            </div>
                            <div class="col-12 col-sm d-flex">
                                <i class="mdi mdi-basket-fill fs-60 text-danger icon-dropshadow-danger mr-3"></i>
                                <div class="mt-5">
                                    <h6>De-activated Links</h6>
                                    <h3 class="mb-0 font-weight-bold">{{ Helper::countRecords($DeActivated) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Generate Link Section -->
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <a href="{{ url('/tracking/create-track-link') }}" class="card text-decoration-none">
                            <div class="card-body">
                                <p class="mb-1">Generate Link</p>
                                <h2 class="mb-1 font-weight-bold">
                                    <i class="fas fa-link text-primary"></i>
                                </h2>
                                <span class="mb-1 text-muted">Click section to generate Link</span>
                            </div>
                        </a>
                    </div>

                    <!-- Activate Link Section -->
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <a href="{{ url('/tracking/activate-track-link') }}" class="card text-decoration-none">
                            <div class="card-body">
                                <p class="mb-1">Active Links</p>
                                <h2 class="mb-1 font-weight-bold">
                                    <i class="fas fa-check-circle text-success"></i>
                                </h2>
                                <span class="mb-1 text-muted">Click section to activate Link</span>
                            </div>
                        </a>
                    </div>

                    <!-- De-activate Link Section -->
                    <div class="col-xl-4 col-lg-4 col-md-12">
                        <a href="{{ url('/tracking/de-activate-track-link') }}" class="card text-decoration-none">
                            <div class="card-body">
                                <p class="mb-1">De-active Links</p>
                                <h2 class="mb-1 font-weight-bold">
                                    <i class="fas fa-times-circle  text-danger"></i>
                                </h2>
                                <span class="mb-1 text-muted">Click section to de-activate</span>
                            </div>
                        </a>
                    </div>
                </div>


            </div>
        </div>
        <div class="row row-deck">

            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recently created Links</h3>

                    </div>
                    <div class="card-body">
                        <div class="">
                            <div class="table-responsive invoice-table-responsive">
                                <table class="table card-table table-vcenter text-nowrap mb-0 border">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th class="wd-lg-10p">Link Generated</th>
                                            <th class="wd-lg-20p">Date Generated</th>
                                            <th class="wd-lg-20p">Ip Address</th>
                                            <th class="wd-lg-20p">status</th>
                                            <th class="wd-lg-20p">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Links as $count => $link)
                                            <tr>
                                                <td>{{ $count + 1 }}</td>
                                                <td class="font-weight-semibold">{{ $link->gl_links }}</td>
                                                <td class="text-nowrap">
                                                    {{ \Carbon\Carbon::createFromTimestamp($link->gl_date_added)->toDateTimeString() }}
                                                </td>
                                                <td>{{ $link->gl_device_ip }}</td>
                                                @if ($link->gl_active_status == 0)
                                                    <td><span class="btn btn-danger btn-sm">De-activated<span></td>
                                                @else
                                                    <td><span class="btn btn-success btn-sm">Activated<span></td>
                                                @endif
                                                <td>
                                                    @if ($link->gl_active_status == 0)
                                                        <a class="btn btn-success btn-sm" href="javascript:void(0)"
                                                            onclick="activateAccount({{ $link->id }})">Activate</a>
                                                    @else
                                                        <a class="btn btn-danger btn-sm" href="javascript:void(0)"
                                                            onclick="deactivateAccount({{ $link->id }})">De-activate</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br> <br>
                                <div class="d-flex">
                                    {{ $Links->links() }}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--End row-->
    </div>
    </div><!-- end app-content-->
    </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>

       function activateAccount(linkId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Please confirm you want to activate this account!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, activate it!',
            cancelButtonText: 'No, cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
               
                Swal.fire({
                    title: 'Activated!',
                    text: 'The Link has been successfully activated.',
                    icon: 'success',
                    showConfirmButton: true,  
                    confirmButtonText: 'OK',
             
                }).then(() => {

                    window.location.href = "{{ url('tracking-status-update') }}/" + linkId;
                });
            }
        });
    }

    function deactivateAccount(linkId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Please confirm you want to de-activate this account!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, deactivate it!',
            cancelButtonText: 'No, cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                
                Swal.fire({
                    title: 'Deactivated!',
                    text: 'The Link has been successfully de-activated.',
                    icon: 'success',
                    showConfirmButton: true,  
                    confirmButtonText: 'OK',
                }).then(() => {
                    window.location.href = "{{ url('tracking-status-update') }}/" + linkId;
                });
            }
        });
    }
    </script>

    <!--Moment js-->
    <script src="{{ URL::asset('assets/plugins/moment/moment.js') }}"></script>
    <!-- Daterangepicker js-->
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/js/daterange.js') }}"></script>
    <!-- ECharts js -->
    <script src="{{ URL::asset('assets/plugins/echarts/echarts.js') }}"></script>
    <!-- Chartjs js -->
    <script src="{{ URL::asset('assets/plugins/chart/chart.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart/utils.js') }}"></script>
    <!--Morris Charts js-->
    <script src="{{ URL::asset('assets/plugins/morris/raphael-min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/morris/morris.js') }}"></script>
    <!-- P-scroll js-->
    <script src="{{ URL::asset('assets/plugins/p-scrollbar/p-scrollbar.js') }}"></script>
    <!-- Index js-->
    <script src="{{ URL::asset('assets/js/index3.js') }}"></script>
@endsection
