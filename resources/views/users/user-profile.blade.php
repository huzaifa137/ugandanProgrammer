@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title">User Profile</h4>
        </div>
        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="d-flex"><svg class="svg-icon"
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                            <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
                        </svg><span class="breadcrumb-icon"> Home</span></a></li>

            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection
@section('content')
    <!-- Row -->
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-12 d-flex flex-column">
            <div class="card box-widget widget-user h-100">
                @php
                    $firstLetter = strtoupper($user->firstname[0] ?? '');
                @endphp

                <div class="widget-user-image mx-auto mt-5">
                    <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center"
                        style="width: 100px; height: 100px; font-size: 36px;">
                        {{ $firstLetter }}
                    </div>
                </div>

                <div class="card-body text-center">
                    <div class="pro-user">
                        <h4 class="pro-user-username text-dark mb-1 font-weight-bold">{{ $user->user_title }}
                            {{ $user->firstname }} {{ $user->lastname }}</h4>
                        <h6 class="pro-user-desc text-muted">{{ $user->user_role }}</h6>
                        <a href="#" class="btn btn-success btn-sm mt-3">{{ $user->account_status }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-8 col-md-12">
            <div class="main-content-body main-content-body-profile card mg-b-20">
                <!-- main-profile-body -->
                <div class="main-profile-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="about">

                            <div class="card-body border-top">
                                <h5 class="font-weight-bold">User Information</h5>
                                <div class="main-profile-contact-list d-lg-flex">
                                    <div class="media mr-5">
                                        <div class="media-icon bg-success-transparent text-success mr-4">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <div class="media-body">
                                            <span class="font-weight-bold mb-1">{{ $user->user_title }}</span> :
                                            {{ $user->firstname }}
                                            {{ $user->lastname }} <br>
                                            <span class="font-weight-bold mb-1">Role </span>: {{ $user->user_role }} <br>
                                            <span class="font-weight-bold mb-1">Gender </span> : {{ $user->gender }}
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="card-body border-top">
                                <h5 class="font-weight-bold">Contact</h5>
                                <div class="main-profile-contact-list d-lg-flex">
                                    <div class="media mr-4">
                                        <div class="media-icon bg-primary-transparent text-primary mr-3 mt-1">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                        <div class="media-body">
                                            <small class="text-muted">Mobile</small>
                                            <div class="font-weight-bold">
                                                {{ $user->phonenumber }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media mr-4">
                                        <div class="media-icon bg-warning-transparent text-warning mr-3 mt-1">
                                            <i class="fa fa-envelope"></i>
                                        </div>
                                        <div class="media-body">
                                            <small class="text-muted">Email</small>
                                            <div class="font-weight-bold">
                                                {{ $user->email }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="media-icon bg-info-transparent text-info mr-3 mt-1">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <link rel="stylesheet"
                                            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

                                        <div class="media-body">
                                            <small class="text-muted">Country</small>
                                            <div class="font-weight-bold">

                                                <?php
                                                $country = DB::table('countries')
                                                    ->where('PhoneCode', @$user->country)
                                                    ->select('Name', 'Iso')
                                                    ->first();
                                                ?>

                                                <i class="flag flag-{{ strtolower($country->Iso ?? '') }} mr-2"
                                                    title="{{ @$country->Name }}"></i>{{ @$country->Name }}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
@endsection
