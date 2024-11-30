<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helper;
use App\Models\AuditTrail;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Session;

class AuditTrailController extends Controller
{
    public static $page = "AUDIT TRAIL";

    public static function links()
    {
        return $links = array(
            array(
                "link_name" => "Today's Audit Trail",
                "link_address" => "audit-trail/today",
                "link_icon" => "fa-calendar",
                "link_page" => self::$page,
                "link_right" => "V",
            ),
            array(
                "link_name" => "Audit Report",
                "link_address" => "audit-trail/audit-report",
                "link_icon" => "fa-search",
                "link_page" => self::$page,
                "link_right" => "V",
            ),
        );
    }

    public static function ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }

    public static function browser()
    {
        $browser = ""; //get_browser(null, true);
        $browser = ""; //"Browser: ".$browser['browser'].' Version: '.$browser['version']. ' Platform: '.$browser['platform'];

        return $browser;
    }

    public static function register($action, $description)
    {

        $user = Session::get('LoggedAdmin');
        $admin = User::where('id', '=', $user)->first();

        $user = @$admin->firstname . ' ' . @$admin->lastname;

        $audit_trail = new AuditTrail;

        $audit_trail->at_action = $action;
        $audit_trail->at_description = $description;
        $audit_trail->at_ip_address = self::ip();
        $audit_trail->at_browser = self::browser();
        $audit_trail->at_username = $user;
        $audit_trail->at_date_added = time();
        $audit_trail->at_section = config('constants.options.COMPANY_INVITING');

        $audit_trail->save();
    }

    public function today()
    {

        $start_date = strtotime(date('Y-m-d') . ' 12:00:00 am');
        $end_date = time();

        $sd = ['sd' => Helper::date_fm($start_date)];
        $ed = Helper::date_fm($end_date);

        $data = ['LoggedUserAdmin' => User::where('id', '=', session('LoggedAdmin'))->first()];

        $audit = DB::table('audit_trails')->whereBetween('at_date_added', [$start_date, $end_date])->Paginate(100);

        return view('audit-trail.audit-trail', compact('audit'), $data, $sd);

    }

    public function auditReport()
    {
        $start_date = strtotime(date('Y-m-d') . ' 12:00:00 am');
        $end_date = time();

        $sd = Helper::date_fm($start_date);
        $ed = Helper::date_fm($end_date);

        $data = ['LoggedUserAdmin' => User::where('id', '=', session('LoggedAdmin'))->first()];

        $actions_list = DB::table('audit_trails')->distinct()->pluck('at_action');
        $users = DB::table('audit_trails')->distinct()->pluck('at_username');

        $pageNumbers = Helper::activePageNumber();
        $audit = DB::table('audit_trails')->whereBetween('at_date_added', [$start_date, $end_date])->Paginate($pageNumbers); //->where('at_created_at','>=',$start_time)->where('at_created_at','<=', $end_time);

        return view('audit-trail.audit-trail-report2', $data, compact(['audit', 'actions_list', 'users', 'sd', 'ed']));
    }

    public function filterAuditReport(Request $request)
    {

        $performed_by = $request->performedBy;
        $action = $request->action;
        $date = $request->dateRange;

        $date = explode('-', $date);

        if (@$date[0]) {
            $start_date = strtotime(@$date[0] . ' 12:00:00 am');
        } else {
            $start_date = strtotime(date('Y-m-d') . ' 12:00:00 am');
        }

        if (@$date[1]) {
            $end_date = strtotime(@$date[1] . ' 11:59:59 pm');
        } else {
            $end_date = time();
        }

        $select = DB::table('audit_trails');
        if ($performed_by) {
            $select = $select->where('at_username', '=', $performed_by);
        }

        if ($action) {
            $select = $select->where('at_action', '=', $action);
        }

        if ($start_date) {
            $select = $select->whereBetween('at_date_added', [$start_date, $end_date]);
        }

        $select = $select->get();

        if (!count($select)) {
            Helper::warning("No Data to display");
        } else {

            echo '<table id="table" border="1" cellspacing="0" style="font-size:10px;">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>No.</th>';
            echo '<th>Date</th>';
            echo '<th>Action</th>';
            echo '<th>Description</th>';
            echo '<th>By</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            $count = 1;
            foreach ($select as $row) {
                echo '<tr>';
                echo '<td>' . ($count++) . '.</td>';
                echo '<td>' . Helper::date_fm($row->at_date_added) . '</td>';
                echo '<td>' . $row->at_action . '</td>';
                echo '<td>' . $row->at_description . '</td>';
                echo '<td>' . $row->at_username . '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';

        }
    }


}
