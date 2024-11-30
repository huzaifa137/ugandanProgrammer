<?php
use App\Http\Controllers\Controller;
use App\Http\Controllers\Helper;
?>

@extends('layouts.master')

@section('css')
    <!-- Morris Charts css -->
    <link href="{{ URL::asset('assets/plugins/morris/morris.css') }}" rel="stylesheet" />
    <!-- Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <!--Daterangepicker css-->
    <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
@endsection
@section('content')
    <!--Row-->
    <div class="row ">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <h4 class="page-title" style="text-align: center;">ACCOUNT INFORMATION</h4>
            <div class="table-responsive">


                <table id="table" class="table table-bordered table-striped" style="clear: both">
                    <tbody>

                        <tr>
                            <td width="35%" style="font-weight: bold;">Username</td>
                            <td width="65%">
                                <p>{{ $user_profile_data->username }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td width="35%" style="font-weight: bold;">Firstname</td>
                            <td width="65%">
                                <p>{{ $user_profile_data->firstname }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Lastname</td>
                            <td>
                                <p>{{ $user_profile_data->lastname }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Email</td>
                            <td>
                                <p>{{ $user_profile_data->email }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Gender</td>
                            <td>
                                <p>{{ $user_profile_data->gender }}</p>
                            </td>
                        <tr>

                            <td style="font-weight: bold;">Phonenumber</td>
                            <td>
                                <p>{{ $user_profile_data->phonenumber }}</p>
                            </td>
                        </tr>
                        <tr>

                            <td style="font-weight: bold;">Passport Number</td>
                            <td>
                                <p>{{ $user_profile_data->passport_number }}</p>
                            </td>
                        </tr>
                        <tr>

                            <td style="font-weight: bold;">Country of Origin</td>
                            <td>
                                <p>{{ Controller::rgf('countries', $user_profile_data->country, 'id', 'Name') }}</p>
                            </td>
                        </tr>

                        
                        <tr>
                            <td style="font-weight: bold;">Title</td>
                            <td>
                                <p>{{ $user_profile_data->user_title }}</p>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight: bold;">Designitation</td>
                            <td>
                                <p>{{ $user_profile_data->title }}</p>
                            </td>
                        </tr>



                        <tr>
                            <td style="font-weight: bold;">Role</td>
                            <td>
                                <p>{{ $user_profile_data->user_role }}</p>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight: bold;">Supervisor</td>
                            <td>
                                <p>{{ $user_profile_data->user_supervisor }}</p>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight: bold;">Account Status</td>
                            <td>
                                <p>{{ $user_profile_data->account_status }}</p>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight: bold;">Entities</td>
                            <td>
                                <?php
                                $ref = $user_profile_data->user_reference;
                                if ($ref) {
                                    $sel = DB::table('user_entities')->where('ue_reference', $ref)->get();
                                
                                    echo '<ol>';
                                    foreach ($sel as $row) {
                                        echo '<li>' . Helper::rgf('master_datas', $row->ue_entity, 'md_id', 'md_name') . '</li>';
                                    }
                                    echo '</ol>';
                                
                                    if (!count($sel)) {
                                        echo 'Not Attached';
                                    }
                                } else {
                                    echo 'Not Attached';
                                }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight: bold;">Attached Department/Division/Project/Unit (s)</td>
                            <td>
                                <?php
                                $ref = $user_profile_data->user_reference;
                                if ($ref) {
                                    $sel = DB::table('user_divisions')->where('ud_reference', $ref)->get();
                                
                                    echo '<ol>';
                                    foreach ($sel as $row) {
                                        echo '<li>' . Helper::rgf('master_datas', $row->ud_division, 'md_id', 'md_name') . '</li>';
                                    }
                                    echo '</ol>';
                                
                                    if (!count($sel)) {
                                        echo 'Not Attached';
                                    }
                                } else {
                                    echo 'Not Attached';
                                }
                                ?>
                            </td>
                        </tr>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <!--End row-->



    <!--Row-->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">

        </div>
    </div>

    <!--End row-->
    </div>
    </div><!-- end app-content-->
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.checkAll').click(function() {
                var firstCheckBox = false;
                $('.all').each(function(index) {
                    if (index == 0) {
                        firstCheckBox = ($(this).is(':checked')) ? true : false;
                    }

                    if (!firstCheckBox)
                        $(this).attr('checked', true);
                    else
                        $(this).attr('checked', false);

                });
            });
            $('.checkAll2').click(function() {
                var firstCheckBox = false;
                $('.all2').each(function(index) {
                    if (index == 0) {
                        firstCheckBox = ($(this).is(':checked')) ? true : false;
                    }

                    if (!firstCheckBox)
                        $(this).attr('checked', true);
                    else
                        $(this).attr('checked', false);

                });
            });
        });
    </script>


    <!--Moment js-->
    <script src="{{ URL::asset('assets/plugins/moment/moment.js') }}"></script>
    <!-- Daterangepicker js-->
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/js/daterange.js') }}"></script>
    <!--Chart js -->
    <script src="{{ URL::asset('assets/plugins/chart/chart.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart/chart.extension.js') }}"></script>
    <!-- ECharts js-->
    <script src="{{ URL::asset('assets/plugins/echarts/echarts.js') }}"></script>
    <script src="{{ URL::asset('assets/js/index2.js') }}"></script>
@endsection
