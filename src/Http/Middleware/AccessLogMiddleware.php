<?php

namespace Carcara\SystemLog\Http\Middleware;

use Carcara\SystemLog\Services\AccessLogService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AccessLogMiddleware
{
    protected AccessLogService $logAccessService;
    public function __construct(AccessLogService $logAccessService)
    {
        $this->logAccessService = $logAccessService;
    }

    public function handle(Request $request, Closure $next): Response
    {
        if (!config('access-log.enabled')) {
            return $next($request);
        }

        $response = $next($request);

        $shouldLog = false;
        if (!Auth::check()) {
            $shouldLog = true;
        } else {
            if (!$request->isMethod('get')) {
                $shouldLog = true;
            }
        }

        if ($shouldLog) {
            $logDetails = $this->prepareLogDetails($request, $response);

            $this->logAccessService->storeLogDatabase(
                $request,
                $response->getStatusCode(),
                $response,
                $logDetails
            );
        }

        return $response;
    }


    private function prepareLogDetails(Request $request, Response $response): array
    {
        $infoTrait = app()->has('model_logs') ? app('model_logs') : [];
        $status = $response->getStatusCode();

        if ($status >= 400 || $request->isMethod('get') || empty($infoTrait)) {
            return [
                'change_log' => '[]',
                'before_log' => '[]',
                'after_log'  => '[]',
            ];
        }

        return $infoTrait;
    }
}

        // $infoTrait = app()->has('model_logs') ? app('model_logs') : [];
