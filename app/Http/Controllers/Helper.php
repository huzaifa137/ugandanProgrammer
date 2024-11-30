<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attachment;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PDF;
use Session;
class Helper extends Controller
{

    public static function user_id()
    {
        return $user = Session::get('LoggedAdmin');
    }

    public static function trim_all($str, $what = null, $with = ' ')
    {
        if ($what === null) {
            //  Character      Decimal      Use
            //  "\0"            0           Null Character
            //  "\t"            9           Tab
            //  "\n"           10           New line
            //  "\x0B"         11           Vertical Tab
            //  "\r"           13           New Line in Mac
            //  " "            32           Space

            $what = "\\x00-\\x20"; //all white-spaces and control chars
        }

        return trim(preg_replace("/[" . $what . "]+/", $with, $str), $what);
    }

    public static function formatIcon($file_name)
    {
        $format = strtolower(@end(@explode('.', $file_name)));

        if ($format == 'pdf') {
            $icon = 'file-pdf-o text-danger';
        } else if ($format == 'zip') {
            $icon = 'file-zip-o text-danger';
        } else if ($format == 'xls' || $format == 'xlsx') {
            $icon = 'file-excel-o text-secondary text-success';
        } else if ($format == 'doc' || $format == 'docx') {
            $icon = 'file-word-o text-primary';
        } else if ($format == 'xml text-success') {
            $icon = 'file-xml';
        } else if ($format == 'ppt') {
            $icon = 'file-ppt';
        } else if ($format == 'png') {
            $icon = 'file-image';
        } else if ($format == 'gif') {
            $icon = 'file-image';
        } else if ($format == 'jpg' || $format == 'jpeg') {
            $icon = 'file-image';
        } else if ($format == 'csv') {
            $icon = 'file-csv text-success';
        } else {
            $icon = 'file';
        }

        return '<i class="fa fa-' . $icon . '"></i> ';
    }

    public static function date_fm($time)
    {
        $time = (int) $time;

        if (empty($time) || $time < 1000) {
            return "";
        }

        return "" . date("M dS Y, H:i:s ", $time);
    }

    public static function activePageNumber()
    {
        $active = (int) (Session::get('pageNumbers')) ? Session::get('pageNumbers') : 20;

        return $active;
    }

    public static function warning($message)
    {
        ?>
        <div class="alert alert-warning alert-dismissable">
            <a class="close" data-dismiss="alert">×</a>
            <strong><?php echo $message; ?></strong>
        </div>
    <?php
}

    public static function full_name($user = "")
    {
        $user = (int) $user;
        $admin = DB::table('users')->where('id', '=', $user)->first();

        return $user = @$admin->firstname . ' ' . @$admin->lastname;
    }

    public static function active_user()
    {
        
        $admin = DB::table('users')->where('id', '=', Session('LoggedAdmin'))->first();
        return $user = @$admin->firstname . ' ' . @$admin->lastname;
    }

    

}
