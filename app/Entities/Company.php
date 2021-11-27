<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    protected $table = "companies";
    protected $guarded = [];
    use SoftDeletes;
    
    public function commune()
    {
        return $this->belongsTo('\App\Entities\Commune');
    }
    public function license()
    {
        return $this->belongsTo('\App\Entities\License');
    }
}
