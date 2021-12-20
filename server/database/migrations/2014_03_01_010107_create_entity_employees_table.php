<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntityEmployeesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('entity_employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('job_role_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->string('work_shift_hours');
            $table->string('start_work_date');
            $table->string('finish_work_date');
            $table->string('payment_method');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('entity_employees');
    }
}
