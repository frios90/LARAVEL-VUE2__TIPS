<?php

namespace App\Http\Controllers\Tips;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Region;

class RegionController extends Controller
{
    public function getList (Request $request) 
    {
        return response(Region::All(), 200);
    }
}
