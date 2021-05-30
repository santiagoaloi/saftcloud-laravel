<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->string('bar_code');
            $table->string('sku');
            $table->integer('category_id');
            $table->integer('family_id');
            $table->integer('brand_id');
            $table->string('product_name');
            $table->string('quantity');
            $table->integer('unimed_id');
            $table->decimal('cost_net', 20, 2);
            $table->decimal('cost_untaxed', 20, 2);
            $table->foreign('iva_id')->references('id')->on('look_up_list_values')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreign('mkup_id')->references('id')->on('look_up_list_values')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->decimal('price', 20, 2);
            $table->foreign('commission_id')->references('id')->on('look_up_list_values')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->decimal('stock', 11, 2);
            $table->decimal('inventory', 11, 2);
            $table->smallInteger('can_have_promotion')->default('1');
            $table->foreign('promotion_id')->default('1');
            $table->decimal('cost_net_last_record', 20, 2)->nullable();
            $table->decimal('cost_untaxed_last_record', 20, 2)->nullable();
            $table->foreign('id_iva_last_record')->references('id')->on('look_up_list_values')->onDelete('RESTRICT')->onUpdate('CASCADE')->nullable();
            $table->foreign('mkup_id_last_record')->references('id')->on('look_up_list_values')->onDelete('RESTRICT')->onUpdate('CASCADE')->nullable();
            $table->decimal('price_last_record', 20, 2)->nullable();
            $table->string('avatar')->nullable();
            $table->smallInteger('incremental_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('products');
    }
}
