<?php

namespace App\Repositories\Label;

use App\Models\IpAddress;
use App\Models\IpAddressLabel;
use App\Repositories\Label\Dto\LabelDto;
use App\Repositories\Label\Dto\LabelFiltersDto;

class LabelRepository implements LabelRepositoryInterface
{
    public function fetchWithPagination(LabelFiltersDto $dto)
    {
        return IpAddressLabel::paginate($dto->per_page);
    }

    public function create(LabelDto $dto, IpAddress $ipAddress)
    {
        return $ipAddress->labels()->create([
            'label' => $dto->label,
            'user_id' => $dto->user->id
        ]);
    }
}
