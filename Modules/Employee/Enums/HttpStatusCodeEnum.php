<?php

namespace Modules\Employee\Enums;

use Modules\Employee\Traits\EnumIterable;

enum HttpStatusCodeEnum : int
{
    use EnumIterable;

    case Success = 200;
    case Created = 201;
    case BadRequest = 400;
    case TooManyRequests = 429;
    case UnAuthorized = 401;
    case Forbidden = 403;
    case NotFound = 404;
    case NotSupportedMethod = 405;
    case InternalServerError = 500;
    case UnavailableServer = 503;
    case Timeout = 504;
}
