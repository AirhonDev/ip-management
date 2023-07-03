<?php

namespace App\Http\Controllers\AuditLog;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetAuditLogRequest;
use App\Http\Resources\AuditLogResource;
use App\Services\AuditLogService;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    private AuditLogService $service;

    /**
     * Display a listing of the resource.
     *
     *  @param AuditLogService $service
     */
    public function __construct(AuditLogService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GetAuditLogRequest $request)
    {
        $collection = $this->service->fetchWithPagination($request);

        return AuditLogResource::collection($collection);
    }
}
