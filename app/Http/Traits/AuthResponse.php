<?php

namespace App\Http\Traits;

use App\Models\Student;

trait AuthResponse
{
    protected function success($data, $message = null, $code = 200)
    {
        return response()->json([
            'status' => 'request was successful',
            'message' => $message,
            'data' => $data
        ], $code);
    }
    protected function error($error, $message = null, $code)
    {
        return response()->json([
            'status' => 'error .....',
            'message' => $message,
            'error' => $error
        ], $code);
    }
}
