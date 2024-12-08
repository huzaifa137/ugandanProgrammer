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
                <h4 class="page-title">De-activated Links</h4>
            </div>

        </div>
        <!--End Page header-->
    @endsection
    @section('content')
        <!--Row-->

        <div class="row">

            <div class="col-xl-12 col-lg-12 col-md-12">

                @if (Helper::countRecords($Links) == 0)
                    <div class="alert alert-warning" role="alert">
                        No records found in the system
                    </div>
                @else
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Currently De-activated Tracking Links</h3>
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
                @endif


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
