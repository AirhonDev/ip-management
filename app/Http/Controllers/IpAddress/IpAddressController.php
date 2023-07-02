<?php

namespace App\Http\Controllers\IpAddress;

use App\Http\Controllers\Controller;
use App\Http\Requests\IpRequest;
use App\Http\Resources\IpAddressResource;
use App\Services\IpAddressService;
use Illuminate\Http\Request;

class IpAddressController extends Controller
{
    private IpAddressService $service;

    /**
     * Display a listing of the resource.
     *
     *  @param IpAddressService $service
     */
    public function __construct(IpAddressService $service)
    {
        $this->service = $service;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(IpRequest $request)
    {
        $ipAddress = $this->service->create($request);

        return new IpAddressResource($ipAddress);
    }
}
