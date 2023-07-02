<?php

namespace App\Repositories\IpAddress;

use App\Models\IpAddress;
use App\Repositories\IpAddress\Dto\IpAddressDto;

interface IpAddressRepositoryInterface
{
    /**
     * @param IpAddressDto $dto
     * 
     * @return IpAddress
     */
    public function insertIpWithLabel(IpAddressDto $dto): ?IpAddress;
}
