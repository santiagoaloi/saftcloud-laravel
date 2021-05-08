<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::connection('system')->create('companies', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id');
            $table->string('company_name', 100);
            $table->string('company_alias', 100);
            $table->integer('country_id');
            $table->string('state', 100);
            $table->string('city', 100);
            $table->string('address', 100);
            $table->integer('iva_cond_id');
            $table->integer('document_id');
            $table->bigInteger('document_number');
            $table->bigInteger('ing_brutos_number');
            $table->date('start_activity');
            $table->string('email', 100);
            $table->string('web', 100);
            $table->string('twitter', 100);
            $table->string('instagram', 100);
            $table->string('facebook', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('companies');
    }
}
