<?php

namespace App\Repositories\IpAddress;

use App\Models\IpAddress;
use App\Models\IpAddressLabel;
use App\Repositories\IpAddress\Dto\IpAddressDto;
use App\Repositories\IpAddress\Dto\IpAddressDtoFilters;

interface IpAddressRepositoryInterface
{
    /**
     * @param Request $dto
     * 
     * @return IpAddress
     */
    public function getIpAddresses(IpAddressDtoFilters $dto);

    /**
     * @param IpAddressDto $dto
     * 
     * @return IpAddress
     */
    public function insertIpWithLabel(IpAddressDto $dto): ?IpAddress;

    /**
     * @param IpAddressDto $dto
     * @param IpAddress $ipAddress
     * @param Label $label
     * 
     * @return IpAddress
     */
    public function updateIpOrLabel(IpAddressDto $dto, IpAddress $ipAddress, IpAddressLabel $label): ?IpAddress;
}
