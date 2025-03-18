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
            <h4 class="page-title" style="text-align: center;">UP USER REGISTRATION</h4>
            <br>

            <form action="{{ route('store-user') }}" class="border" method="POST" onsubmit="return validateForm()">

                @csrf

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (Session::get('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Title<span class="text-danger">*</span></label>
                        <select name="user_title" id="user_title" class="input-sm form-control" required>
                            <option value="Mr">Mr.</option>
                            <option value="Mrs">Mrs.</option>
                            <option value="Dr">Dr.</option>
                            <option value="Prof.">Prof.</option>
                        </select>
                    </div>

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Firstname<span class="text-danger">*</span></label>
                        <input type="text" name="firstname" id="firstname" class="input-sm form-control"
                            placeholder="Enter Firstname" value="{{ old('firstname') }}" required>
                        <span class="text-danger">
                            @error('firstname')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Lastname<span class="text-danger">*</span></label>
                        <input type="text" name="lastname" id="lastname" class="input-sm form-control"
                            placeholder="Enter Lastname" value="{{ old('lastname') }}" required>
                        <span class="text-danger">
                            @error('lastname')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Username<span class="text-danger">*</span></label>
                        <input type="text" name="username" id="username" class="input-sm form-control"
                            placeholder="Enter username" value="{{ old('username') }}" required>
                        <span class="text-danger">
                            @error('username')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Designation<span class="text-danger">*</span></label>
                        <select name="title" id="title" class="input-sm form-control" required>
                            @foreach ($Titles as $user_role)
                                <option value="{{ $user_role->md_name }}">{{ $user_role->md_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Gender<span class="text-danger">*</span></label>
                        <select name="gender" id="gender" class="input-sm form-control" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>User Role<span class="text-danger">*</span></label>
                        <select name="user_role" id="user_role" class="input-sm form-control" required>
                            @foreach ($user_roles as $user_role)
                                <option value="{{ $user_role->user_name }}">{{ $user_role->user_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Phonenumber<span class="text-danger">*</span></label>
                        <input type="text" name="phonenumber" id="phonenumber" class="input-sm form-control"
                            placeholder="Enter phonenumber" value="{{ old('phonenumber') }}" required>
                        <span class="text-danger">
                            @error('phonenumber')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Email<span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="input-sm form-control"
                            placeholder="Enter Email" value="{{ old('email') }}" required>
                        <span class="text-danger">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Passport Number / NIN Number<span class="text-danger">*</span></label>
                        <input type="text" name="passport" id="passport" class="input-sm form-control"
                            placeholder="Enter Passport Number" value="{{ old('passport') }}" required>
                        <span class="text-danger">
                            @error('passport')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Password<span class="text-danger">*</span></label>
                        <input type="password" name="password" id="password" class="input-sm form-control"
                            placeholder="Enter Password" value="{{ old('password') }}" required>
                        <span class="text-danger">
                            @error('password')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-4" style="padding-top:1rem;">
                        <label>Confirm password<span class="text-danger">*</span></label>
                        <input type="password" name="confirm_password" id="confirm_password"
                            class="input-sm form-control" value="{{ old('confirm_password') }}"
                            placeholder="Enter Password" required>
                        <span class="text-danger">
                            @error('confirm_password')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4" style="padding-top: 1rem;">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-user-plus"></i> Register User
                        </button>
                    </div>
                </div>

            </form>

            <br> <br>
        </div>
    </div>
    <!--End row-->

    </div>
    </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script> <!-- FontAwesome for icons -->

    <script>
        function validateForm() {
            var firstname = document.getElementById("firstname").value;
            var lastname = document.getElementById("lastname").value;
            var username = document.getElementById("username").value;
            var phonenumber = document.getElementById("phonenumber").value;
            var email = document.getElementById("email").value;
            var passport = document.getElementById("passport").value;
            var password = document.getElementById("password").value;
            var confirm_password = document.getElementById("confirm_password").value;

            if (!firstname || !lastname || !username || !phonenumber || !email || !passport || !password || !
                confirm_password) {
                Swal.fire('Error', 'Please fill all required fields!', 'error');
                return false;
            }

            if (password !== confirm_password) {
                Swal.fire('Error', 'Passwords do not match!', 'error');
                return false;
            }

            var phoneRegex = /^\d{10}$/;
            if (!phoneRegex.test(phonenumber)) {
                Swal.fire('Error', 'Please enter a valid phone number (10 digits)!', 'error');
                return false;
            }

            return true;
        }
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
