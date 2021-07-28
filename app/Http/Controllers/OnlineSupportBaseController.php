<?php


namespace App\Http\Controllers;


class OnlineSupportBaseController extends Controller
{
    /**
     * output unique response for all request
     * @param array $data
     * @param int $code
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function response(array $data = [], int $code, $message = "")
    {
        return response()->json([
            'data' => $data,
            'status_code' => $code,
            'message' => $message
        ], $code);
    }
}
