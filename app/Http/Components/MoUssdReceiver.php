<?php


namespace App\Http\Components;

use InvalidArgumentException;

class MoUssdReceiver
{
    private $sourceAddress; // Define required parameters to receive response
    private $message;
    private $requestId;
    private $applicationId;
    private $encoding;
    private $version;
    private $sessionId;
    private $ussdOperation;
    private $vlrAddress;

    /*
        decode the json data an get them to an array
        Get data from Json objects
        check the validity of the response
    **/

    public function __construct(array $array = null){
        if ($array === null) {
            $decoded = json_decode(file_get_contents('php://input'), true);
            $array = is_array($decoded) ? $decoded : [];
        }

        $this->sourceAddress = $array['sourceAddress'] ?? null;
        $this->message = $array['message'] ?? null;
        $this->requestId = $array['requestId'] ?? null;
        $this->applicationId = $array['applicationId'] ?? null;
        $this->encoding = $array['encoding'] ?? null;
        $this->version = $array['version'] ?? null;
        $this->sessionId = $array['sessionId'] ?? null;
        $this->ussdOperation = $array['ussdOperation'] ?? null;
        // $this->vlrAddress = $array['vlrAddress'] ?? null;

        if (!$this->sourceAddress || !$this->applicationId || !$this->sessionId || !$this->ussdOperation) {
            throw new InvalidArgumentException('Some of the required parameters are not provided');
        }
    }

    /*
        Define getters to return receive data
    **/

    public function getAddress(){
        return $this->sourceAddress;
    }

    public function getMessage(){
        return $this->message;
    }

    public function getRequestID(){
        return $this->requestId;
    }

    public function getApplicationId(){
        return $this->applicationId;
    }

    public function getEncoding(){
        return $this->encoding;
    }

    public function getVersion(){
        return $this->version;
    }

    public function getSessionId(){
        return $this->sessionId;
    }

    public function getUssdOperation(){
        return $this->ussdOperation;
    }
}
