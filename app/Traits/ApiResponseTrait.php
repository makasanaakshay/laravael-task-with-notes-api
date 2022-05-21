<?php

namespace App\Traits;

trait ApiResponseTrait {

    /** this function is used for sending common response for all request */
    public function sendResponse($data, $success = true){
        return response()->json([
            "success" => $success,
            "data" => $data,
        ], $success ? 200 : 202);
    }
}
