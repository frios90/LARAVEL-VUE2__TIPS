<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Management extends Model
{
    protected $guarded = [];
    use SoftDeletes;

    public function code()
    {
        return $this->belongsTo('\App\Models\Code');
    }

    public function commune()
    {
        return $this->belongsTo('\App\Models\Commune');
    }

    public function rates()
    {
        return $this->hasMany('\App\Models\Rate');
    }
}
