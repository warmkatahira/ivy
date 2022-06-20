<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_histories', function (Blueprint $table) {
            $table->increments('inventory_id');
            $table->date('inventory_date');
            $table->time('inventory_time');
            $table->integer('operator_id');
            $table->string('operator_name');
            $table->string('item_code');
            $table->string('individual_jan_code');
            $table->string('brand_name')->nullable();
            $table->string('item_name_1');
            $table->string('item_name_2')->nullable();
            $table->integer('inventory_quantity');
            $table->integer('logical_stock');
            $table->string('inventory_result');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_histories');
    }
};
