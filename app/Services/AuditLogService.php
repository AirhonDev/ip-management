<?php

namespace App\Services;

use App\Repositories\AuditLog\AuditLogRepositoryInterface;
use App\Repositories\AuditLog\Dto\AuditLogFiltersDto;
use Illuminate\Http\Request;

class AuditLogService
{
    protected $auditLogRepository;

    public function __construct(AuditLogRepositoryInterface $auditLogRepository)
    {
        $this->auditLogRepository = $auditLogRepository;
    }

    public function fetchWithPagination(Request $request)
    {
        $dto = new AuditLogFiltersDto;

        $dto->per_page = $request->per_page;

        return $this->auditLogRepository->fetchWithPagination($dto);
    }
}
