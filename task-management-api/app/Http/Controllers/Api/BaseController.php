<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * Send a success response.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @param  int  $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendSuccess($data = null, $message = 'Success', $code = 200)
    {
        return ApiResponse::success($data, $message, $code);
    }

    /**
     * Send an error response.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  mixed  $errors
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendError($message = 'Error', $code = 400, $errors = null)
    {
        return ApiResponse::error($message, $code, $errors);
    }
}