<?php

namespace App\Models;

use DB;

class Employee
{
    public function get_user($employee_number, $password)
    {
        $query = DB::table('personal_information_tab as pit')
            ->select(
                'emt.id',
                'emt.employee_no',
                DB::raw('CONCAT(pit.last_name,", ",pit.first_name) as name'),
                'emt.position_title',
                'st.section'
            )
            ->leftJoin('employee_masterfile_tab as emt', 'emt.id', '=', 'pit.employee_id')
            ->leftJoin('password_tab as pwt', 'pwt.employee_id', '=', 'emt.id')
            ->leftJoin('section_tab as st', 'st.id', '=', 'emt.section_id')
            ->where([
                'emt.employee_no' => $employee_number,
                'pwt.password'    => $password
            ])
            ->first();
            
        return $query;
    }
}
