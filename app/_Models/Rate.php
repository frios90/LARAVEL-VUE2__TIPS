<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $guarded = [];

    public function requests()
    {
        return $this->belongsToMany('\App\Models\Request')->withPivot('qty','value');
    }
    public function management()
    {
        return $this->belongsTo('\App\Models\Management');
    }
}
