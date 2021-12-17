<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //Original Structure
        if (!Schema::hasTable('modules')) {
            Schema::create('modules', function (Blueprint $table) {
                $table->id();
                $table->foreignId('module_group_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
                $table->string('name')->unique();
                $table->longText('config');
                $table->longText('config_settings');
                $table->longText('status')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        };

        //Added columns 
        if (!Schema::hasColumn('modules', 'config')){
                Schema::table('modules', function (Blueprint $table) {
                $table->longText('config');
            });
        };
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropSoftDeletes();
            // Schema::dropIfExists('modules');
        });
    }
}
