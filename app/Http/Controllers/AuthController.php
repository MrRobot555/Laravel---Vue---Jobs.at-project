<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function sign(Request $request)
    {
        $users = DB::table('users')
                ->where('email', '=', $request->input('email'))
                ->where('password', '=', $request->input('password'))
                ->get();
        return $users;      
    }
}
