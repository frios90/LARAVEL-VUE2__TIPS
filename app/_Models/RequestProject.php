<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestProject extends Model
{
    protected $guarded = [];

    public function requestProjects()
    {
        return $this->belongsTo('\App\Models\Request');
    }
}
