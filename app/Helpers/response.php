<?php
   // Response
   class ResponseHelper{

    const SUCCESS  = "success";
    const ERROR    = "error";

    public static function handleRepsonse($data, $response = null)
    {
        switch ($response) {
            case 'error':
                return ResponseHelper::handleMessageResponse($response, $data, 401);
                break;
            default:
                return ResponseHelper::handleMessageResponse(ResponseHelper::SUCCESS, $data, 200);
                break;
        }
    }
    public static function handleMessageResponse($response_status, $data, $code_status)
    {
        return response()->json([$response_status => $data], $code_status);
    }

   }
