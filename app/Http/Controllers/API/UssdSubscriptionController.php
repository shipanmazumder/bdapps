<?php

namespace App\Http\Controllers\API;

use App\Http\Components\BDAppsApi;
use App\Http\Components\MoUssdReceiver;
use App\Http\Controllers\Controller;
use App\Models\InstallApp;
use App\Models\SubscriptionData;
use Illuminate\Http\Request;
use InvalidArgumentException;

class UssdSubscriptionController extends Controller
{
    public function index(Request $request)
    {
        try {
            $receiver = new MoUssdReceiver($request->json()->all());
        } catch (InvalidArgumentException $exception) {
            return response()->json([
                'statusCode' => 'E1312',
                'statusDetail' => $exception->getMessage(),
            ], 422);
        }

        if ($receiver->getUssdOperation() == "mo-init") {
            $appId = $receiver->getApplicationId();
            $app_pass = InstallApp::where('app_id', $appId)->first();
            if ($app_pass) {
                $api = new BDAppsApi;
                $api->app_id = $appId;
                $api->password = $app_pass->password;
                $api->destinationAddress = $receiver->getAddress();
                $api->sessionId = $receiver->getSessionId();
                $api->ussdOperation = "mt-fin";
                $api->version = $receiver->getVersion();
                $api->subscriberId = $receiver->getAddress();
                $check_status = $api->getstatus();
                $response = "";
                $check_status = json_decode($check_status);
                if ($check_status->subscriptionStatus == "REGISTERED") {
                    $api->ussdresposemessage = "You already register";
                    $response = $api->ussdSend();
                } else {
                    $api->ussdresposemessage = "You will get a confirmation sms.";
                    $response = $api->ussdSend();
                    $api->subscribe();
                    $subscribe = new SubscriptionData;
                    $subscribe->app_id = $receiver->getApplicationId();
                    $subscribe->subscribe_id = $receiver->getAddress();
                    $subscribe->save();
                }

                return $response;
            }
        }

        return response()->json([
            'statusCode' => 'S1000',
            'statusDetail' => 'Success',
        ]);
    }
}
