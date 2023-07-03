<?php

namespace App\Repositories\AuditLog;

use App\Models\AuditLog;
use App\Repositories\AuditLog\Dto\AuditLogFiltersDto;

class AuditLogRepository implements AuditLogRepositoryInterface
{
    public function fetchWithPagination(AuditLogFiltersDto $dto)
    {
        return AuditLog::paginate($dto->per_page);
    }
}
