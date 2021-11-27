<?php

namespace App\Http\Controllers\Tips;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\License;
use App\Entities\Company;
use App\Entities\TipWork;
use App\Entities\User;
use App\Entities\Staff;
use Auth;
class LicenseController extends Controller
{
    public function index()
    {
        return view('master');
    }
    public function getList (Request $request) 
    {
        return response(License::All(), 200);
    }
    public function getLicense (Request $request)
    {        
        return response(License::find($request->input('id')), 200);
    }  
    public function getLicenseAllowed () 
    {
        $user = Auth::user();
        $company = Company::with(['license'])->find($user->company_id);
        $license = $company->license;
        $user_actives      = User::where('company_id',  '=',  Auth::user()->company_id)->count();
        $staff_actives     = Staff::where('company_id', '=',  Auth::user()->company_id)->count();
        $tip_works_actives = TipWork::withTrashed()
                                    ->where('company_id', '=',  Auth::user()->company_id)
                                    ->whereBetween('created_at', [$this->firstMonthDay() . " 00:00:00", $this->lastMonthDay() . " 23:59:59"])
                                    ->count();
        $allow = [
            'user_allow' => ['status' => true],
            'staff_allow' => ['status' => true],
            'tip_work_allow' => ['status' => true],            
        ];
        
        if ($license) {
            if ($user_actives >= $license->qty_user) {
                $allow['user_allow'] = ['qty' =>  $user_actives, 'status' => false];
            }
            if ($staff_actives >= $license->qty_staff) {
                $allow['staff_allow'] = ['qty' => $staff_actives, 'status' => false];
            }
    
            if ($tip_works_actives >= $license->qty_work_month) {
                $allow['tip_work_allow'] = ['qty' => $tip_works_actives, 'status' => false];
            }
        } 
       
        return response($allow, 200);
    }
    private function lastMonthDay() { 
        $month = date('m');
        $year = date('Y');
        $day = date("d", mktime(0,0,0, $month+1, 0, $year));   
        return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
    }   
    private function firstMonthDay() {
        $month = date('m');
        $year = date('Y');
        return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
    }
    public function getTableList ()
    {       
        $list = License::all();
        return response($list, 200);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'           => ['required'],            
            'code'           => ['required'],
            'qty_user'       => ['required'],
            'qty_staff'      => ['required'],
            'qty_work_month' => ['required'],
            'value'          => ['required']
        ]);
        $data_license['name']           = $request->input('name');
        $data_license['code']           = $request->input('code');
        $data_license['qty_user']       = $request->input('qty_user'); 
        $data_license['qty_staff']      = $request->input('qty_staff');
        $data_license['qty_work_month'] = $request->input('qty_work_month');
        $data_license['value']          = $request->input('value');
       
        $license = License::firstOrCreate($data_license);
        return $license;    
    }
    public function update(Request $request)
    {       
        $id = $request->input('id');
        $request->validate([
            'name'           => ['required'],            
            'code'           => ['required'],
            'qty_user'       => ['required'],
            'qty_staff'      => ['required'],
            'qty_work_month' => ['required'],
            'value'          => ['required']
        ]);
        $license = License::find($id);
        $license->name           = $request->input('name');
        $license->code           = $request->input('code'); 
        $license->qty_user       = $request->input('qty_user');
        $license->qty_staff      = $request->input('qty_staff');
        $license->qty_work_month = $request->input('qty_work_month');
        $license->value          = $request->input('value');
        $license->save();
        return $license;    
    }
    public function status (Request $request)
    {
        $id = $request->input('id');
        $user = Staff::where('id', '=', $request->input('id'))->withTrashed()->first();        
        if ($user->deleted_at) {
            $user->restore();
        } else {
            $user->delete();
        }
        return response($user, 200);
    }
}
