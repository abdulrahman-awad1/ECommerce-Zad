<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded = ['id'];

    public function room() : BelongsTo
    {
        return $this->belongsTo(Room::class);
    }


}
