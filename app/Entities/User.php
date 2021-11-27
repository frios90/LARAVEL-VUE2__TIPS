<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Model
{
    protected $guarded = [];
    use SoftDeletes;

    public function company()
    {
        return $this->belongsTo('\App\Entities\Company');
    }
}
