<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpAddress extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function labels()
    {
        return $this->hasMany(IpAddressLabel::class);
    }
}
