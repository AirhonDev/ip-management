<?php

namespace App\Services;

use App\Repositories\IpAddress\Dto\IpAddressDto;
use App\Repositories\IpAddress\IpAddressRepositoryInterface;
use Illuminate\Http\Request;

class IpAddressService
{
    protected $ipAddressRepository;

    public function __construct(IpAddressRepositoryInterface $ipAddressRepository)
    {
        $this->ipAddressRepository = $ipAddressRepository;
    }

    public function create(Request $request)
    {
        $dto = new IpAddressDto;

        $dto->ip = $request->ip_address;
        $dto->label = $request->label;
        $dto->user = auth()->user();

        return $this->ipAddressRepository->insertIpWithLabel($dto);
    }
}
