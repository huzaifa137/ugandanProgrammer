@extends('layouts.master2')
@section('css')
@endsection
@section('content')
    <div class="d-md-flex">
        <div class="w-40 bg-style h-100vh page-style">
            <div class="page-content">
                <div class="page-single-content">
                    <div class="card-body text-white py-5 px-8 text-center">
                        <a href="{{ url('/') }}"><img src="{{ URL::asset('assets/images/png/3.png') }}" alt="img"
                                class=" text-center supplier-logo"></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-80 page-content">
            <div class="page-single-content">
                <div class="card-body p-6">
                    <div class="row">
                        <div class="col-md-8 mx-auto d-block">
                            <div class="">
                                <h1 class="mb-2">User Login</h1>
                                <p class="text-muted">Sign In to your account</p>
                            </div>

                            @include('sweetalert::alert')


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

                            <form action="{{ route('auth-user-check') }}" method="POST">
                                @csrf

                                <div class="input-group mb-3">
                                    <span class="input-group-addon">
                                        <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24"
                                            viewBox="0 0 24 24" width="24">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path d="M12 16c-2.69 0-5.77 1.28-6 2h12c-.2-.71-3.3-2-6-2z" opacity=".3" />
                                            <circle cx="12" cy="8" opacity=".3" r="2" />
                                            <path
                                                d="M12 14c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4zm-6 4c.22-.72 3.31-2 6-2 2.7 0 5.8 1.29 6 2H6zm6-6c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z" />
                                        </svg>
                                    </span>


                                    <input type="email" id="email" name="email" class="form-control"
                                        placeholder="Email" required
                                        pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                                        title="Please enter a valid email address." value="{{ old('email') }}">

                                </div>
                                <span class="text-danger">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </span>

                                <div class="input-group mb-4">
                                    <span class="input-group-addon">
                                        <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24"
                                            viewBox="0 0 24 24" width="24">
                                            <g fill="none">
                                                <path d="M0 0h24v24H0V0z" />
                                                <path d="M0 0h24v24H0V0z" opacity=".87" />
                                            </g>
                                            <path d="M6 20h12V10H6v10zm6-7c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z"
                                                opacity=".3" />
                                            <path
                                                d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z" />
                                        </svg>
                                    </span>

                                    <input type="password" id="password" name="password" class="form-control"
                                        placeholder="Password" required
                                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}"
                                        title="Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.">

                                </div>
                                <span class="text-danger">
                                    @error('password')
                                        {{ $message }}
                                    @enderror
                                </span>

                                <div class="input-group mb-4">
                                    <span class="input-group-addon">
                                        <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24"
                                            viewBox="0 0 24 24" width="24">
                                            <path fill="none" d="M0 0h24v24H0V0z" />
                                            <path
                                                d="M19.45 8.62l-3.72-3.72c-.2-.2-.51-.2-.71 0l-.73.73c-.2.2-.2.51 0 .71l2.19 2.19H11c-2.47 0-4.45 1.98-4.45 4.45v1.07l-2.3-2.3c-.2-.2-.51-.2-.71 0l-.73.73c-.2.2-.2.51 0 .71l3.72 3.72c.2.2.51.2.71 0l.73-.73c.2-.2.2-.51 0-.71l-2.19-2.19h6.28c2.47 0 4.45-1.98 4.45-4.45v-1.07l2.3 2.3c.2.2.51.2.71 0l.73-.73c.19-.21.19-.52-.01-.72zM17 12.5c0 1.93-1.57 3.5-3.5 3.5h-6c0-1.93 1.57-3.5 3.5-3.5h6z" />
                                        </svg>
                                    </span>

                                    <input type="text" id="captcha" name="captcha" minlength="4" maxlength="4"
                                        class="form-control" placeholder="Captcha" required>
                                </div>


                                <span class="text-danger">
                                    @error('captcha')
                                        {{ $message }}
                                    @enderror
                                </span>

                                <div class="input-group mb-4">
                                    <label class="control-label">Enter this captcha :</label>

                                    <div class="col-md-10">
                                        <div class="captcha">
                                            <span style="width: 50%; height: 50%;">{!! captcha_img('flat') !!}</span>
                                            <button type="button" class="btn btn-danger reload"
                                                id="reload">&#x21bb;</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <a href="{{ url('/users/forgot-password') }}"
                                            class="btn btn-link box-shadow-0 px-0">Forgot
                                            password?</a>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-block" id="login_button">
                                            <i class="fe fe-arrow-right"></i> Login
                                        </button>

                                    </div>
                                </div>

                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection


@section('js')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('form').addEventListener('submit', function() {
                var button = document.getElementById('login_button');
                button.disabled = true;
                button.innerHTML = '<i class="fe fe-arrow-right"></i> Logging in...';
            });
        });


        $('#reload').click(function() {
            $.ajax({

                type: 'GET',
                url: '/reload-captcha',
                success: function(data) {
                    $(".captcha span").html(data.captcha)
                }
            });
        });

        $('#supplier_login_in').click(function() {

            var email = $('#email').val();
            var password = $('#password').val();
            var captcha = $('#captcha').val();

            var form_data = new FormData();

            form_data.append('email', email);
            form_data.append('password', password);
            form_data.append('captcha', captcha);

            $.ajax({
                type: "POST",
                processData: false,
                contentType: false,
                cache: false,
                data: form_data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/auth.check',
                success: function(data) {
                    if (data.status) {
                        // handle success
                    }
                },
                error: function(data) {
                    $('body').html(data.responseText);
                }
            });
        });
    </script>
@endsection
