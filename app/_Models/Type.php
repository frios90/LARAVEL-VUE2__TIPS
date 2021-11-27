<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $guarded = [];
   
    public function codes()
    {
        return $this->hasMany('\App\Models\Code');
    }
}
