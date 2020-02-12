<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InstallApp extends Model
{
    protected $guarded=[];

    public function user()
    {
        return $this->belongsTo("App\User");
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class,'id');
    }

    public function get_app_details()
    {
        $apps=DB::table("install_apps")->where("user_id",Auth::user()->id)->get();
        $data=array();
        if($apps)
        {
            foreach ($apps as $key=>$value) {
                $data[$key]['id']=$value->id;
                $data[$key]['app_name']=$value->app_name;
                $data[$key]['total_subscriber']=0;
                $where_match=['app_id'=>$value->id,"is_sent"=>0];
                $app_remain_sms=Schedule::where($where_match)->get()->count();
                $data[$key]['app_remain_sms']=$app_remain_sms;
                if($app_remain_sms<=10){
                    $data[$key]['class_name']="danger";
                }else{
                    $data[$key]['class_name']="success";
                }
            }
        }
        return $data;
    }
}
