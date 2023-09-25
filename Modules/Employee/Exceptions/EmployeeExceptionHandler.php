<?php

namespace Modules\Employee\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Employee\Enums\HttpStatusCodeEnum;
use Modules\Employee\Traits\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
class EmployeeExceptionHandler extends ExceptionHandler
{
    use Response;

    /**
     * @param $request
     * @param Throwable $e
     * @return mixed
     * @throws Throwable
     */
    public function render($request, Throwable $e): mixed
    {
        if ($request->wantsJson())
            return match ($e::class){
            QueryException::class => $this->errorMessage(message: @trans('employee::messages.invalid_query_parameters'), errorHttpCode: HttpStatusCodeEnum::BadRequest, shouldThrow: false),
            NotFoundHttpException::class,
            ModelNotFoundException::class => $this->errorMessage( message: @trans('employee::messages.not_found'), errorHttpCode: HttpStatusCodeEnum::NotFound, shouldThrow: false),
            ThrottleRequestsException::class => $this->errorMessage(message: @trans('employee::messages.to_many_requests'), errorHttpCode: HttpStatusCodeEnum::TooManyRequests, shouldThrow: false),
            default => $this->errorMessage(shouldThrow: false)
        };

        return parent::render($request,$e);
    }
}
