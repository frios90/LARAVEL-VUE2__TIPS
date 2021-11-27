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
use App\Entities\Staff;
use App\Entities\Company;
use App\Entities\User;

class ReportsController extends Controller
{
    public function getUserChartPercentages ()
    {
        $percentages = StaffType::where('company_id', '=', Auth::user()->company_id)->get();
        $chart['data'] = [
            'labels' => $percentages->pluck('label')->toArray(),
            'datasets' => [
                [
                    'backgroundColor'=> ["#53C491", "#E8AC0C", "#6E63FB", "#B83E3E", "#C84AF1"],
                    'data'=> $percentages->pluck('percentage')->toArray(),
                    'borderWidth'=> 0

                ]
            ]
        ];

        $chart['options'] = [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'legend' => [
                'display'=>false
            ],
            'yAxes' => [
                [
                    'ticks' => [
                        'fontColor' => 'white'
                    ]
                ]
                ],
            'xAxes' => [
                [
                    'ticks' => [
                        'fontColor' => 'white'
                    ]
                ]
            ]
        ];  

        return response($chart, 200);
    }

    public function getChartLicenses ()
    {
        $user                     = Auth::user();
        $company                  = Company::with(['license'])->find($user->company_id);
        $license                  = $company->license;           
        $data['staff']['total']   = Staff::where('company_id', '=',  Auth::user()->company_id)->count();
        $data['staff']['license'] = isset($license->qty_staff) ? $license->qty_staff : 0;
        $data['user']['total']    = User::where('company_id',  '=',  Auth::user()->company_id)->count();
        $data['user']['license']  = isset($license->qty_user) ? $license->qty_user : 0;
        $data['work']['total']    = TipWork::withTrashed()
                                            ->where('company_id', '=',  Auth::user()->company_id)
                                            ->whereBetween('created_at', [$this->firstMonthDay() . " 00:00:00", $this->lastMonthDay() . " 23:59:59"])
                                            ->count();
        $data['work']['license'] =  isset($license->qty_work_month) ? $license->qty_work_month : 0; 
        $chart['data'] = [
                   'labels' => ['Usado', 'Restante'],
                    'datasets' => [
                        [
                            "label" => ['Gestiones'],
                            'backgroundColor'=> [ "#E8AC0C","#53C491",],
                            'data'=> [$data['work']['total'], ($data['work']['license']-$data['work']['total'])],
                            'borderWidth'=> 0

                        ],
                        
                        [
                            "label" => ['Staff'],
                            'backgroundColor'=> [ "#6E63FB", "#53C491",],
                            'data'=> [$data['staff']['total'],  ($data['staff']['license']-$data['staff']['total'])],
                            'borderWidth'=> 0

                        ],
                        [
                            "label" => ['Usuarios'],
                            'backgroundColor'=> [ "#C84AF1", "#53C491",],
                            'data'=> [$data['user']['total'] , ($data['user']['license']-$data['user']['total'])],
                            'borderWidth'=> 0

                        ],
                    ]
                ];

        $chart['options'] = [
                        'responsive' => true,
                        'maintainAspectRatio' => false,
                        'legend' => [
                            'display'=>false
                        ],
                        'yAxes' => [
                            [
                                'ticks' => [
                                    'fontColor' => 'white'
                                ]
                            ]
                            ],
                        'xAxes' => [
                            [
                                'ticks' => [
                                    'fontColor' => 'white'
                                ]
                            ]
                        ]
                    ];  

        return response($chart, 200);
    }

    private function lastMonthDay() 
    { 
        $month = date('m');
        $year  = date('Y');
        $day   = date("d", mktime(0,0,0, $month+1, 0, $year));   
        return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
    }
   
    private function firstMonthDay() 
    {
        $month = date('m');
        $year  = date('Y');
        return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
    }

