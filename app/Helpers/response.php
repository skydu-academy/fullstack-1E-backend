<?php
   // Response
   class ResponseHelper{

    const SUCCESS         = "success";
    const ERROR           = "error";
    const UNAUTHORIZED    = "unauthorized";
    const MESSAGE         = "message";

    public static function handleRepsonse($data, $response = null)
    {
        switch ($response) {
            case ResponseHelper::ERROR:
                return ResponseHelper::handleMessageResponse($response, $data, 401);
                break;
            case ResponseHelper::MESSAGE:
                return ResponseHelper::handleMessageResponse($response, $data, 200);
                break;
            case ResponseHelper::UNAUTHORIZED:
                return ResponseHelper::handleMessageResponse($response, $data, 403);
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
