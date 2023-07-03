<?php

namespace App\Repositories\IpAddress\Dto;

use App\Models\User;

class IpAddressDto
{
    /**
     * @var string IP address.
     */
    public string $ip;

    /**
     * @var string Label associated with the IP.
     */
    public string $label;

    /**
     * @var User who created the IP.
     */
    public User $user;
}
