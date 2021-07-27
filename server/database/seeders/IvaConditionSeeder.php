<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IvaConditionSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('iva_conditions')->insert([
            ["id"=>1, "country_id"=> 12, "name"=>"IVA Responsable Inscripto", "short_name"=>"RI", "value"=>1],
            ["id"=>2, "country_id"=> 12, "name"=>"IVA Responsable no Inscripto", "short_name"=>"IRNI", "value"=>2],
            ["id"=>3, "country_id"=> 12, "name"=>"IVA no Responsable", "short_name"=>"INR", "value"=>3],
            ["id"=>4, "country_id"=> 12, "name"=>"IVA Sujeto Exento", "short_name"=>"ISE", "value"=>4],
            ["id"=>5, "country_id"=> 12, "name"=>"Consumidor Final", "short_name"=>"CF", "value"=>5],
            ["id"=>6, "country_id"=> 12, "name"=>"Responsable Monotributo", "short_name"=>"RM", "value"=>6],
            ["id"=>7, "country_id"=> 12, "name"=>"Sujeto no Categorizado", "short_name"=>"SNC", "value"=>7],
            ["id"=>8, "country_id"=> 12, "name"=>"Proveedor del Exterior", "short_name"=>"PDE", "value"=>8],
            ["id"=>9, "country_id"=> 12, "name"=>"Cliente del Exterior", "short_name"=>"CDE", "value"=>9],
            ["id"=>10, "country_id"=> 12, "name"=>"IVA Liberado – Ley Nº 19.640", "short_name"=>"IL", "value"=>10],
            ["id"=>11, "country_id"=> 12, "name"=>"IVA Responsable Inscripto – Agente de Percepción", "short_name"=>"RIAP", "value"=>11],
            ["id"=>12, "country_id"=> 12, "name"=>"Pequeño Contribuyente Eventual", "short_name"=>"PCE", "value"=>12],
            ["id"=>13, "country_id"=> 12, "name"=>"Monotributista Social", "short_name"=>"MS", "value"=>13],
            ["id"=>14, "country_id"=> 12, "name"=>"Pequeño Contribuyente Eventual Social", "short_name"=>"PCES", "value"=>14]
        ]);
    }
}