    public function getInfoTotalReports () 
    {
        $user = Auth::user();
        $company = Company::with(['license'])->find($user->company_id);
        $license = $company->license;    
        $data['auth']['user']     = $user;
        $data['auth']['company']  = $company;
        
        $data['license']          = isset($license->name)?$license->name : 'Sin Licencia';
        $data['staff']['total']   =  Staff::where('company_id', '=',  Auth::user()->company_id)->count();
        $data['staff']['license'] =  isset($license->qty_staff)?$license->qty_staff:0;

        $data['user']['total']    = User::where('company_id',  '=',  Auth::user()->company_id)->count();
        $data['user']['license']  =  isset($license->qty_user)?$license->qty_user:0;

        $data['work']['total']    = TipWork::withTrashed()
                                            ->where('company_id', '=',  Auth::user()->company_id)
                                            ->whereBetween('created_at', [$this->firstMonthDay() . " 00:00:00", $this->lastMonthDay() . " 23:59:59"])
                                            ->count();
        $data['work']['license']  = isset($license->qty_work_month)?$license->qty_work_month:0;                                    
        $data['work']['morning']  = count($this->getWork('morning'));     
        $data['work']['noon']     = count($this->getWork('noon'));
        $data['work']['night']    = count($this->getWork('night'));
        $data['totals']           = $this->calculateTotalMonth();
        return $data;
    }

    private function calculateTotalMonth () {
        $data['total_historic']  = TipWork::with(['working'])->where('company_id', '=', Auth::user()->company_id)->sum('total_amount');
        $tips  = TipWork::with(['working'])->where('company_id', '=', Auth::user()->company_id)
                        ->whereBetween('created_at', [$this->firstMonthDay() . " 00:00:00", $this->lastMonthDay() . " 23:59:59"])                        
                        ->get();
        $data['morning']['cash'] = 0;
        $data['morning']['debit'] = 0;
        $data['morning']['credit'] = 0;
        $data['morning']['total'] = 0;
        $data['noon']['cash'] = 0;
        $data['noon']['debit'] = 0;
        $data['noon']['credit'] = 0;
        $data['noon']['total'] = 0;
        $data['night']['cash'] = 0;
        $data['night']['debit'] = 0;
        $data['night']['credit'] = 0;
        $data['night']['total'] = 0;
        $data['total'] = 0;       
        forEach($tips as $tip){
            $data['total'] += $tip->amount_cash + $tip->amount_debit + $tip->amount_credit;
            switch ($tip->working->name) {
                case 'morning' :
                        $data['morning']['cash']   += $tip->amount_cash;
                        $data['morning']['debit']  += $tip->amount_debit;
                        $data['morning']['credit'] += $tip->amount_credit;
                        $data['morning']['total']  +=  $tip->amount_cash + $tip->amount_debit + $tip->amount_credit;
                    break;
                case 'noon' :
                        $data['noon']['cash']   += $tip->amount_cash;
                        $data['noon']['debit']  += $tip->amount_debit;
                        $data['noon']['credit'] += $tip->amount_credit;
                        $data['noon']['total']  +=  $tip->amount_cash + $tip->amount_debit + $tip->amount_credit;

                    break;
                case 'night' :
                        $data['night']['cash']   += $tip->amount_cash;
                        $data['night']['debit']  += $tip->amount_debit;
                        $data['night']['credit'] += $tip->amount_credit;
                        $data['night']['total']  +=  $tip->amount_cash + $tip->amount_debit + $tip->amount_credit;
                    break;    
            }             
        }
        return $data;

    }

    private function getWork ($type_work) {            
        $work = TipWork::where('company_id', '=', Auth::user()->company_id)
                        ->where('working_id', '=', Working::where('name', '=', $type_work)->first()->id)
                        ->whereBetween('created_at', [$this->firstMonthDay() . " 00:00:00", $this->lastMonthDay() . " 23:59:59"])
                        ->get();
        return $work;
    }

