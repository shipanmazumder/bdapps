<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\InstallApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use PDF;
class FaqController extends Controller
{
    public function __construct()
    {

        $this->middleware(function ($request, $next) {
            Session::put('top_menu',"faq");
            Session::put('sub_menu',"faq");
            return $next($request);
        });
    }
    public function index()
    {
//        $this->data['app_name']=InstallApp::where("user_id",Auth::user()->id);
        return view("user.faq.faq");
    }

    public function faqGenerator(Request $request)
    {
//        dd($request->all());
        $data=$request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string'],
            'app_name' => ['required', 'string'],
            'app_id' => ['required', 'string'],
            'sms_keyword' => ['required', 'string'],
            'ussd_code' => ['required', 'string'],
            'long_desc' => ['required', 'string'],
            'short_desc' => ['required', 'string'],
       ]);
        $pdf = PDF::loadView('user.faq.faqgenerate', $data);
        return  $pdf->download($data['app_name'].'.pdf');
    }
}
