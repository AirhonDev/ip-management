<?php

namespace App\Repositories\IpAddress;

use App\Models\IpAddress;
use App\Models\IpAddressLabel;
use App\Repositories\IpAddress\Dto\IpAddressDto;
use App\Repositories\IpAddress\Dto\IpAddressDtoFilters;

class IpAddressRepository implements IpAddressRepositoryInterface
{
    public function create(IpAddressDto $dto): ?IpAddress
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

    public function fetchWithPagination(IpAddressDtoFilters $dto)
    {
        return IpAddress::paginate($dto->per_page);
    }

    public function updateIpOrLabel(IpAddressDto $dto, IpAddress $ipAddress, IpAddressLabel $label): ?IpAddress
    {
        $ipAddress->update([
            'ip_address' => $dto->ip,
        ]);

        if (!empty($label)) {
            $label->update([
                'label' => $dto->label,
            ]);
        }

        return $ipAddress;
    }
}
