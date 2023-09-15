<?php
namespace Modules\Employee\Traits;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Modules\Employee\Enums\HttpStatusCodeEnum;

trait Response
{
    /**
     * @param string $message
     * @param HttpStatusCodeEnum|null $errorHttpCode
     * @return mixed
     */
    public function errorResponse(string $message, ?HttpStatusCodeEnum $errorHttpCode = null): mixed
    {
        throw new HttpResponseException(response()->json([
            'message'=> $message
        ],$errorHttpCode->value ?? HttpStatusCodeEnum::BadRequest->value));
    }


    /**
     * @param string $message
     * @return JsonResponse
     */
    public function successResponse(string $message): JsonResponse
    {
        return response()->json([
            'message'=> $message,
        ], HttpStatusCodeEnum::Success->value);
    }

    /**
     * @param string $message
     * @param array $data
     * @return JsonResponse
     */
    public function dataResponse(string $message, array $data): JsonResponse
    {
        return response()->json([
            'message'=> $message,
            'data'=> $data,
        ], HttpStatusCodeEnum::Success->value);
    }
}
