<?php

namespace App\Services;

use App\Models\IpAddress;
use App\Models\IpAddressLabel;
use App\Repositories\IpAddress\Dto\IpAddressDto;
use App\Repositories\IpAddress\Dto\IpAddressDtoFilters;
use App\Repositories\IpAddress\IpAddressRepositoryInterface;
use Illuminate\Http\Request;

class IpAddressService
{
    protected $ipAddressRepository;

    public function __construct(IpAddressRepositoryInterface $ipAddressRepository)
    {
        $this->ipAddressRepository = $ipAddressRepository;
    }

    public function fetchWithPagination(Request $request)
    {
        $dto = new IpAddressDtoFilters;

        $dto->per_page = $request->per_page;

        return $this->ipAddressRepository->fetchWithPagination($dto);
    }

    public function create(Request $request)
    {
        $dto = new IpAddressDto;

        $dto->ip = $request->ip_address;
        $dto->label = $request->label;
        $dto->user = auth()->user();

        return $this->ipAddressRepository->create($dto);
    }

    public function update(Request $request, IpAddress $ipAddress, IpAddressLabel $label = null)
    {
        $dto = new IpAddressDto;

        $dto->ip = $request->ip_address;
        $dto->label = $request->label;
        $dto->user = auth()->user();

        return $this->ipAddressRepository->updateIpOrLabel($dto, $ipAddress, $label);
    }
}
