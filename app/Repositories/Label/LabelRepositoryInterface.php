<?php

namespace App\Repositories\Label;

use App\Models\IpAddress;
use App\Repositories\Label\Dto\LabelDto;
use App\Repositories\Label\Dto\LabelFiltersDto;

interface LabelRepositoryInterface
{
    /**
     * @param LabelFiltersDto $dto
     */
    public function fetchWithPagination(LabelFiltersDto $dto);

    /**
     * @param $dto
     */
    public function create(LabelDto $dto, IpAddress $ipAddress);
}
