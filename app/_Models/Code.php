<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Code extends Model
{
    protected $guarded = [];
    use SoftDeletes;

    public function type()
    {
        return $this->belongsTo('\App\Models\Type');
    }

    public function managements()
    {
        return $this->hasMany('\App\Models\Management');
    }
}
