<?php

namespace App\Http\Middleware;

use Closure;
use App\Entities\License;
use App\Entities\Company;
use App\Entities\TipWork;
use App\Entities\User;
use App\Entities\Staff;
use Auth;
class LicenseUserMiddleware
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
        $user         = Auth::user();
        $company      = Company::with(['license'])->find($user->company_id);    
        $license      = $company->license;
        $user_actives = User::where('company_id', '=',  Auth::user()->company_id)->count();
        if ($user_actives < $license->qty_user) {
            return $next($request);
        } else {
            return redirect()->route('comapany.users');
        }
    }
}
