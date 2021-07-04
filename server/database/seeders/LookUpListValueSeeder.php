<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GeneralConfig\LookUpListValue;

class LookUpListValueSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $LookUpListValue = [
                ["id"=> 1, "look_up_list_id"=> 1, "name"=> "Empresa", "value"=> 1],
                ["id"=> 2, "look_up_list_id"=> 1, "name"=> "Persona", "value"=> 2],
                ["id"=> 11, "look_up_list_id"=> 2, "name"=> "IVA Responsable Inscripto", "value"=> 1],
                ["id"=> 12, "look_up_list_id"=> 2, "name"=> "IVA Responsable no Inscripto", "value"=> 2],
                ["id"=> 13, "look_up_list_id"=> 2, "name"=> "IVA no Responsable", "value"=> 3],
                ["id"=> 14, "look_up_list_id"=> 2, "name"=> "IVA Sujeto Exento", "value"=> 4],
                ["id"=> 15, "look_up_list_id"=> 2, "name"=> "Consumidor Final", "value"=> 5],
                ["id"=> 16, "look_up_list_id"=> 2, "name"=> "Responsable Monotributo", "value"=> 6],
                ["id"=> 17, "look_up_list_id"=> 2, "name"=> "Sujeto no Categorizado", "value"=> 7],
                ["id"=> 18, "look_up_list_id"=> 2, "name"=> "Proveedor del Exterior", "value"=> 8],
                ["id"=> 19, "look_up_list_id"=> 2, "name"=> "Cliente del Exterior", "value"=> 9],
                ["id"=> 20, "look_up_list_id"=> 2, "name"=> "IVA Liberado – Ley Nº 19.640", "value"=> 10],
                ["id"=> 21, "look_up_list_id"=> 2, "name"=> "IVA Responsable Inscripto – Agente de Percepción", "value"=> 11],
                ["id"=> 22, "look_up_list_id"=> 2, "name"=> "Pequeño Contribuyente Eventual", "value"=> 12],
                ["id"=> 23, "look_up_list_id"=> 2, "name"=> "Monotributista Social", "value"=> 13],
                ["id"=> 24, "look_up_list_id"=> 2, "name"=> "Pequeño Contribuyente Eventual Social", "value"=> 14],
                ["id"=> 25, "look_up_list_id"=> 3, "name"=> "CUIT", "value"=> 80],
                ["id"=> 26, "look_up_list_id"=> 3, "name"=> "CDI", "value"=> 87],
                ["id"=> 27, "look_up_list_id"=> 3, "name"=> "CI Extranjera", "value"=> 91],
                ["id"=> 28, "look_up_list_id"=> 3, "name"=> "Pasaporte", "value"=> 94],
                ["id"=> 29, "look_up_list_id"=> 3, "name"=> "DNI", "value"=> 96],
                ["id"=> 30, "look_up_list_id"=> 3, "name"=> "Sin identificar", "value"=> 99],
                ["id"=> 31, "look_up_list_id"=> 4, "name"=> "FACTURA A", "value"=> 1],
                ["id"=> 32, "look_up_list_id"=> 4, "name"=> "NOTA DE DEBITO A", "value"=> 2],
                ["id"=> 33, "look_up_list_id"=> 4, "name"=> "NOTA DE CREDITO A", "value"=> 3],
                ["id"=> 34, "look_up_list_id"=> 4, "name"=> "FACTURA B", "value"=> 6],
                ["id"=> 35, "look_up_list_id"=> 4, "name"=> "NOTA DE DEBITO B", "value"=> 7],
                ["id"=> 36, "look_up_list_id"=> 4, "name"=> "NOTA DE CREDITO B", "value"=> 8],
                ["id"=> 37, "look_up_list_id"=> 4, "name"=> "FACTURA C", "value"=> 11],
                ["id"=> 38, "look_up_list_id"=> 4, "name"=> "NOTA DE DEBITO C", "value"=> 12],
                ["id"=> 39, "look_up_list_id"=> 4, "name"=> "NOTA DE CREDITO C", "value"=> 13],
                ["id"=> 40, "look_up_list_id"=> 4, "name"=> "FACTURA M", "value"=> 51],
                ["id"=> 41, "look_up_list_id"=> 4, "name"=> "NOTA DE DEBITO M", "value"=> 52],
                ["id"=> 42, "look_up_list_id"=> 4, "name"=> "NOTA DE CREDITO M", "value"=> 53],
                ["id"=> 43, "look_up_list_id"=> 4, "name"=> "ORDEN DE VENTA", "value"=> 1001],
                ["id"=> 44, "look_up_list_id"=> 4, "name"=> "PRESUPUESTO", "value"=> 1002],
                ["id"=> 45, "look_up_list_id"=> 4, "name"=> "NOTA DE DEBITO ORDEN DE VENTA", "value"=> 1003],
                ["id"=> 46, "look_up_list_id"=> 4, "name"=> "NOTA DE CREDITO ORDEN DE VENTA", "value"=> 1004],
                ["id"=> 47, "look_up_list_id"=> 5, "name"=> "Productos", "value"=> 1],
                ["id"=> 48, "look_up_list_id"=> 5, "name"=> "Servicios", "value"=> 2],
                ["id"=> 49, "look_up_list_id"=> 5, "name"=> "Productos y Servicios", "value"=> 3],
                ["id"=> 50, "look_up_list_id"=> 6, "name"=> "Fijo", "value"=> 1],
                ["id"=> 51, "look_up_list_id"=> 6, "name"=> "Variable", "value"=> 2],
                ["id"=> 52, "look_up_list_id"=> 7, "name"=> "Factura", "value"=> 1],
                ["id"=> 53, "look_up_list_id"=> 7, "name"=> "Presupuesto", "value"=> 2],
                ["id"=> 54, "look_up_list_id"=> 8, "name"=> "Apertura", "value"=> 1],
                ["id"=> 55, "look_up_list_id"=> 8, "name"=> "Cierre", "value"=> 2],
                ["id"=> 56, "look_up_list_id"=> 8, "name"=> "Egreso", "value"=> 3],
                ["id"=> 57, "look_up_list_id"=> 8, "name"=> "Ingreso", "value"=> 4],
                ["id"=> 58, "look_up_list_id"=> 9, "name"=> "Lunes", "value"=> 1],
                ["id"=> 59, "look_up_list_id"=> 9, "name"=> "Martes", "value"=> 2],
                ["id"=> 60, "look_up_list_id"=> 9, "name"=> "Miercoles", "value"=> 3],
                ["id"=> 61, "look_up_list_id"=> 9, "name"=> "Jueves", "value"=> 4],
                ["id"=> 62, "look_up_list_id"=> 9, "name"=> "Viernes", "value"=> 5],
                ["id"=> 63, "look_up_list_id"=> 9, "name"=> "Sabado", "value"=> 6],
                ["id"=> 64, "look_up_list_id"=> 9, "name"=> "Domingo", "value"=> 7],
                ["id"=> 65, "look_up_list_id"=> 10, "name"=> "Efectivo", "value"=> 1],
                ["id"=> 66, "look_up_list_id"=> 10, "name"=> "Debito", "value"=> 2],
                ["id"=> 67, "look_up_list_id"=> 10, "name"=> "Credito", "value"=> 3],
                ["id"=> 68, "look_up_list_id"=> 10, "name"=> "Cuenta Corriente", "value"=> 4],
                ["id"=> 69, "look_up_list_id"=> 11, "name"=> "Litro", "value"=> 1],
                ["id"=> 70, "look_up_list_id"=> 11, "name"=> "Kilogramo", "value"=> 2],
                ["id"=> 71, "look_up_list_id"=> 11, "name"=> "Unidades", "value"=> 3],
                ["id"=> 72, "look_up_list_id"=> 11, "name"=> "Metro", "value"=> 4],
                ["id"=> 73, "look_up_list_id"=> 12, "name"=> "Mililitro", "value"=> 1],
                ["id"=> 74, "look_up_list_id"=> 12, "name"=> "Litro", "value"=> 2],
                ["id"=> 75, "look_up_list_id"=> 12, "name"=> "Miligramo", "value"=> 3],
                ["id"=> 76, "look_up_list_id"=> 12, "name"=> "Gramo", "value"=> 4],
                ["id"=> 77, "look_up_list_id"=> 12, "name"=> "Kilogramo", "value"=> 5],
                ["id"=> 78, "look_up_list_id"=> 12, "name"=> "Centimetro cubico", "value"=> 6],
                ["id"=> 79, "look_up_list_id"=> 12, "name"=> "Unidades", "value"=> 7],
                ["id"=> 80, "look_up_list_id"=> 12, "name"=> "Metros", "value"=> 8],
                ["id"=> 81, "look_up_list_id"=> 13, "name"=> "Pendiente", "value"=> 1],
                ["id"=> 82, "look_up_list_id"=> 13, "name"=> "Señado", "value"=> 2],
                ["id"=> 83, "look_up_list_id"=> 13, "name"=> "Pago", "value"=> 3],
                ["id"=> 84, "look_up_list_id"=> 13, "name"=> "Facturado", "value"=> 4],
                ["id"=> 85, "look_up_list_id"=> 13, "name"=> "Garantia", "value"=> 5],
                ["id"=> 86, "look_up_list_id"=> 14, "name"=> "Pedido tomado", "value"=> 1],
                ["id"=> 87, "look_up_list_id"=> 14, "name"=> "En preparacion", "value"=> 2],
                ["id"=> 88, "look_up_list_id"=> 14, "name"=> "Facturado", "value"=> 3],
                ["id"=> 89, "look_up_list_id"=> 14, "name"=> "En distribucion", "value"=> 4],
                ["id"=> 90, "look_up_list_id"=> 14, "name"=> "Facturado y entregado", "value"=> 5],
                ["id"=> 91, "look_up_list_id"=> 14, "name"=> "No entregado", "value"=> 6],
                ["id"=> 92, "look_up_list_id"=> 14, "name"=> "Rechazado", "value"=> 7]
        ];

        LookUpListValue::create($LookUpListValue);
    }
}
