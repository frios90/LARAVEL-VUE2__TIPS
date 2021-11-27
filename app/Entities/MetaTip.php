<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class MetaTip extends Model
{
    protected $guarded = [];
    protected $casts = [
        'meta_data_head' => 'array',
        'meta_list_staffs_in_work' => 'array',
        'meta_list_days' => 'array',
        'meta_percentage' => 'array'
    ];
}
