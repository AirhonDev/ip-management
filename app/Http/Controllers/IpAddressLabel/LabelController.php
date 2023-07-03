<?php

namespace App\Http\Controllers\IpAddressLabel;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetLabelsRequest;
use App\Http\Requests\IpAddressLabelRequest;
use App\Http\Resources\IpAddressLabelResource;
use App\Models\IpAddress;
use App\Services\IpAddressLabelService;
use Illuminate\Http\Request;

class LabelController extends Controller
{

    private IpAddressLabelService $service;

    /**
     * Display a listing of the resource.
     *
     *  @param IpAddressService $service
     */
    public function __construct(IpAddressLabelService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GetLabelsRequest $request)
    {
        $collection = $this->service->fetchWithPagination($request);

        return IpAddressLabelResource::collection($collection);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IpAddressLabelRequest $request, IpAddress $ipAddress)
    {
        $ipAddressLabel = $this->service->create($request, $ipAddress);

        return new IpAddressLabelResource($ipAddressLabel);
    }
}
