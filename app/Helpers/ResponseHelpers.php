<?php

namespace App\Helpers;


class ResponseHelpers
{
    public static function success($data, $message = 'Success')
    {
        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public static function error($message = 'Error')
    {
        return response()->json([
            'status' => false,
            'data' => $message
        ], 500);
    }

    public static function send($data, $code = 200, $status = true)
    {
        return response()->json([
            'status' => $status,
            'data' => $data
        ], $code);
    }

    public static function validation($errors)
    {
        return response()->json([
            'status' => false,
            'data' => $errors
        ], 422);
    }

    public static function notFound()
    {
        return response()->json([
            'status' => false,
            'data' => 'Not Found'
        ], 404);
    }
}
