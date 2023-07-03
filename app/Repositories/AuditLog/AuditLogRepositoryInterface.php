<?php

namespace App\Repositories\AuditLog;

use App\Repositories\AuditLog\Dto\AuditLogFiltersDto;

interface AuditLogRepositoryInterface
{
    /**
     * @param Request $dto
     * 
     */
    public function fetchWithPagination(AuditLogFiltersDto $dto);
}
