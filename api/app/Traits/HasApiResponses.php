<?php

namespace App\Traits;

use Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as Res;
use Illuminate\Http\Resources\Json\JsonResource;

trait HasApiResponses
{
    protected function respondWithSuccess($message, $data = [], $statusCode = Res::HTTP_OK): JsonResponse
    {
        return Response::json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    protected function respondWithError($message, $data = [], $statusCode = Res::HTTP_BAD_REQUEST): JsonResponse
    {
        return Response::json([
            'success' => false,
            'message' => $message,
            'error' => $data,
        ], $statusCode);
    }

    // protected function responseForCollection(JsonResource $jsonResource)
    // {
    //     return $jsonResource->response()->getData(true);
    // }
}
