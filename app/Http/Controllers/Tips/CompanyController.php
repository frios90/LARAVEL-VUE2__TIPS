<?php

namespace App\Http\Controllers\Tips;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Company;
use App\Entities\StaffType;
use App\Entities\User as USER_MODEL;
use App\Rules\validateRut;

use Auth;

class CompanyController extends Controller
{
    public function index()
    {
        return view('master');
    }
 
    public function getTableList ()
    {
        $list = Company::with(['license'])
                    ->withTrashed()
                    ->orderBy('rut', 'ASC')
                    ->get();
        return response($list, 200);
    }

    public function getList ()
    {
        $list = Company::with(['license'])->get();
        return response($list, 200);
    }     

    /**
     * almacenar nuevo staff
     */
    public function store(Request $request)
    {        
        $request->validate([
            'rut'        => ['required','unique:companies', 'max:12', new validateRut],
            'name'       => ['required'],
            'legal_name' => ['required'],
            'since'      => ['required'],
            'contact'    => ['required'],
            'phone'      => ['required', 'numeric', 'max:999999999'],
            'email'      => ['required', 'unique:companies', 'email'],
            'region_id'  => ['required'],
            'commune_id' => ['required'],
            'license_id' => ['required'],
            'address'    => ['required']
        ]);
        
        $data_company['rut']        = $request->input('rut');
        $data_company['name']       = $request->input('name');
        $data_company['address']    = $request->input('address'); 
        $data_company['phone']      = $request->input('phone');
        $data_company['email']      = $request->input('email');
        $data_company['legal_name'] = $request->input('legal_name');
        $data_company['commune_id'] = $request->input('commune_id');
        $data_company['since']      = $request->input('since');
        $data_company['contact']    = $request->input('contact');
        $data_company['license_id'] = $request->input('license_id');
        $company = Company::firstOrCreate($data_company);
        return $company;    
    }
  
    public function update(Request $request)
    {  
        $id = $request->input('id');
        $request->validate([
            'rut'        => ['required', 'unique:companies,rut,'.$id, new validateRut],
            'name'       => ['required'],
            'legal_name' => ['required'],
            'since'      => ['required'],
            'contact'    => ['required'],
            'phone'      => ['required', 'numeric', 'max:999999999'],
            'email'      => ['required', 'email', 'unique:companies,email,'.$id],
            'region_id'  => ['required'],
            'commune_id' => ['required'],
            'license_id' => ['required'],
            'address'    => ['required'],
        ]);
        $company = Company::find($id);
        $company->name       = $request->input('name');
        $company->address    = $request->input('address'); 
        $company->phone      = $request->input('phone');
        $company->email      = $request->input('email');
        $company->commune_id = $request->input('commune_id');
        $company->legal_name = $request->input('legal_name');
        $company->since      = $request->input('since');
        $company->contact    = $request->input('contact');
        $company->license_id = $request->input('license_id');
        $company->save();
        return $company;    
    }

    public function getCompany (Request $request)
    {        
        return response(Company::with(['commune.region', 'license'])->find($request->input('id')), 200);
    }

    public function status (Request $request)
    {
        $id = $request->input('id');
        $company = Company::where('id', '=', $request->input('id'))->withTrashed()->first();        
        if ($company->deleted_at) {
            $company->restore();
        } else {
            $company->delete();
        }
        return response($company, 200);
    }
}
