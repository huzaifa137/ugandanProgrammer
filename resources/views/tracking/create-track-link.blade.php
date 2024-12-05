@extends('layouts.master')
@section('css')
    <!-- News-Ticker css-->
    <link href="{{ URL::asset('assets/plugins/newsticker/newsticker.css') }}" rel="stylesheet" />
    <!-- Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <!--Daterangepicker css-->
    <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title">Tracking Link Generation</h4>
        </div>

    </div>
    <!--End Page header-->
@endsection
@section('content')
    <!--Row-->
    <div class="row">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="">
                <div class="js-conveyor-example">
                    <ul class="news-crypto">
                        <li>
                            <span><img
                                    src="{{ URL::asset('assets/images/crypto-currencies/round-outline/AquariusCoin.svg') }}"
                                    class="w-5 h-5 mr-2" alt=""><span class="font-weight-bold">iPhone 14</span>
                                <span class="text-muted fs-10">Active</span><span class="text-success ml-4"><i
                                        class="ion-arrow-up-c mr-1"></i>Battery: 90%</span></span>
                        </li>
                        <li>
                            <span><img src="{{ URL::asset('assets/images/crypto-currencies/round-outline/Augur.svg') }}"
                                    class="w-5 h-5 mr-2" alt=""><span class="font-weight-bold">Samsung Galaxy
                                    S21</span> <span class="text-muted fs-10">Offline</span><span
                                    class="text-danger ml-4"><i class="ion-arrow-down-c mr-1"></i>Battery: 15%</span></span>
                        </li>
                        <li>
                            <span><img src="{{ URL::asset('assets/images/crypto-currencies/round-outline/Bitcoin.svg') }}"
                                    class="w-5 h-5 mr-2" alt=""><span class="font-weight-bold">Google Pixel 7</span>
                                <span class="text-muted fs-10">Active</span><span class="text-success ml-4"><i
                                        class="ion-arrow-up-c mr-1"></i>Battery: 70%</span></span>
                        </li>
                        <li>
                            <span><img
                                    src="{{ URL::asset('assets/images/crypto-currencies/round-outline/BitConnect.svg') }}"
                                    class="w-5 h-5 mr-2" alt=""><span class="font-weight-bold">OnePlus 9</span>
                                <span class="text-muted fs-10">Tracking</span><span class="text-success ml-4"><i
                                        class="ion-arrow-up-c mr-1"></i>Battery: 50%</span></span>
                        </li>
                        <li>
                            <span><img src="{{ URL::asset('assets/images/crypto-currencies/round-outline/BitShares.svg') }}"
                                    class="w-5 h-5 mr-2" alt=""><span class="font-weight-bold">Xiaomi Mi 11</span>
                                <span class="text-muted fs-10">Active</span><span class="text-danger ml-4"><i
                                        class="ion-arrow-down-c mr-1"></i>Battery: 5%</span></span>
                        </li>
                        <li>
                            <span><img src="{{ URL::asset('assets/images/crypto-currencies/round-outline/Bytecoin.svg') }}"
                                    class="w-5 h-5 mr-2" alt=""><span class="font-weight-bold">Nokia 3310</span>
                                <span class="text-muted fs-10">Offline</span><span class="text-danger ml-4"><i
                                        class="ion-arrow-down-c mr-1"></i>Battery: 0%</span></span>
                        </li>
                        <li>
                            <span><img src="{{ URL::asset('assets/images/crypto-currencies/round-outline/Dash.svg') }}"
                                    class="w-5 h-5 mr-2" alt=""><span class="font-weight-bold">Sony Xperia 1</span>
                                <span class="text-muted fs-10">Active</span><span class="text-success ml-4"><i
                                        class="ion-arrow-up-c mr-1"></i>Battery: 80%</span></span>
                        </li>
                        <li>
                            <span><img src="{{ URL::asset('assets/images/crypto-currencies/round-outline/Decred.svg') }}"
                                    class="w-5 h-5 mr-2" alt=""><span class="font-weight-bold">Motorola Edge+
                                </span> <span class="text-muted fs-10">Offline</span><span class="text-danger ml-4"><i
                                        class="ion-arrow-down-c mr-1"></i>Battery: 10%</span></span>
                        </li>
                        <li>
                            <span><img src="{{ URL::asset('assets/images/crypto-currencies/round-outline/EOS.svg') }}"
                                    class="w-5 h-5 mr-2" alt=""><span class="font-weight-bold">Huawei Mate 40</span>
                                <span class="text-muted fs-10">Tracking</span><span class="text-success ml-4"><i
                                        class="ion-arrow-up-c mr-1"></i>Battery: 65%</span></span>
                        </li>
                        <li>
                            <span><img src="{{ URL::asset('assets/images/crypto-currencies/round-outline/Ethereum.svg') }}"
                                    class="w-5 h-5 mr-2" alt=""><span class="font-weight-bold">LG V60 ThinQ</span>
                                <span class="text-muted fs-10">Active</span><span class="text-success ml-4"><i
                                        class="ion-arrow-up-c mr-1"></i>Battery: 85%</span></span>
                        </li>
                        <li>
                            <span><img src="{{ URL::asset('assets/images/crypto-currencies/round-outline/Golem.svg') }}"
                                    class="w-5 h-5 mr-2" alt=""><span class="font-weight-bold">Asus Zenfone 8</span>
                                <span class="text-muted fs-10">Offline</span><span class="text-danger ml-4"><i
                                        class="ion-arrow-down-c mr-1"></i>Battery: 3%</span></span>
                        </li>
                        <li>
                            <span><img src="{{ URL::asset('assets/images/crypto-currencies/round-outline/Iconomi.svg') }}"
                                    class="w-5 h-5 mr-2" alt=""><span class="font-weight-bold">Realme GT</span>
                                <span class="text-muted fs-10">Active</span><span class="text-danger ml-4"><i
                                        class="ion-arrow-down-c mr-1"></i>Battery: 40%</span></span>
                        </li>
                        <li>
                            <span><img src="{{ URL::asset('assets/images/crypto-currencies/round-outline/IOTA.svg') }}"
                                    class="w-5 h-5 mr-2" alt=""><span class="font-weight-bold">Google Pixel
                                    6</span> <span class="text-muted fs-10">Tracking</span><span
                                    class="text-success ml-4"><i class="ion-arrow-up-c mr-1"></i>Battery:
                                    78%</span></span>
                        </li>
                        <li>
                            <span><img
                                    src="{{ URL::asset('assets/images/crypto-currencies/round-outline/LanaCoin.svg') }}"
                                    class="w-5 h-5 mr-2" alt=""><span class="font-weight-bold">Oppo Find
                                    X3</span>
                                <span class="text-muted fs-10">Offline</span><span class="text-success ml-4"><i
                                        class="ion-arrow-up-c mr-1"></i>Battery: 95%</span></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!--End Row-->

    <style>
        .btn {
            min-height: 40px;
            height: 40px;
            white-space: nowrap;
            position: relative;
        }

        .spinner {
            display: none;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
        }

        .button-text {
            display: inline-block;
        }


        .spinner i {
            font-size: 16px;
        }
    </style>

    <div class="row row-deck">
        <div class="col-xl-12 col-lg-12">
            <div class="panel panel-primary w-100">

                <div class="card panel-body tabs-menu-body br-tl-0 border-top-0 p-6 w-100 shadow2 crypto-content">
                    <div class="tab-content">

                        <div class="mb-0 border">
                            <div class="card-body text-center">
                                <div class="card-title text-left text-dark">Generate Tracking Link</div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="tracking-link" value="">

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <a class="btn btn-sm btn-primary w-100" href="Javascript:void(0);" id="generate-link-btn">
                                            <i class="fa fa-link"></i>
                                            <span class="button-text">Generate Link</span>
                                            <span class="spinner" style="display:none;">
                                                <i class="fa fa-spinner fa-spin"></i> Generating...
                                            </span>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a class="btn btn-sm btn-primary w-100" href="Javascript:void(0);" id="save-link-btn">
                                            <i class="fa fa-save"></i> Save Link
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a class="btn btn-sm btn-primary w-100" href="Javascript:void(0);" id="copy-link-btn">
                                            <i class="fa fa-copy"></i> Copy Link
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        

        document.addEventListener('DOMContentLoaded', function() {
            const generateLinkBtn = document.getElementById('generate-link-btn');
            const saveLinkBtn = document.getElementById('save-link-btn');
            const copyLinkBtn = document.getElementById('copy-link-btn');
            const trackingLinkInput = document.getElementById('tracking-link');

            // Store the original button text
            const originalTexts = {
                generate: generateLinkBtn.innerHTML,
                save: saveLinkBtn.innerHTML,
                copy: copyLinkBtn.innerHTML,
            };

            generateLinkBtn.addEventListener('click', function() {
                setButtonState(generateLinkBtn, 'Generating...');
                fetch('/generate-tracking-link', {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            trackingLinkInput.value = data.link;
                            setButtonState(generateLinkBtn, 'Generated', originalTexts.generate);
                        } else {
                            setButtonState(generateLinkBtn, 'Generation Failed', originalTexts
                            .generate);
                        }
                    })
                    .catch(error => {
                        setButtonState(generateLinkBtn, 'Generation Failed', originalTexts.generate);
                    });
            });

            saveLinkBtn.addEventListener('click', function() {
                const linkToSave = trackingLinkInput.value;

                if (!linkToSave) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please provide a valid link.',
                    });
                    return;
                }

                setButtonState(saveLinkBtn, 'Saving...');
                fetch('/save-tracking-link', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                        },
                        body: JSON.stringify({
                            link: linkToSave,
                        }),
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.text().then(errorHtml => {
                                $('body').html(errorHtml);
                                throw new Error(
                                    'An error occurred. Check the displayed error for details.'
                                    );
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            setButtonState(saveLinkBtn, 'Saved', originalTexts.save);
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: data.message,
                            });

                            trackingLinkInput.value = '';
                        } else {
                            setButtonState(saveLinkBtn, 'Save Failed', originalTexts.save);
                            Swal.fire({
                                icon: 'error',
                                title: 'Save Failed',
                                text: data.message,
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error.message);
                        setButtonState(saveLinkBtn, 'Save Failed', originalTexts.save);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: error.message,
                        });
                    });
            });

            copyLinkBtn.addEventListener('click', function() {
                const linkToCopy = trackingLinkInput.value;

                if (!linkToCopy) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please provide a valid link to copy.',
                    });
                    return;
                }

                setButtonState(copyLinkBtn, 'Copying...');
                navigator.clipboard.writeText(linkToCopy)
                    .then(() => {
                        setButtonState(copyLinkBtn, 'Copied', originalTexts.copy);
                    })
                    .catch(err => {
                        setButtonState(copyLinkBtn, 'Copy Failed', originalTexts.copy);
                    });
            });

            function setButtonState(button, state, resetState = null) {
                button.innerHTML = state;
                button.disabled = state !== originalTexts.generate && state !== originalTexts.save && state !==
                    originalTexts.copy;

                // Reset button text to the original after 2 seconds
                if (resetState) {
                    setTimeout(() => {
                        button.innerHTML = resetState;
                        button.disabled = false;
                    }, 2000);
                }
            }
        });
    </script>


    </div>
    </div><!-- end app-content-->
    </div>
@endsection
@section('js')
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
    <!--Newsticker js-->
    <script src="{{ URL::asset('assets/plugins/newsticker/newsticker.js') }}"></script>
    <script src="{{ URL::asset('assets/js/newsticker.js') }}"></script>
    <!--Select2 js -->
    <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!-- P-scroll js-->
    <script src="{{ URL::asset('assets/plugins/p-scrollbar/p-scrollbar.js') }}"></script>
    <!-- Index js-->
    <script src="{{ URL::asset('assets/js/index5.js') }}"></script>
@endsection
