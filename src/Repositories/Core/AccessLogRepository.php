<?php

namespace Vendor\SystemLog\Repositories\File;

use Vendor\SystemLog\Repositories\Contracts\AccessLogRepositoryInterface;
use Illuminate\Support\Facades\Log;


class AccessLogRepository implements AccessLogRepositoryInterface
{
    /**
     * Cria um novo registro de log.
     *
     * @param array $data Os dados a serem registrados.
     * @return void
     */
    public function create(array $data): void
    {
        Log::channel('accesslog')->info('Access Log Recorded', $data);
    }
}