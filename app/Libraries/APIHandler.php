<?php

/**
 * Created by PhpStorm.
 * User: jidesakin
 * Date: 12/21/15
 * Time: 5:07 PM
 */
namespace App\Libraries;


class APIHandler
{

    /**
     * Format API response
     * @param $status
     * @param $message
     * @param array $mainData
     * @param int $httpResponse
     * @param string $token
     * @return Response
     */
    public static function response($status, $message, $mainData = [], $httpResponse = 200, $token = null)
    {
        // Set response data
        $data['meta'] = [
            'status' => $status,
            'message' => $message
        ];

        $data['data'] = $mainData;

        // return the JSON formatted response
        return response()->json($data, $httpResponse)->header('token', $token);
    }
}