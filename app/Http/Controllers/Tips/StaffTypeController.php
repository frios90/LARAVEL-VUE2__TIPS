<?php

namespace App\Http\Controllers\Tips;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Staff;
use App\Entities\StaffType;
use Auth;
class StaffTypeController extends Controller
{
    public function percentageUpdate (Request $request)
    {    

        $this->updatePercentage('GARZON' , 'Garzón', $request->input('garzon'));
        $this->updatePercentage('RUNNER' , 'Runner', $request->input('runner')); 
        $this->updatePercentage('COCINA' , 'Cocina', $request->input('cheff')); 
        $this->updatePercentage('BARRA'  , 'Barra', $request->input('bartender')); 
        $this->updatePercentage('COPERIA', 'Coperia', $request->input('copper')); 
        return response($request->all(), 200);
    }

    private function updatePercentage ($name, $label, $percentage) 
    {        
        $staff = StaffType::where('name', '=', $name)
                            ->where('company_id', '=', Auth::user()->company_id)
                            ->first();
        if (isset($staff->id)) {
            $staff->percentage = $percentage;
            $staff->save();
        } else {
            StaffType::create(
                [
                    'name' => $name,
                    'label' => $label,
                    'percentage' => $percentage,
                    'company_id' => Auth::user()->company_id 
                ]
                );
        }                  
        
        return $staff;
    }
}
