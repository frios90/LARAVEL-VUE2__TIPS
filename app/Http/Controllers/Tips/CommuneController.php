<?php

namespace App\Http\Controllers\Tips;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Commune;

class CommuneController extends Controller
{
    public function getList (Request $request) 
{
        return response(Commune::where('region_id', '=', $request->input('region'))->get(), 200);
    }
}
