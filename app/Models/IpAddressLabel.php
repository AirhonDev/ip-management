<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpAddressLabel extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function ipAddress()
    {
        return $this->belongsTo(IpAddress::class);
    }

    public function user()
    {
        return $this->belongsTo(IpAddress::class);
    }
}
