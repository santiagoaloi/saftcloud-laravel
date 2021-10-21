<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionJobRoleTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('commission_job_role', function (Blueprint $table) {
            $table->foreignId('commission_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreignId('job_role_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('commission_job_role');
    }
}
