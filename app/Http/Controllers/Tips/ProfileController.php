<?php

namespace App\Http\Controllers\Tips;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Profile;

class ProfileController extends Controller
{
    public function getList ()
    {
        $list = Profile::All();
        return response($list, 200);
    }
}
