<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Job;

class JobController extends Controller
{
    // TODO
    
    public function getCompanies()
    {
        $companies = Company::all()->toArray();
        return array_reverse($companies);      
    }

    public function store(Request $request)
    {
        $job = new Job([
            'company_id' => $request->input('company'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'location' => $request->input('location'),
            'active' => $request->input('status'),
            'highlighted' => 0,
        ]);
        $job->save();

        return response()->json('Job published successfully!');
    }

    public function highlighting(Request $request)
    {
        if ($request->input('highlighted') == 1) {
            $affected = DB::table('jobs')
              ->where('id', $request->input('id'))
              ->update(['highlighted' => 0]);
            return $affected;
        } else if ($request->input('highlighted') == 0) {
            $affected = DB::table('jobs')
                ->where('id', $request->input('id'))
                ->update(['highlighted' => 1]);
            return $affected;
        }
        
    }


    
}
