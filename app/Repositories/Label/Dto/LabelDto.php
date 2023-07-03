<?php

namespace App\Repositories\Label\Dto;

use App\Models\User;
use App\Repositories\AbstractFilterDto;

class LabelDto
{
    /**
     * @var string Label associated with the IP.
     */
    public string $label;

    /**
     * @var User user.
     */
    public User $user;
}
