<?php

namespace App\Http\Controllers\IpAddress;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetIpAddressRequest;
use App\Http\Requests\IpRequest;
use App\Http\Requests\UpdateIpRequest;
use App\Http\Resources\IpAddressResource;
use App\Models\IpAddress;
use App\Models\IpAddressLabel;
use App\Services\IpAddressService;

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


    public function index(GetIpAddressRequest $request)
    {
        $collection = $this->service->fetchWithPagination($request);

        return IpAddressResource::collection($collection);
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

    /**
     * Update Ip Or Label
     *
     * @param  \Illuminate\Http\Request $request
     * @param  IpAddress $ipAddress
     * @param  IpAddressLabel $label
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIpRequest $request, IpAddress $ipAddress, IpAddressLabel $label = null)
    {
        $ipAddress = $this->service->update($request, $ipAddress, $label);

        return new IpAddressResource($ipAddress);
    }
}
