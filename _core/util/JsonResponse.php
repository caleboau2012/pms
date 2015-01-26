<?php

class JsonResponse
{
    const STATUS_OK = 1;
    const STATUS_ERROR = 2;
    const STATUS_ACCESS_DENIED = 3;
    const STATUS_NO_DATA = 4;
    const STATUS_JSON_FAIL = "fail";
    const STATUS_JSON_ERROR = "error";
    const STATUS_JSON_SUCCESS = "success";

    const P_STATUS = 'status';
    const P_DATA = 'data';
    const P_MESSAGE = 'message';
    const P_ACCESS_TOKEN = 'access_token';


    /**
     * @param array $data
     * @param bool $is_json
     * @return string
     */
    public static function success($data, $is_json = true)
    {
        $output = array(JsonResponse::P_STATUS => JsonResponse::STATUS_OK, JsonResponse::P_DATA => $data);

        $handle = new JsonResponse();
        return $handle->package($output, $is_json);
    }

    /**
     * @param string $access_token
     * @param array $data
     * @param bool $is_json
     * @return string
     */
    public static function successWithToken($access_token, $data, $is_json = true)
    {
        $output = array(JsonResponse::P_STATUS => JsonResponse::STATUS_OK, JsonResponse::P_ACCESS_TOKEN => $access_token, JsonResponse::P_DATA => $data);

        $handle = new JsonResponse();
        return $handle->package($output, $is_json);
    }

    public static function error($message)
    {
        $output = array(JsonResponse::P_STATUS => JsonResponse::STATUS_ERROR, JsonResponse::P_MESSAGE => $message);

        $handle = new JsonResponse();
        return $handle->package($output, true);
    }

    public static function errorWithToken($access_token, $message)
    {
        $output = array(JsonResponse::P_STATUS => JsonResponse::STATUS_ERROR, JsonResponse::P_ACCESS_TOKEN => $access_token, JsonResponse::P_MESSAGE => $message);

        $handle = new JsonResponse();
        return $handle->package($output, true);
    }

    public static function accessDenied()
    {
        $output = array(JsonResponse::P_STATUS => JsonResponse::STATUS_ACCESS_DENIED, JsonResponse::P_MESSAGE => 'Access Denied!');

        $handle = new JsonResponse();
        return $handle->package($output, true);
    }

    public static function noData()
    {
        $output = array(JsonResponse::P_STATUS => JsonResponse::STATUS_NO_DATA, JsonResponse::P_MESSAGE => 'No Data!');

        $handle = new JsonResponse();
        return $handle->package($output, true);
    }

    public static function message($status, $message)
    {
        $output = array(JsonResponse::P_STATUS => $status, JsonResponse::P_MESSAGE => $message);

        $handle = new JsonResponse();
        return $handle->package($output, true);
    }

    private function package($output, $is_json)
    {
        if ($is_json) {
            return json_encode($output);
        } else {
            return $output;
        }
    }


}