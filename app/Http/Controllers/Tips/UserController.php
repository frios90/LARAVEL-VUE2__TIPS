<?php

namespace App\Http\Controllers\Tips;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rules\validateRut;
use App\Entities\User;
use App\Entities\Profile;
use App\Entities\Company;
use App\Mail\NewUserMail;
use Illuminate\Support\Facades\Mail;
use Auth;

class UserController extends Controller
{
    public function singIn(Request $request)
    {
        $user = $this->validate(request() , [
            'rut' => ['required', 'max:12', new validateRut],
            'email' => 'email|required',
            'password' => 'required'
        ]);
        
       
        if ( Auth::attempt(['email' => 'email|required',
        'password' => 'required'])) {

            $valdiate_company = User::with(['company'])->where('email', "=", $user['email'])->first();
            if ( $valdiate_company->company->rut == $user['rut'] ) {
                return redirect()->route('home');
            } else {
                return back()
                ->withErrors(['email'=>'No podemos encontrar ningún usuario con ese correo electrónico.'])
                ->withInput([$request->input('email')]); 
            }

        }
        return back()
            ->withErrors(['email'=>'Acceso denegado.'])
            ->withInput([$request->input('email')]);
    }

    public function logOut() {
        Auth::logout();
        return response('log-out', 200);
    }
  
    public function validateGodMenu() 
    {        
        $company = Company::where('id', '=', Auth::user()->company_id)->first()->name == 'Fejhu Desarrollos' ? true : false;;
        $profile = Profile::where('id', '=', Auth::user()->profile_id)->first()->label == 'SUPER_ADMIN' ? true : false;
        if ( $company ==  true && $profile ==  true ) {
            return response('true', 200);
        } else {    
            return response('false', 200);
        }        
    } 

    public function getUsersCompany(Request $request)
    {
        $list = User::withTrashed()
                    ->where("company_id", "=", (int)$request->input('company_id'))
                    ->orderBy('rut', 'ASC')
                    ->get();
        return response($list, 200);
    }

    public function getUserCompany(Request $request)
    {
        $list = User::where("company_id", "=", $request->input('company_id'))                    
                            ->where('id','=', $request->input('user_id'))
                            ->first();
        return response($list, 200);
    } 

    public function getUser(Request $request)
    {
        $list = User::where('id','=', $request->input('user_id'))
                            ->first();
        return response($list, 200);
    } 

    public function getUserMe(Request $request)
    {
        $user = User::where("company_id", "=", Auth::user()->company_id)                    
                    ->find(Auth::user()->id);
        return response($user, 200);
    }  


    public function store(Request $request)
    {        
        $request->validate([
            'rut'        => ['required','unique:users', 'max:12', new validateRut],
            'name'       => ['required'],
            'phone'      => ['required', 'numeric', 'max:99999999999'],
            'email'      => ['required', 'unique:users', 'email'],
            'address'    => ['required'],            
            'company_id' => ['required']
        ]);        
        $data_user['rut']        = $request->input('rut');
        $data_user['name']       = $request->input('name');
        $data_user['address']    = $request->input('address'); 
        $data_user['phone']      = $request->input('phone');
        $data_user['email']      = $request->input('email');
        $data_user['profile_id'] = $request->input('profile_id');
        $data_user['company_id'] = $request->input('company_id');
        $data_user['password']   = bcrypt( substr($data_user['rut'], 7, 3) . substr($data_user['rut'], 7, 3));

    
            
        $user = user::firstOrCreate($data_user);

        $company = Company::with('license')->find((int)$request->input('company_id'));
        $data_user['password']               = substr($data_user['rut'], 7, 3) . substr($data_user['rut'], 7, 3);
        $data_user['company_name']           = $company->name;
        $data_user['company_rut']            = $company->rut;
        $data_user['company_address']        = $company->address;
        $data_user['company_license']        = $company->license->name;
        $data_user['company_qty_staff']      = $company->license->qty_staff;    
        $data_user['company_qty_user']       = $company->license->qty_user;    
        $data_user['company_qty_work_month'] = $company->license->qty_work_month;    
        $data_user['company_value']          = $company->license->value;    

        Mail::to($data_user['email'])->send(new NewUserMail($data_user));

        return $user;    
    }
    
    public function update(Request $request)
    {   
        $id = $request->input('id');
        $request->validate([
            'rut'        => ['required', 'unique:users,rut,'.$id, new validateRut],
            'name'       => ['required'],
            'phone'      => ['required', 'numeric', 'max:999999999'],
            'email'      => ['required', 'email', 'unique:users,email,'.$id],
            'profile_id' => ['required'],
            'address'    => ['required'],
        ]);
        $user = User::find($id);
        $user->rut        = $request->input('rut');
        $user->name       = $request->input('name');
        $user->address    = $request->input('address'); 
        $user->phone      = $request->input('phone');
        $user->email      = $request->input('email');
        $user->profile_id = $request->input('profile_id');

        $user->save();
        return $user;    
    }

    public function updateMe(Request $request)
    {   
        $id = $request->input('id');
        $request->validate([
            'name'       => ['required'],
            'phone'      => ['required', 'numeric', 'max:999999999'],
            'email'      => ['required', 'email', 'unique:users,email,'.$id],
            'address'    => ['required'],
        ]);
        $user = User::find($id);
        $user->name       = $request->input('name');
        $user->address    = $request->input('address'); 
        $user->phone      = $request->input('phone');
        $user->email      = $request->input('email');
        $user->save();
        return $user;    
    }

    public function updateMePass(Request $request)
    {   
        $id = $request->input('id');
        $request->validate([
            'current_pass'       => ['required'],
            'new_pass'           => ['required'],
            'confirm_pass'       => ['required'],
        ]);

        $user = User::find($id);
        $errors['errors'] = [];
        $attemp = [
            'email'=> $user->email,
            'password' => $request->input('current_pass')
        ];
        if ( Auth::attempt( $attemp  ) ){           
            
        }else {
            $errors['errors']['current_pass']   = ['Contraseña actual no es valida'];
        }

        if ($request->input('new_pass') != $request->input('confirm_pass')) {
            $errors['errors']['confirm_pass']   = ['No coincide con nueva contraseña'];
        }

       
                    /**AÑADIR MAS SEGURIDAD */


        if ( count($errors['errors']) == 0 ) {        
            $user->password = bcrypt($request->input('new_pass'));            
            $user->save();
            Auth::logout();
            return response('log-out', 200);
        }    
        return response($errors, 200); 

    }

    public function status (Request $request)
    {
        $id = $request->input('id');
        $user = User::where('id', '=', $request->input('id'))->withTrashed()->first();        
        if ($user->deleted_at) {
            $user->restore();
        } else {
            $user->delete();
        }
        return response($user, 200);
    }

    public function resetPass(Request $request)
    {   
        $id             = $request->input('id');
        $user           = User::find($id);
        $user->password = bcrypt('secret');            
        $user->save();
        Auth::logout();
        return response($user, 200);
    }
}
