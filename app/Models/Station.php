<?php

namespace App\Models;

use Database\Factories\StationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Station extends Model implements Sortable
{
    use HasFactory;
    use SortableTrait;

    protected $guarded = [];

    public $sortable = [
        'order_column_name' => 'pp',
        'sort_when_creating' => true,
    ];

    public function channels()
    {
        return $this->hasMany(Channel::class);
    }

    public function mainChannel()
    {
        return $this->hasOne(Channel::class)->where('is_main', true);
    }
}
