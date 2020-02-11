<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\InstallApp;
use App\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
class ScheduleController extends Controller
{
   public function __construct()
    {
        $this->middleware(function ($request, $next) {
            Session::put('top_menu',"schedule");
            Session::put('sub_menu',"schedule");
            return $next($request);
        });
    }
    public function index()
    {
        $this->data['app_name']=InstallApp::where("user_id",Auth::user()->id)->get();
        return view("user.schedule.schedule",$this->data);
    }

    public function store(Request $request)
    {
        $app_id=$request->input("app_id");
        $sms_array=$request->input("sms_body");
        $data=array();
        $app_info=Schedule::where("app_id",$app_id)->orderBy("id","desc")->first();
        if($app_info)
        {
            $lastdate=$app_info->content_date;
        }
        else{
              $lastdate=date("Y-m-d",strtotime("-1 day"));
        }
        $i=1;
        foreach ($sms_array as $key=>$value)
        {
            $data[$key]['app_id']=$app_id;
            $data[$key]['content']=strip_tags($value);
            $data[$key]['content_date']=date("Y-m-d",strtotime("+$i day", strtotime($lastdate)));
            $i++;
        }
        Schedule::insert($data);
        return response()->json(['success'=>"Content Upload Successfully"]);
    }

}
