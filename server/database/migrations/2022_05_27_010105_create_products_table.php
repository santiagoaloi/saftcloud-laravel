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
            $table->foreignId('product_category_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreignId('product_family_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreignId('product_brand_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->string('product_name');
            $table->string('quantity');
            $table->unsignedBigInteger('unimed_id');
            $table->foreign('unimed_id')->references('id')->on('look_up_list_values')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->decimal('cost_net', 20, 2);
            $table->decimal('cost_untaxed', 20, 2);
            $table->unsignedBigInteger('iva_id');
            $table->foreign('iva_id')->references('id')->on('look_up_list_values')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->unsignedBigInteger('mkup_id');
            $table->foreign('mkup_id')->references('id')->on('look_up_list_values')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->decimal('price', 20, 2);
            $table->unsignedBigInteger('commission_id');
            $table->foreign('commission_id')->references('id')->on('look_up_list_values')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->decimal('stock', 11, 2);
            $table->decimal('inventory', 11, 2);
            $table->smallInteger('can_have_promotion')->default('1');
            $table->foreignId('product_promotion_id')->constrained()->onDelete('RESTRICT')->onUpdate('CASCADE'); //->default('1');
            $table->decimal('price_last_record', 20, 2)->nullable();
            $table->string('avatar')->nullable();
            $table->smallInteger('incremental_type');
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
        Schema::dropIfExists('products');
    }
}
