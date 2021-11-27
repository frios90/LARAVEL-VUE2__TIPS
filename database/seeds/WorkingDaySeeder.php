<?php

use Illuminate\Database\Seeder;
use App\Entities\Working;

class WorkingDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now();

        Working::insert([
            'name' => 'morning',
            'label' => 'Jornada de manaña',           
            'created_at' => $now,
            'updated_at' => $now
        ],
        [
            'name' => 'noon',
            'label' => 'Jornada de tarde',           
            'created_at' => $now,
            'updated_at' => $now
        ],
        [
            'name' => 'night',
            'label' => 'Jornada de noche',           
            'created_at' => $now,
            'updated_at' => $now
            ]);
            Working::insert(
              
            [
                'name' => 'noon',
                'label' => 'Jornada de tarde',           
                'created_at' => $now,
                'updated_at' => $now
            ]);
            Working::insert(
            [
                'name' => 'night',
                'label' => 'Jornada de noche',           
                'created_at' => $now,
                'updated_at' => $now
                ]);    
    }
}
