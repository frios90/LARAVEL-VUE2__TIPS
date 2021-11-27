<?php

use Illuminate\Database\Seeder;
use App\Entities\License;


class LicensesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        License::create(
        [
            'name' => 'Licencia de prueba',
            'code' => 'DEMO',           
            'qty_staff' => 10,
            'qty_user' => 1,
            'value' => 0, //0
            'qty_work_month' => 5
        ]);
        License::create(
        [
            'name' => 'Licencia básica',
            'code' => 'BASIC',           
            'qty_staff' => 20,
            'qty_user' => 1,
            'value' => 9900, //9000
            'qty_work_month' => 100
        ]);
        License::create(
        [
            'name' => 'Licencia avanzada',
            'code' => 'ADVANCE',           
            'qty_staff' => 35,
            'qty_user' => 2,
            'value' => 13200,//12000,
            'qty_work_month' => 200
        ]);
        License::create(
        [
            'name' => 'Licencia PRO',
            'code' => 'PRO',           
            'qty_staff' => 50,
            'qty_user' => 3,
            'value' => 16500, //15000
            'qty_work_month' => 300
        ]);    
    }
}
