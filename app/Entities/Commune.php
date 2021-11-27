<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    protected $guarded = [];

    public function region()
    {
        return $this->belongsTo('\App\Entities\Region');
    }
}
