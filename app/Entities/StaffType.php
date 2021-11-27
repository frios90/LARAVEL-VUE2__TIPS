<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffType extends Model
{
    protected $guarded = [];
    use SoftDeletes;

}
