<?php

namespace App\Http\Controllers\Tips;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Entities\Working;
use App\Entities\StaffTip;
use App\Entities\TipWork;
use App\Entities\StaffType;
use App\Entities\MetaTip;

class TipController extends Controller
{
    public function index()
    {
        return view('master');
    }

    public function getTableList ()
    {
        $list = TipWork::with('working')
                    ->where('company_id', '=', Auth::user()->company_id)
                    ->orderBy('created_at', 'DESC')
                    ->get();
        return response($list, 200);
    }
    public function getTipWork (Request $request)
    {
        return response(MetaTip::where('tip_work_id', '=', $request->input('id'))->first(), 200);
    }
    public function store(Request $request)
    {
        $user = Auth::user();
        $data_head           = $request->input('data_head');
        $list_staffs_in_work = $request->input('list_staffs_in_work');
        $list_days           = $request->input('list_days');
        $percentages         = $request->input('percentages');
        $tip_work = TipWork::create(
            [
            'description'   => $data_head['description'],
            'amount_cash'   => $data_head['amounts']['cash'],
            'amount_debit'  => $data_head['amounts']['debit'],
            'amount_credit' => $data_head['amounts']['credit'],
            'total_amount'  => $data_head['amounts']['total'],           
            'user_id'       => $user->id,
            'working_id'    => Working::where('name', '=', $data_head['jornada'])->first()->id,
            'company_id'    => Auth::user()->company_id
        ]);
        foreach ($list_days as $row) {
            $this->insertStaffTipForList($tip_work, $row['staffs']['list_garzones'], 'GARZON', $row['day']);
            $this->insertStaffTipForList($tip_work, $row['staffs']['list_runners'], 'RUNNER', $row['day']);
            $this->insertStaffTipForList($tip_work, $row['staffs']['list_cheffs'], 'COCINA', $row['day']);
            $this->insertStaffTipForList($tip_work, $row['staffs']['list_bartenders'], 'BARRA', $row['day']);
            $this->insertStaffTipForList($tip_work, $row['staffs']['list_coppers'], 'COPERIA', $row['day']);
        }
        $meta_data = MetaTip::create(
            [
                'tip_work_id'              => $tip_work->id,
                'meta_data_head'           => $data_head,
                'meta_list_staffs_in_work' => $list_staffs_in_work,
                'meta_list_days'           => $list_days,
                'meta_percentage'          => $percentages,
                'company_id'               => Auth::user()->company_id
            ]
        );
        return response(['tip_work_id' => $tip_work->id, 'message' => 'Trabajo de propinas guardado con éxito'], 200);
    }
    public function update(Request $request)
    {
        $user                = Auth::user();
        $id                  = $request->input('id');
        $data_head           = $request->input('data_head');
        $list_staffs_in_work = $request->input('list_staffs_in_work');
        $list_days           = $request->input('list_days');
        $percentages         = $request->input('percentages');

        $tip_work = TipWork::find($id);
        $tip_work->description   = $data_head['description'];
        $tip_work->amount_cash   = $data_head['amounts']['cash'];
        $tip_work->amount_debit  = $data_head['amounts']['debit'];
        $tip_work->amount_credit = $data_head['amounts']['credit'];
        $tip_work->total_amount  = $data_head['amounts']['total'];

        $tip_work->working_id    = Working::where('name', '=', $data_head['jornada'])->first()->id;
        $tip_work->save();
        StaffTip::where('tip_work_id', '=', $id)
                ->where('user_id', '=', $user->id)
                ->delete();
        foreach ($list_days as $row) {
            $this->insertStaffTipForList($tip_work, $row['staffs']['list_garzones'], 'GARZON', $row['day']);
            $this->insertStaffTipForList($tip_work, $row['staffs']['list_runners'], 'RUNNER', $row['day']);
            $this->insertStaffTipForList($tip_work, $row['staffs']['list_cheffs'], 'COCINA', $row['day']);
            $this->insertStaffTipForList($tip_work, $row['staffs']['list_bartenders'], 'BARRA', $row['day']);
            $this->insertStaffTipForList($tip_work, $row['staffs']['list_coppers'], 'COPERIA', $row['day']);
        }
        MetaTip::where('tip_work_id', '=', $id)           
              ->delete();
        /**AÑADIR EMPRESA A LA TABLA PARA RELACIONARLA DIRECTAMENTE CON ESTA */
        $meta_data = MetaTip::create(
            [
                'tip_work_id'              => $tip_work->id,
                'meta_data_head'           => json_encode($data_head),
                'meta_list_staffs_in_work' => json_encode($list_staffs_in_work),
                'meta_list_days'           => json_encode($list_days),
                'meta_percentage'          => json_encode($percentages)
            ]
        );
        return response(['tip_work_id' => $tip_work->id, 'message' => 'Trabajo de propinas guardado con éxito'], 200);
    }
    private function insertStaffTipForList ($tip_work, $list, $_case, $day) 
    {
        $user = Auth::user();
        $type_staff_id = StaffType::where('name', '=', $_case)->first()->id;       
        foreach ($list as $row) {
            StaffTip::create(
                [
                'amount'        => $row['total_tips'],
                'staff_id'      => $row['id'],
                'staff_type_id' => $type_staff_id,
                'tip_work_id'   => $tip_work->id,
                'user_id'       => $user->id,  
            ]);      
        }
    }
}