    public function getChartTotalTips ()
    {
        $tips_morning   = $this->getWork('morning');
        $tips_noon      = $this->getWork('noon');
        $tips_night     = $this->getWork('night');
        
        $chart['count'] = TipWork::where('company_id', '=', Auth::user()->company_id)
                            ->whereBetween('created_at', [$this->firstMonthDay() . " 00:00:00", $this->lastMonthDay() . " 23:59:59"])
                            ->count();
        $chart['data'] = [
            'labels' => ['Mañana', 'Tarde', 'Noche'],
            'datasets' => [
                [
                    'label' => 'Efectivo',
                    'backgroundColor'=> ["#53C491", "#53C491", "#53C491"],
                    'data'=> [ $this->totalForWork($tips_morning)['cash'], $this->totalForWork($tips_noon)['cash'], $this->totalForWork($tips_night)['cash']],
                    'borderWidth'=> 0
                ],
                [
                    'label' => 'Débito',
                    'backgroundColor'=> ["#E8AC0C", "#E8AC0C", "#E8AC0C"],
                    'data'=> [ $this->totalForWork($tips_morning)['debit'], $this->totalForWork($tips_noon)['debit'], $this->totalForWork($tips_night)['debit']],
                    'borderWidth'=> 0
                ],
                [
                    'label' => 'Crédito',
                    'backgroundColor'=> ["#6E63FB", "#6E63FB", "#6E63FB"],
                    'data'=> [ $this->totalForWork($tips_morning)['credit'], $this->totalForWork($tips_noon)['credit'], $this->totalForWork($tips_night)['credit']],
                    'borderWidth'=> 0
                ]
            ]
        ];
        $chart['options'] = [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'legend' => [
                'fontColor '=> "white",
                'display'=>false

            ],
            'scales' => [
                'yAxes' => [
                    [
                        'display'=>false,
                        'ticks' => [
                            'fontColor' => 'white'
                        ]
                    ]
                    ],
                'xAxes' => [
                    [
                        'display'=>false,
                        'ticks' => [
                            'fontColor' => 'white'
                        ]
                    ]
                ]
            ]
        ];  
        return response($chart, 200);
    }
    /**calclo de totales por jornada */
    private function totalForWork ($tips) 
    {
        $total['cash']  = 0;
        $total['debit']  = 0;
        $total['credit'] = 0;
        forEach($tips as $tip){
            $total['cash']   += $tip->amount_cash;
            $total['debit']  += $tip->amount_debit;
            $total['credit'] += $tip->amount_credit;
        }
        $data = [$total['cash'], $total['debit'],$total['credit']];
        return $total;
    }

    public function getChartProgressWeek () 
    {
        $week = $this->dayRangeWeek();
        $chart['data'] = [
            'labels' => ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'],
            'datasets' => [
                [
                    'label' => 'Mañana',
                   
                    'backgroundColor' => "#53C491",
                    'borderColor'     => "#53C491",
                    'fill'=> 'false',
                    'data'=> [
                       $this->tipsForDay('morning', $week['lun']),
                       $this->tipsForDay('morning', $week['mar']),
                       $this->tipsForDay('morning', $week['mie']),
                       $this->tipsForDay('morning', $week['jue']),
                       $this->tipsForDay('morning', $week['vie']),
                       $this->tipsForDay('morning', $week['sab']),
                       $this->tipsForDay('morning', $week['dom']),

                    ],
                    'borderWidth'=> 0
                ],
                [
                    'label' => 'Tarde',
                    'backgroundColor' => "#E8AC0C",
                    'borderColor'     => "#E8AC0C",
                    'fill'=> 'false',
                    'data'=> [
                        $this->tipsForDay('noon', $week['lun']),
                        $this->tipsForDay('noon', $week['mar']),
                        $this->tipsForDay('noon', $week['mie']),
                        $this->tipsForDay('noon', $week['jue']),
                        $this->tipsForDay('noon', $week['vie']),
                        $this->tipsForDay('noon', $week['sab']),
                        $this->tipsForDay('noon', $week['dom']),
                    ],
                    'borderWidth'=> 0
                ],
                [
                    'label' => 'Noche',
                    'backgroundColor' => "#6E63FB",
                    'borderColor'     => "#6E63FB",
                    'fill'=> 'false',
                    'data'=> [
                        $this->tipsForDay('night', $week['lun']),
                        $this->tipsForDay('night', $week['mar']),
                        $this->tipsForDay('night', $week['mie']),
                        $this->tipsForDay('night', $week['jue']),
                        $this->tipsForDay('night', $week['vie']),
                        $this->tipsForDay('night', $week['sab']),
                        $this->tipsForDay('night', $week['dom']),
                    ],
                    'borderWidth'=> 0
                ]
            ]
        ];
        $chart['options'] = [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'legend' => [
                'display'=>false,
                'fontColor '=> "white"

            ]
        ];

        return response($chart, 200);
    }  

