<?php

namespace Vendor\SystemLog\Repositories\Contracts;

interface AccessLogRepositoryInterface
{
    /**
     * Cria um novo registro de log.
     *
     * @param array $data Os dados a serem registrados.
     * @return void
     */
    public function create(array $data): void;
}