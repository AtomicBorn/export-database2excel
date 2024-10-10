<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;

class ExportFile extends Controller
{
    public static function export(Request $request){
        $employee = DB::table('employee')->get();
        $filename = "employees-masterlist.csv";


        $header = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"'
        ];
        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['EEID', 'Full Name', 'Job Title', 'Department', 'Business Unit', 'Gender', 
                            'Ethnicity', 'Age', 'Hire Date', 'Annual Salary', 'Bonus %', 'Country', 'City']);

        foreach($employee as $user) {
            fputcsv($handle, [$user->EeId, $user->full_name, $user->job_title, $user->department, $user->business_unit, $user->gender, 
                                $user->ethnicity, $user->age, $user->hire_date, $user->annual_salary, $user->bonus, $user->country, $user->city]);

        }
        fclose($handle);

        return Response::make('', 200, $header);
    }
}
