<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    protected $table = "staffs";
    protected $guarded = [];
    use SoftDeletes;

    public function commune()
    {
        return $this->belongsTo('\App\Entities\Commune');
    }
}
