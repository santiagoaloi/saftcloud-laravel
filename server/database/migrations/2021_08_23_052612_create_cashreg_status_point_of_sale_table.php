<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashregStatusPointOfSaleTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('cashreg_status_point_of_sale', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cashreg_status_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreignId('point_of_sale_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreignId('user_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->string('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('cashreg_status_point_of_sale');
    }
}
