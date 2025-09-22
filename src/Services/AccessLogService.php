<?php

namespace Vendor\SystemLog\Services;

use Vendor\SystemLog\Factories\LogDataFactory;
use Vendor\SystemLog\Repositories\Contracts\AccessLogRepositoryInterface;

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