<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointOfSalesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::connection('system')->create('point_of_sales', function (Blueprint $table) {
            $table->id();
            $table->integer('branch_id');
            $table->integer('ptoVta');
            $table->string('name', 100);
            $table->string('address', 100);
            $table->string('detail', 100)->nullable();
            $table->smallInteger('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('point_of_sales');
    }
}
