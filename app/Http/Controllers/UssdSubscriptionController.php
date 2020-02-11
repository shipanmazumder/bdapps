<?php

namespace App\Http\Controllers\API;

use App\Http\Components\BDAppsApi;
use App\Http\Components\MoUssdReceiver;
use App\Http\Controllers\Controller;
use App\InstallApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UssdSubscriptionController extends Controller
{
    public function __construct()
    {
        $this->receiver=new MoUssdReceiver;
    }
    public function index()
    {
        $this->receiver->getAddress();
        if($this->receiver->getUssdOperation()=="mo-init")
        {
                $appId = $this->receiver->getApplicationId();
                $app_pass = InstallApp::where('app_id', $appId)->first();
                if($app_pass) {
                    $api = new BDAppsApi;
                    $api->app_id = $appId;
                    $api->password = $app_pass->password;
                    $api->ussdresposemessage="You will get a confirmation notification.";
                    $api->destinationAddress = $this->receiver->getAddress();
                    $api->sessionId = $this->receiver->getSessionId();
                    $api->ussdOperation = "mt-fin";
                    $api->version=$this->receiver->getVersion();
                    $api->subscriberId =$this->receiver->getAddress();
                    $api->subscribe();
                    return  $api->ussdSend();
                }
        }
    }
    function loadUssdSender()
    {

    }
}
