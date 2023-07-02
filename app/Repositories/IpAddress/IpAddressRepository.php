<?php

namespace App\Repositories\IpAddress;

use App\Models\IpAddress;
use App\Repositories\IpAddress\Dto\IpAddressDto;

class IpAddressRepository implements IpAddressRepositoryInterface
{
    public function insertIpWithLabel(IpAddressDto $dto): ?IpAddress
    {
        $ipAddress = IpAddress::create([
            'ip_address' => $dto->ip,
        ]);

        $ipAddress->labels()->create([
            'user_id' => $dto->user->id,
            'label' => $dto->label,
        ]);

        return $ipAddress;
    }
}
