<?php

namespace App\Models;

use Database\Factories\ChannelFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /** @use HasFactory<ChannelFactory> */
    use HasFactory;

    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}
