<?php

namespace Carcara\SystemLog\Services;

use Carcara\SystemLog\Factories\LogDataFactory;
use Carcara\SystemLog\Repositories\Contracts\AccessLogRepositoryInterface;

class AccessLogService
{
    public AccessLogRepositoryInterface $accessLogRepository;
    
    public function __construct(AccessLogRepositoryInterface $accessLogRepository){
        $this->accessLogRepository = $accessLogRepository;
    }

    public function storeLogDatabase( $request, $httpStatus, $response, ?array $infoTrait)
    {
        $logContext = LogDataFactory::create($request, $response, $httpStatus, $infoTrait);
        $this->accessLogRepository->create($logContext);
    }
}