    private function tipsForDay ($work, $day) 
    {       
        $tips = "";
        $tips = MetaTip::where('company_id', '=', Auth::user()->company_id)
                        ->where(\DB::raw("json_extract(meta_data_head, '$.jornada')"),  $work)
                        ->get();
        $total = 0;
        foreach ($tips as $tip) {
            $this->getMetaDay($total, $tip->meta_list_days, $day);            
        }
        return $total;  
    }  
 
    private function getMetaDay (&$total, $list_day, $day_in) {
        foreach ($list_day as $day) {                        
            if ($day['day'] == $day_in) {  
                        
                $total += $day['amounts']['total'];
                
            }           
        }
        return $total;
    }

    private function getTotalDay ($work, $meta, $data) {       
        if (isset($data[$meta['day']])) {
            $total = $meta['amounts']['total'] + $data[$meta['day']]['total'];        
            return $total;
        } else {           
            return $meta['amounts']['total'];
        }
    }

    private function getTotalDay2 ($data, $day) {       
        if (isset($data[$day])) {                    
            return $data[$day]['total'];
        } else {           
            return 0;
        }
    }

    public function getGlobalChart () 
    {
        $week = $this->dayRangePreviousWeek();
        $tips = MetaTip::select('meta_list_days', 'workings.name as work')
                        ->join('tip_works', 'tip_works.id', '=', 'meta_tips.tip_work_id')
                        ->join('workings', 'workings.id', '=', 'tip_works.working_id')
                        ->where('meta_tips.company_id', '=', Auth::user()->company_id)                        
                        ->get();
        
         $data_morning = [];
         $data_noon = [];
         $data_night = [];
         
        $labels = [];
        foreach ($tips as $tip) {
            foreach ($tip->meta_list_days as $meta) {
                $labels[$meta['day']] = ['day' => $meta['day']];
             
                $data_morning[$meta['day']] = [
                    'day'   => $meta['day'],
                    'total' => $tip->work == 'morning' ? $this->getTotalDay($tip->work, $meta, $data_morning) : $this->getTotalDay2($data_morning, $meta['day']),
                    'work'  => $tip->work
                ];
        
                $data_noon[$meta['day']] = [
                    'day'   => $meta['day'],
                    'total' => $tip->work == 'noon' ? $this->getTotalDay($tip->work, $meta, $data_noon) : $this->getTotalDay2($data_noon, $meta['day']),
                    'work'  => $tip->work
                ];
            
                $data_night[$meta['day']] = [
                    'day'   => $meta['day'],
                    'total' => $tip->work == 'night' ? $this->getTotalDay($tip->work, $meta, $data_night) : $this->getTotalDay2($data_night, $meta['day']),
                    'work'  => $tip->work
                ];
                 
                
               
            }
        }   
        $labels = collect($labels)->sortBy('day');
        $labels->values()->all();
        $data_morning = collect($data_morning)->sortBy('day');
        $data_morning->values()->all();
        $data_noon = collect($data_noon)->sortBy('day');
        $data_noon->values()->all();
        $data_night = collect($data_night)->sortBy('day');
        $data_night->values()->all();
        
        $chart['data'] = [
            'labels' => $labels->pluck('day'),
            'datasets' => [
                [
                    'label' => 'Mañana',
                   
                    'backgroundColor' => "#53C491",
                    'borderColor'     => "#53C491",
                    'fill'=> 'false',
                    'data'=> $data_morning->pluck('total'),
                    'borderWidth'=> 0
                ],
                [
                    'label' => 'Tarde',
                    'backgroundColor' => "#E8AC0C",
                    'borderColor'     => "#E8AC0C",
                    'fill'=> 'false',
                    'data'=> $data_noon->pluck('total'),
                    'borderWidth'=> 0
                ],
                [
                    'label' => 'Noche',
                    'backgroundColor' => "#6E63FB",
                    'borderColor'     => "#6E63FB",
                    'fill'=> 'false',
                    'data'=> $data_night->pluck('total'),
                    'borderWidth'=> 0
                ]
            ]
        ];
        $chart['options'] = [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'legend' => [
                'display'=>false

            ],
        ];

        return response($chart, 200);
    }  
    private function dayRangePreviousWeek () 
    {
        $year  = date('Y');
        $month = date('m');
        $day   = date('d');       
       
        # Obtenemos el día de la semana de la fecha dada
        $dayWeek=date("w",mktime(0,0,0,$month,$day,$year));
    
        # el 0 equivale al domingo...
        if($dayWeek==0)
            $dayWeek=7;
       
        $data['lun'] = date("Y-m-d",mktime(0,0,0,$month,$day-$dayWeek-(7)+1,$year));
        $data['mar'] = date("Y-m-d",mktime(0,0,0,$month,$day-$dayWeek-(7)+2,$year));
        $data['mie'] = date("Y-m-d",mktime(0,0,0,$month,$day-$dayWeek-(7)+3,$year));
        $data['jue'] = date("Y-m-d",mktime(0,0,0,$month,$day-$dayWeek-(7)+4,$year));
        $data['vie'] = date("Y-m-d",mktime(0,0,0,$month,$day-$dayWeek-(7)+5,$year));
        $data['sab'] = date("Y-m-d",mktime(0,0,0,$month,$day-$dayWeek-(7)+6,$year));
        $data['dom'] = date("Y-m-d",mktime(0,0,0,$month,$day-(7)+(7-$dayWeek),$year));
        return $data;
    }



