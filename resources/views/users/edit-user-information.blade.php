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
    <div class="row border">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <h4 class="page-title text-primary mb-4" style="text-align: center;">EDIT USER INFORMATION</h4>

            <form action="{{ route('store-updated-information') }}" class="border p-4 bg-light shadow" method="POST"
                id="registerForm">

                @csrf

                @if (Session::get('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif

                @if (Session::get('fail'))
                    <div class="alert alert-danger">
                        {{ Session::get('fail') }}
                    </div>
                @endif


                <div class="row">
                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Title<span class="text-danger">*</span></label>
                        <select name="user_title" id="user_title" class="input-sm form-control">
                            <option value="{{ $info->user_title }}">{{ $info->user_title }}</option>
                            <option value="Mr">Mr.</option>
                            <option value="Mrs">Mrs.</option>
                            <option value="Dr">Dr.</option>
                            <option value="Prof.">Prof.</option>
                        </select>
                    </div>


                    <div class=" col-md-4" style="padding-top:1rem;">

                        <input type="hidden" name="hidden_id" class="input-sm form-control" value="{{ $info->id }}"
                            required>

                        <label>Firstname<span class="text-danger">*</span></label>
                        <input type="text" name="firstname" id="firstname" class="input-sm form-control"
                            placeholder="Enter Firstname" value="{{ $info->firstname }}" required>
                        <span class="text-danger">
                            @error('firstname')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class=" col-md-4" style="padding-top:1rem;">
                        <label>Lastname<span class="text-danger">*</span></label>
                        <input type="text" name="lastname" id="lastname" class="input-sm form-control"
                            placeholder="Enter Lastname" value="{{ $info->lastname }}" required>
                        <span class="text-danger">
                            @error('lastname')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class=" col-md-4" style="padding-top:1rem;">
                        <label>Username<span class="text-danger">*</span></label>
                        <input type="text" name="username" id="username" class="input-sm form-control"
                            placeholder="Enter username" value="{{ $info->username }}" required>
                        <span class="text-danger">
                            @error('username')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class=" col-md-4" style="padding-top:1rem;">
                        <label>Designitation<span class="text-danger">*</span></label>
                        <select name="title" id="title" class="input-sm form-control">
                            <option value="{{ $info->title }}">{{ $info->title }}</option>
                            @foreach ($Titles as $user_role)
                                <option value="{{ $user_role->md_name }}">{{ $user_role->md_name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">
                            @error('username')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class=" col-md-4" style="padding-top:1rem;">
                        <label>Supervisor<span class="text-danger">*</span></label>
                        <select name="user_supervisor" id="user_supervisor" class="input-sm form-control">
                            <option value="{{ $info->user_supervisor }}" value="{{ old('user_supervisor') }}">
                                {{ $info->user_supervisor }}</option>
                            @foreach ($user_supervisors as $supervisor_name)
                                <option value="{{ $supervisor_name->firstname }} {{ $supervisor_name->lastname }}">
                                    {{ $supervisor_name->firstname }} {{ $supervisor_name->lastname }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">
                            @error('username')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                </div>

                <div class="row">
                    <div class=" col-md-4" style="padding-top:1rem;">
                        <label>User Role<span class="text-danger">*</span></label>
                        <select name="user_role" id="user_role" class="input-sm form-control">
                            <option value="{{ $info->user_role }}" value="{{ old('user_role') }}">
                                {{ $info->user_role }}</option>
                            @foreach ($user_roles as $user_role)
                                <option value="{{ $user_role->user_name }}">{{ $user_role->user_name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">
                            @error('username')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class=" col-md-4" style="padding-top:1rem;">
                        <label>Phonenumber<span class="text-danger">*</span></label>
                        <input type="text" name="phonenumber" id="phonenumber" class="input-sm form-control"
                            placeholder="Enter phonenumber" value="{{ $info->phonenumber }}" required>
                        <span class="text-danger">
                            @error('phonenumber')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class=" col-md-4" style="padding-top:1rem;">
                        <label>Email<span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="input-sm form-control"
                            placeholder="Enter Email" value="{{ $info->email }}" required>
                        <span class="text-danger">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class=" col-md-4" style="padding-top:1rem;">
                        <label>Account Status Number<span class="text-danger">*</span></label>
                        <select name="account_status" id="account_status" class="input-sm form-control">
                            <option value="Active">Activate</option>
                            <option value="De-activated">De-activate</option>
                        </select>
                    </div>

                    <div class=" col-md-4" style="padding-top:1rem;">
                        <label>Gender<span class="text-danger">*</span></label>
                        <select name="gender" id="gender" class="input-sm form-control">
                            <option value="{{ $info->gender }}">{{ $info->gender }}</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <span class="text-danger">
                            @error('gender')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                </div>

                <!-- Register User Button -->
                <div class="row mt-4">
                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                        <!-- Updated User Information Button -->
                        <button class="btn btn-primary btn-sm" id="register-user-btn">
                            <i class="fas fa-user-edit"></i> Updated User Information
                        </button>

                    </div>
                </div>
        </div>

        </section>
        </fieldset>

        </form>


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

    <br> <br>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script> <!-- FontAwesome for icons -->


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
