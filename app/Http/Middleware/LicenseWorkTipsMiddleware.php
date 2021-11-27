<?php

namespace App\Http\Middleware;

use Closure;
use App\Entities\License;
use App\Entities\Company;
use App\Entities\TipWork;
use App\Entities\User;
use App\Entities\Staff;
use Auth;
class LicenseWorkTipsMiddleware
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
        $user    = Auth::user();
        $company = Company::with(['license'])->find($user->company_id);
        $license = $company->license;
        $tip_works_actives = TipWork::withTrashed()
                                    ->where('company_id', '=',  Auth::user()->company_id)
                                    ->whereBetween('created_at', [$this->firstMonthDay() . " 00:00:00", $this->lastMonthDay() . " 23:59:59"])
                                    ->count();        
        if ($tip_works_actives < $license->qty_work_month) {
            return $next($request);
        } else {
            return redirect()->route('home');
        }   
    }
    private function lastMonthDay() { 
        $month = date('m');
        $year  = date('Y');
        $day   = date("d", mktime(0,0,0, $month+1, 0, $year));   
        return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
    }
   
    private function firstMonthDay() {
        $month = date('m');
        $year  = date('Y');
        return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
    }
}
