<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComponentsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //Original Structure
        if (!Schema::hasTable('components')) {
            Schema::create('components', function (Blueprint $table) {
                $table->id();
                $table->foreignId('component_group_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
                $table->longText('config');
                $table->longText('config_settings');
                $table->longText('status')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        };

        //Added columns 
        if (!Schema::hasColumn('components', 'config')){
                Schema::table('components', function (Blueprint $table) {
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
        Schema::table('components', function (Blueprint $table) {
            $table->dropSoftDeletes();
            // Schema::dropIfExists('components');
        });
    }
}