    /** PARA GRAFICO DE PROGRESO DE STAF SEMANANAL*/

    public function getChartStaffWeek (Request $request) 
    {
      
    } 

    private function tipsForStaffForDay ($work, $day, $type_staff) 
    {       
        $tips_work_pluck_id = TipWork::where('working_id', '=', Working::where('name', '=', $work)->first()->id)
                                ->where('company_id', '=', Auth::user()->company_id)
                                ->pluck('id')->toArray();
        $tips = "";
        if (env('DB_CONNECTION') == 'pgsql') {
            $tips = MetaTip::select('meta_list_days')
                    ->where('company_id', '=', Auth::user()->company_id)
                    ->whereIn('tip_work_id', $tips_work_pluck_id)
                    ->get();
        
        
        
        } else {
            // /**COMPLETAR PARA MYSQL */
            // $tips = MetaTip::where('company_id', '=', Auth::user()->company_id)
            // ->where(\DB::raw("json_extract(meta_data_head, '$.jornada')"),  $work)
            // ->get();
        }

       
        $total = 0;
        foreach ($tips as $tip) {
            $this->getMetaListDay($total, $tip->meta_list_days, $day, $type_staff);
            
        }
        return $total;  
    }

    private function getMetaListDay (&$total, $list_day, $day_in, $type_staff) {
      
        foreach ($list_day as $day) {            
            if ($day['day'] == $day_in) {  
                $total += $day['distribute'][$type_staff]['total'];
            }           
        }
      
        return $total;
    }

    private function dayRangeWeek () 
    {
        $year  = date('Y');
        $month = date('m');
        $day   = date('d');       
       
        # Obtenemos el día de la semana de la fecha dada
        $dayWeek=date("w",mktime(0,0,0,$month,$day,$year));
        
        # el 0 equivale al domingo...
        if($dayWeek==0)
            $dayWeek=7;
        
        $data['lun'] = date("Y-m-d",mktime(0,0,0,$month,$day-$dayWeek+1,$year));
        $data['mar'] = date("Y-m-d",mktime(0,0,0,$month,$day-$dayWeek+2,$year));
        $data['mie'] = date("Y-m-d",mktime(0,0,0,$month,$day-$dayWeek+3,$year));
        $data['jue'] = date("Y-m-d",mktime(0,0,0,$month,$day-$dayWeek+4,$year));
        $data['vie'] = date("Y-m-d",mktime(0,0,0,$month,$day-$dayWeek+5,$year));
        $data['sab'] = date("Y-m-d",mktime(0,0,0,$month,$day-$dayWeek+6,$year));
        $data['dom'] = date("Y-m-d",mktime(0,0,0,$month,$day+(7-$dayWeek),$year));
               return $data;
    }

}
