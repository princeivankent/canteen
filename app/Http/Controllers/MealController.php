<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class MealController extends Controller
{
    public function get_meal_allowance($employee_id)
    {
        $query = DB::connection('canteen')
            ->table('users_meal_allowance_tbl')
            ->select('meal_allowance')
            ->whereUserId($employee_id)
            ->first();

        return response()->json($query);
    }
}
