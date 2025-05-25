<!--aside open-->
<div class="app-sidebar app-sidebar2">
    <div class="app-sidebar__logo">
        <a class="header-brand" href="{{ url('/student/dashboard') }}">
            <img src="{{ URL::asset('assets/images/brand/uplogolight.png') }}" alt="Covido logo">
        </a>
    </div>
</div>
<aside class="app-sidebar app-sidebar3">
    <ul class="side-menu" style="margin-top:100px !important;">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <li class="slide">
            <a class="side-menu__item" href="{{ url('/student/dashboard') }}">
                <i class="fa fa-home fa-2x mr-3"></i>
                Dashboard </span></a>
        </li>
        <li class="slide">
            <a class="side-menu__item" href="{{ url('student/profile') }}">
                <i class="fa fa-user fa-2x mr-3"></i>
                Profile</span></a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ url('student/courses-and-lessons') }}">
                <i class="fa fa-book fa-2x mr-3"></i>
                Course Enrollment
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ url('student/lessons-and-study') }}">
                <i class="fa fa-book-open fa-2x mr-3"></i>
                My Lessons
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ url('student/all-preview') }}">
                <i class="fa fa-scroll fa-2x mr-3"></i>
                My Certificates
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ url('student/contact-us') }}">
                <i class="fa fa-address-book fa-2x mr-3"></i>
                Contact Us
            </a>
        </li>


        <li class="slide">
            <a class="side-menu__item" href="#" id="logoutMenu">
                <i class="fa fa-sign-out fa-2x mr-3"></i>
                Logout
            </a>
        </li>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.getElementById('logoutMenu').addEventListener('click', function(event) {
                event.preventDefault();

                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you really want to Logout ?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Logout",
                    cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route('student-logout') }}';
                    }
                });

            });
        </script>


    </ul>
    <div class="app-sidebar-help">
        <div class="dropdown text-center">
            <div class="help d-flex">
                <a href="{{ url('/' . ($page = '#')) }}" class="nav-link p-0 help-dropdown" data-toggle="dropdown">
                    <span class="font-weight-bold">Help Info</span> <i class="fa fa-angle-down ml-2"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow p-4">
                    <div class="border-bottom pb-3">
                        <h4 class="font-weight-bold border-bottom pb-3">UP Support Team</h4>
                        <h5 class="font-weight-bold">Email Addresses</h5>
                        <a class="text-primary d-block" href="{{ url('/' . ($page = '#')) }}">Adminstrator</a>
                        huzaifabukenya227@gmail.com</a>
                        <a class="text-primary d-block"
                            href="{{ url('/' . ($page = '#')) }}">mentorhubtechnologies@gmail.com
                        </a>
                    </div>
                    <div class="border-bottom pb-3 pt-3 mb-3">
                        <h5 class="font-weight-bold">Phone numbers</h5>
                        <p class="mb-1">(+260) 0000000</p>
                        <p class="mb-1">(+260) 0000000</p>
                        <p class="mb-1">(+260) 0000000</p>
                    </div>
                </div>
                <div class="ml-auto">
                    <a class="nav-link icon p-0" href="{{ url('#') }}">
                        <svg class="header-icon" x="1008" y="1248" viewBox="0 0 24 24" height="100%" width="100%"
                            preserveAspectRatio="xMidYMid meet" focusable="false">
                            <path opacity=".3" d="M12 6.5c-2.49 0-4 2.02-4 4.5v6h8v-6c0-2.48-1.51-4.5-4-4.5z"></path>
                            <path
                                d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-11c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2v-5zm-2 6H8v-6c0-2.48 1.51-4.5 4-4.5s4 2.02 4 4.5v6zM7.58 4.08L6.15 2.65C3.75 4.48 2.17 7.3 2.03 10.5h2a8.445 8.445 0 013.55-6.42zm12.39 6.42h2c-.15-3.2-1.73-6.02-4.12-7.85l-1.42 1.43a8.495 8.495 0 013.54 6.42z">
                            </path>
                        </svg>
                        <span class="pulse "></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</aside>
<!--aside closed-->
