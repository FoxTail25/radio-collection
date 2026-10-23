<?php

namespace App\Models;

use Database\Factories\StationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    /** @use HasFactory<StationFactory> */
    use HasFactory;

    public function channels()
    {
        return $this->hasMany(Channel::class);
    }

    // Вспомогательный метод для быстрого получения главного канала
    public function mainChannel()
    {
        return $this->hasOne(Channel::class)->where('is_main', true);
    }
}
