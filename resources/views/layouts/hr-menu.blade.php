<!-- Horizontal-menu -->
<div class="horizontal-main hor-menu clearfix">
    <div class="horizontal-mainwrapper container clearfix">

        <!-- Add Font Awesome CDN link in your <head> -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

        <nav class="horizontalMenu clearfix">
            <ul class="horizontalMenu-list">

                <li aria-haspopup="true">
                    <a href="{{ url('/' . ($page = '#')) }}" class="sub-icon">
                        <!-- FontAwesome Icon for Dashboard -->
                        <i class="fas fa-file-alt hor-icon" style="font-size: 24px; margin-right: 8px;"></i>
                        Dashboard <i class="fa fa-angle-down horizontal-icon"></i>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ url('/tracking/tracking-overview') }}">Phone Tracking </a>
                        </li>
                        <li><a href="{{ url('/tracking/activate-track-link') }}">Active Trackers</a></li>
                    </ul>
                </li>

                <!-- Users Section -->
                <li aria-haspopup="true">
                    <a href="{{ url('/' . ($page = '#')) }}" class="sub-icon">
                        <i class="fas fa-users hor-icon" style="font-size: 24px; margin-right: 8px;"></i>
                        Users <i class="fa fa-angle-down horizontal-icon"></i>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ url('/users/users-register') }}">Register new User</a></li>
                        <li><a href="{{ url('/users/users-information') }}">View users information</a></li>
                    </ul>
                </li>

                <!-- Reports Section -->
                <li aria-haspopup="true">
                    <a href="{{ url('/' . ($page = '#')) }}" class="sub-icon">
                        <!-- FontAwesome Icon for Reports -->
                        <i class="fas fa-chart-bar hor-icon" style="font-size: 24px; margin-right: 8px;"></i>
                        Reports <i class="fa fa-angle-down horizontal-icon"></i>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ url('/audit-trail/today') }}">Activity Reports</a></li>
                        {{-- <li><a href="{{ url('/' . ($page = 'device-reports')) }}">Device Reports</a></li> --}}
                    </ul>
                </li>

                <!-- Settings Section -->
                <li aria-haspopup="true">
                    <a href="{{ url('/' . ($page = '#')) }}" class="sub-icon">
                        <!-- FontAwesome Icon for Settings -->
                        <i class="fas fa-sliders-h hor-icon" style="font-size: 24px; margin-right: 8px;"></i>
                        Settings <i class="fa fa-angle-down horizontal-icon"></i>
                    </a>
                    <ul class="sub-menu">
                        {{-- <li><a href="{{ url('/' . ($page = 'general-settings')) }}">General Settings</a></li>
                        <li><a href="{{ url('/' . ($page = 'app-settings')) }}">App Settings</a></li> --}}
                        <li><a href="{{ url('master-data/master-code-list') }}">Master Code</a></li>
                        <li><a href="{{ url('master-data/master-code-to-data') }}">Master Data</a></li>
                        {{-- <li><a href="{{ url('/' . ($page = 'notification-settings')) }}">Notification Settings</a></li> --}}
                    </ul>
                </li>

            </ul>
        </nav>
        <!--Nav end -->
    </div>
</div>
<!-- Horizontal-menu end -->
