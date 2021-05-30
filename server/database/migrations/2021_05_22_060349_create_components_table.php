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
            $table->integer('group_id');
            $table->integer('prev_group_id');
            $table->integer('parent_id');
            $table->smallInteger('type_id');
            $table->string('controller');
            $table->string('title')->nullable();
            $table->string('note')->nullable();
            $table->string('icon');
            $table->smallInteger('global');
            $table->smallInteger('protected');
            $table->timestamps();

                });
            };
            
            //Added columns 
            if (!Schema::hasColumn('components', 'config')){
                    Schema::table('components', function (Blueprint $table) {
                    $table->longText('config');
                });
            };

            //Removed columns 
            if (Schema::hasColumn('components', 'config2')){
                Schema::table('components', function (Blueprint $table){
                    $table->dropColumn('config2');
                });
            }

        

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('components');



    }



   
}
