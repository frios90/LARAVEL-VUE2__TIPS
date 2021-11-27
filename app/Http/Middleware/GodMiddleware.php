<?php

namespace App\Http\Middleware;

use Closure;
use App\Entities\Company;
use App\Entities\Profile;
use Auth;
class GodMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {      
        if ( Company::where('id', '=', Auth::user()->company_id)->first()->name == 'Fejhu Desarrollos' &&
            Profile::where('id', '=', Auth::user()->profile_id)->first()->label == 'SUPER_ADMIN' ) {
            return $next($request);
        } else {    
            return redirect()->route('home');
        }
    }
}
