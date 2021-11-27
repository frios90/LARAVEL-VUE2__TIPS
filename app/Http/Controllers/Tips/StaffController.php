<?php

namespace App\Http\Controllers\Tips;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Staff;
use App\Entities\StaffType;
use App\Rules\validateRut;
use Auth;

class StaffController extends Controller
{    
    public function index()
    {
        return view('master');
    } 
    public function getTableList ()
    {       
        $list = Staff::where('company_id', '=',  Auth::user()->company_id)
                    ->withTrashed()
                    ->orderBy('rut', 'ASC')
                    ->get();
        return response($list, 200);
    }
    public function getList ()
    {
        $list = Staff::where('company_id', '=',  Auth::user()->company_id)                        
                        ->orderBy('rut', 'ASC')
                        ->get();
        return response($list, 200);
    }
    public function getListWithTrashed ()
    {
        $list = Staff::withtrashed()
                    ->where('company_id', '=',  Auth::user()->company_id)                        
                    ->orderBy('rut', 'ASC')
                    ->get();
        return response($list, 200);
    }

    public function getStaffPercentages ()
    {
        $list = StaffType::where('company_id', '=', Auth::user()->company_id)->get();
        return response($list, 200);
    }   
    public function store(Request $request)
    {

        $request->validate([
            'rut'        => ['required','unique:users', 'max:12', new validateRut],
            'name'       => ['required'],
            'phone'      => ['required', 'numeric', 'max:999999999'],
            'email'      => ['required', 'unique:users', 'email'],
            'region_id'  => ['required'],
            'commune_id' => ['required'],
            'address'    => ['required'],
            'country'    => ['required']
           
        ]);
        $data_staff['rut']        = $request->input('rut');
        $data_staff['name']       = $request->input('name');
        $data_staff['address']    = $request->input('address'); 
        $data_staff['phone']      = $request->input('phone');
        $data_staff['email']      = $request->input('email');
        $data_staff['country']    = $request->input('country');
        $data_staff['commune_id'] = $request->input('commune_id');
        $data_staff['company_id'] = Auth::user()->company_id;
        $staff = Staff::firstOrCreate($data_staff);
        return $staff;    
    }   
    public function update(Request $request)
    {       
        $id = $request->input('id');
        $request->validate([
            'name'       => ['required'],
            'phone'      => ['required', 'numeric', 'max:999999999'],
            'email'      => ['required', 'email', 'unique:users,email,'.$id],
            'region_id'  => ['required'],
            'commune_id' => ['required'],
            'address'    => ['required'],
            'country'    => ['required'],
        ]);
        $staff = Staff::find($id);

        $staff->name       = $request->input('name');
        $staff->address    = $request->input('address'); 
        $staff->phone      = $request->input('phone');
        $staff->email      = $request->input('email');
        $staff->country    = $request->input('country');
        $staff->commune_id = $request->input('commune_id');
        $staff->save();
        return $staff;    
    }
    public function getStaff (Request $request)
    {        
        return response(Staff::with('commune.region')->find($request->input('id')), 200);
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
