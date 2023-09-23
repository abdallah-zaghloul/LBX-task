<?php
namespace Modules\Employee\Traits;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Modules\Employee\Enums\HttpStatusCodeEnum;

trait Response
{

    /**
     * @param array $errors
     * @param string|null $message
     * @param HttpStatusCodeEnum|null $errorHttpCode
     * @return mixed
     */
    public function errorResponse(array $errors, ?string $message = null , ?HttpStatusCodeEnum $errorHttpCode = null): mixed
    {
        throw new HttpResponseException(response()->json([
            'status'=> false,
            'message'=> $message ?? @trans('employee::messages.bad_request'),
            'errors'=> $errors,
        ],$errorHttpCode->value ?? HttpStatusCodeEnum::BadRequest->value));
    }


    /**
     * @param string|null $message
     * @return JsonResponse
     */
    public function successResponse(?string $message = null): JsonResponse
    {
        return response()->json([
            'status'=> true,
            'message'=> $message ?? @trans('employee::messages.success'),
        ], HttpStatusCodeEnum::Success->value);
    }

    /**
     * @param array $data
     * @param string|null $message
     * @return JsonResponse
     */
    public function dataResponse(array $data, ?string $message = null): JsonResponse
    {
        return response()->json([
            'status'=> true,
            'message'=> $message ?? @trans('employee::messages.success'),
            'data'=> $data,
        ], HttpStatusCodeEnum::Success->value);
    }


    /**
     * @param string|null $message
     * @param HttpStatusCodeEnum|null $errorHttpCode
     * @return mixed
     */
    public function errorMessage(?string $message = null , ?HttpStatusCodeEnum $errorHttpCode = null): mixed
    {
        throw new HttpResponseException(response()->json([
            'status'=> false,
            'message'=> $message ?? @trans('employee::messages.unavailable_server'),
        ],$errorHttpCode->value ?? HttpStatusCodeEnum::UnavailableServer->value));
    }

}
