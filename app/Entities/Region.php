<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $guarded = [];

    public function communes()
    {
        return $this->hasMany('\App\Entities\Commune');
    }
}
