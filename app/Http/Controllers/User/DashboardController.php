<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            Session::put('top_menu',"dashboard");
            Session::put('sub_menu',"dashboard");
            return $next($request);
        });
    }
   public function index()
    {
        return view("user.dashboard.dashboard");
    }
}
