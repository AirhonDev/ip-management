<?php

namespace App\Services;

use App\Models\IpAddress;
use App\Repositories\Label\Dto\LabelDto;
use App\Repositories\Label\Dto\LabelFiltersDto;
use App\Repositories\Label\LabelRepositoryInterface;
use Illuminate\Http\Request;

class IpAddressLabelService
{
    protected $labelRepository;

    public function __construct(LabelRepositoryInterface $labelRepository)
    {
        $this->labelRepository = $labelRepository;
    }


    public function fetchWithPagination(Request $request)
    {
        $dto = new LabelFiltersDto;

        $dto->per_page = $request->per_page;

        return $this->labelRepository->fetchWithPagination($dto);
    }

    public function create(Request $request, IpAddress $ipAddress)
    {
        $dto = new LabelDto;

        $dto->label = $request->label;
        $dto->user = auth()->user();

        return $this->labelRepository->create($dto, $ipAddress);
    }
}
