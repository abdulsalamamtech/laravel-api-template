<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

Trait ApiHttpResponse {

    public function sendSuccess($data =[], $message = null, $status = 200) : JsonResponse
    {

        return response()->json([
            'success' => true,
            'message' => $message ?? 'successful',
            'data' => $data,
        ], $status);

    }
    public function sendError($data =[], $message = null, $status = null) : JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message ?? 'they was an error',
            'errors' => $data,
        ], $status);

    }

}
