<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipWork extends Model
{
    protected $guarded = [];
    use SoftDeletes;

    public function working()
    {
        return $this->belongsTo('\App\Entities\Working');
    }
}
