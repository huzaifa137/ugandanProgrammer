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
            <h4 class="page-title" style="text-align: center;">PTS USER REGISTRATION</h4>

            <form action="{{ route('store-user') }}" class="border p-4 bg-light shadow" method="POST" id="registerForm">

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
                            <option value="Mr">Mr.</option>
                            <option value="Mrs">Mrs.</option>
                            <option value="Dr">Dr.</option>
                            <option value="Prof.">Prof.</option>
                        </select>
                    </div>


                    <div class=" col-md-4" style="padding-top:1rem;">
                        <label>Firstname<span class="text-danger">*</span></label>
                        <input type="text" name="firstname" id="firstname" class="input-sm form-control"
                            placeholder="Enter Firstname" value="{{ old('firstname') }}" required>
                        <span class="text-danger">
                            @error('firstname')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class=" col-md-4" style="padding-top:1rem;">
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
                    <div class=" col-md-4" style="padding-top:1rem;">
                        <label>Username<span class="text-danger">*</span></label>
                        <input type="text" name="username" id="username" class="input-sm form-control"
                            placeholder="Enter username" value="{{ old('username') }}" required>
                        <span class="text-danger">
                            @error('username')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class=" col-md-4" style="padding-top:1rem;">
                        <label>Designitation<span class="text-danger">*</span></label>
                        <select name="title" id="title" class="input-sm form-control">
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
                        <label>Gender<span class="text-danger">*</span></label>
                        <select name="gender" id="gender" class="input-sm form-control">
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

                <div class="row">
                    <div class=" col-md-4" style="padding-top:1rem;">
                        <label>User Role<span class="text-danger">*</span></label>
                        <select name="user_role" id="user_role" class="input-sm form-control">
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
                            placeholder="Enter phonenumber" value="{{ old('phonenumber') }}" required>
                        <span class="text-danger">
                            @error('phonenumber')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class=" col-md-4" style="padding-top:1rem;">
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
                    <div class=" col-md-3" style="padding-top:1rem;">
                        <label>Passport Number<span class="text-danger">*</span></label>
                        <input type="text" name="passport" id="passport" class="input-sm form-control"
                            placeholder="Enter Passport Number" value="{{ old('password') }}" required>
                        <span class="text-danger">
                            @error('passport')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class=" col-md-3" style="padding-top:1rem;">
                        <label>Country of Origin <span class="text-danger">*</span></label>
                        <select name="country" class="form-control" id="country">
                            <?php
                            $country = DB::table('countries')->orderBy('Name', 'ASC')->get();
                            foreach ($country as $co) {
                                echo '<option value="' . $co->id . '">' . $co->Name . '</option>';
                            }
                            
                            ?>
                        </select>
                    </div>

                    <div class=" col-md-3" style="padding-top:1rem;">
                        <label>Password<span class="text-danger">*</span></label>
                        <input type="password" name="password" id="password" class="input-sm form-control"
                            placeholder="Enter Password" value="{{ old('password') }}" required>
                        <span class="text-danger">
                            @error('password')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>


                    <div class=" col-md-3" style="padding-top:1rem;">
                        <label>Confirm password<span class="text-danger">*</span></label>
                        <input type="password" name="confirm_password" id="confirm_password"
                            class="input-sm form-control" value="{{ old('confirm_password') }}"
                            placeholder="Enter Password" required>
                        <span class="text-danger">
                            @error('password')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>

                <div class="container">
                    <!-- Select Entities Section -->
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="border-bottom pb-2 mb-3 mt-3">Select Entities</h4>
                            <div class="formSep1">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="d-flex flex-wrap me-3">
                                        <?php
                                        $select = DB::table('master_datas')->join('master_codes', 'id', '=', 'md_master_code_id')->where('mc_code', 'ENT')->orderBy('md_name', 'ASC')->get();
                                        
                                        foreach ($select as $row) {
                                            echo '<div class="mb-2 me-3">';
                                            echo '<label class="checkbox-inline">';
                                            echo '<input class="all2" value="' . $row->md_id . '" name="entities[]" type="checkbox"> ' . $row->md_name;
                                            echo '</label>';
                                            echo '</div>';
                                        }
                                        ?>
                                    </div>
                                    <div>
                                        <button type="button" class="checkAll2 btn btn-sm btn-danger">
                                            <i class="fas fa-check-square"></i> Check/Uncheck All
                                        </button>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Select User Divisions, Projects, or/and Units Section -->
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h4 class="border-bottom pb-2 mb-3">Select User Divisions, Projects or/and Units</h4>
                            <div class="formSep1">
                                <div class="row">
                                    <?php
                                    $select = DB::table('master_datas')->join('master_codes', 'id', '=', 'md_master_code_id')->where('mc_name', 'Requisition Unit')->orderBy('md_name', 'ASC')->get();
                                    
                                    foreach ($select as $row) {
                                        echo '<div class="col-md-4 mb-2">';
                                        echo '<label class="checkbox-inline">';
                                        echo '<input class="all" value="' . $row->md_id . '" name="requisitionunits[]" type="checkbox"> ' . $row->md_name;
                                        echo '</label>';
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Register User Button -->
                    <div class="row mt-4">
                        <div class="col-md-12 d-flex justify-content-between align-items-center">
                            <!-- Register User Button -->
                            <button class="btn btn-primary btn-sm" id="register-user-btn">
                                <i class="fas fa-user-plus"></i> Register User
                            </button>

                            <!-- Check/Uncheck All Button -->
                            <button type="button" class="checkAll btn btn-sm btn-danger">
                                <i class="fas fa-check-square"></i> Check/Uncheck All
                            </button>
                        </div>

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

    <br> <br>
    </div>
    </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script> <!-- FontAwesome for icons -->

    <script type="text/javascript">
        document.getElementById('register-user-btn').addEventListener('click', function(event) {
            event.preventDefault();

            var button = this;

            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to register a new user?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, register!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {

                    button.disabled = true;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Registering user ...';
                    document.querySelector("form").submit();
                }
            });
        });

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
