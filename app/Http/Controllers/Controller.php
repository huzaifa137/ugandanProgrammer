<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public static function totalRows($table, $column="", $column_value=""){

        if(empty($column))
			$sql = ("SELECT * FROM $table");
		else
			$sql = ("SELECT * FROM $table WHERE $column = '$column_value'");

		$row = DB::select($sql);

		return count($row);
	}

}
