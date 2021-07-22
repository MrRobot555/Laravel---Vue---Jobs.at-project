<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Job;

class HomeController extends Controller
{
    public function index()
    {
        $jobs = DB::select('SELECT jobs.*, companies.id AS comp_id, companies.name FROM jobs LEFT JOIN companies ON jobs.company_id = companies.id');
        return array_reverse($jobs);      
    }
}
