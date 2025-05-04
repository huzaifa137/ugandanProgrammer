<?php
namespace App\Http\Controllers;

use DB;
use Session;

class Helper extends Controller
{

    public static function user_id()
    {
        return $user = Session::get('LoggedAdmin');
    }

    public static function instructor_name($user = "")
    {
        $user  = (int) $user;
        $admin = DB::table('users')->where('id', '=', $user)->where('user_role', '!=', 1)->first();

        return $user = @$admin->firstname . ' ' . @$admin->lastname;
    }

    public static function student_name($user = "")
    {
        $user  = (int) $user;
        $admin = DB::table('users')->where('id', '=', $user)->where('user_role', 1)->first();

        return $user = @$admin->firstname . ' ' . @$admin->lastname;
    }

    public static function category_name($user = "")
    {
        $user  = (int) $user;
        $admin = DB::table('users')->where('id', '=', $user)->where('user_role', '!=', 1)->first();

        return $user = @$admin->firstname . ' ' . @$admin->lastname;
    }

    public static function language_name($user = "")
    {
        $user  = (int) $user;
        $admin = DB::table('users')->where('id', '=', $user)->where('user_role', '!=', 1)->first();

        return $user = @$admin->firstname . ' ' . @$admin->lastname;
    }

    public static function active_user()
    {

        $admin       = DB::table('users')->where('id', '=', Session('LoggedAdmin'))->first();
        return $user = @$admin->firstname . ' ' . @$admin->lastname;
    }

    public static function item_md_name($md_id)
    {
        $md_name = DB::table('master_datas')
            ->where('md_id', $md_id)
            ->value('md_name');

        return $md_name;
    }

    public static function item_md_id($md_name)
    {
        $md_id = DB::table('master_datas')
            ->where('md_name', $md_name)
            ->value('md_id');

        return $md_id;
    }

    public static function course_information($course_id)
    {
        $courseName = DB::table('courses')
            ->where('id', $course_id)
            ->value('title');

        return $courseName;
    }



    // public static function quiz_information($course_id,$Lesson_id,$module_id,$type_category)
    // {

    //     dd($type_category);

    //     $courseName = DB::table('courses')
    //         ->where('id', $course_id)
    //         ->value('title');

    //     return $courseName;
    // }


    
    public static function DropMasterData($code_id = "", $selected = "", $id = "", $part = 2, $disabled = 0)
    {

        if (! $code_id) {
            $select = DB::table("master_datas")->get();
        } else {
            $select = DB::table("master_datas")->where("md_master_code_id", $code_id)->orderBy("md_name", "asc")->get();
        }

        $disabled = ($disabled) ? "disabled" : "";

        $string = "";
        $string .= '<select name="' . $id . '" id="' . $id . '" class="form-control" ' . $disabled . '>';
        $string .= '<option value=""> -- Select -- </option>';
        foreach ($select as $row) {
            if ($part == 1) {
                if ($row->md_id == $selected) {
                    $string .= '<option selected value="' . $row->md_id . '">' . $row->md_name . '</option>';
                } else {
                    $string .= '<option value="' . $row->md_id . '">' . $row->md_name . '</option>';
                }

            } else if ($part == 2) {
                if ($row->md_id == $selected) {
                    $string .= '<option selected value="' . $row->md_id . '">' . $row->md_name . ' (' . $row->md_code . ')</option>';
                } else {
                    $string .= '<option value="' . $row->md_id . '">' . $row->md_name . ' (' . $row->md_code . ')</option>';
                }

            }
        }

        $string .= '</select>';

        return $string;
    }

}
