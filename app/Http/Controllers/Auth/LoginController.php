<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Entities\User;
use Auth;
use App\Rules\validateRut;



class LoginController extends Controller
{
    public function __construct()
    {

    }
    public function index()
    {
        return view('auth.login');
    }

    public function singIn(Request $request)
    {
        $user = $this->validate(request() , [
            'rut' => ['required', 'max:12', new validateRut],
            'email' => 'email|required',
            'password' => 'required'
        ]);
        
       
        if ( Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            $valdiate_company = User::with(['company'])->where('email', "=", $request->input('email'))->first();
            if ( isset($valdiate_company->company->rut) && $valdiate_company->company->rut == $request->input('rut') ) {
                return response('true', 200);
            } else {
                return response('false', 422);
            }

        }
        return response('false', 422);

    }

    public function logOut() {
        Auth::logout();
        return response('log-out', 200);
    }
}

