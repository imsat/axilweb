<?php

namespace Modules\PreOrder\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    public function response($success = true, $message = null, $code = 200, $data = null, $errors = null): JsonResponse
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'code' => $code,
            'data' => $data,
            'errors' => $errors,
        ], $code);
    }
}
