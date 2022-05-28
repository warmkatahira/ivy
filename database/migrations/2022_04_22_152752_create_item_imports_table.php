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
        Schema::create('item_imports', function (Blueprint $table) {
            $table->id();
            $table->string('item_code', 50);
            $table->string('integrate_jan_code')->nullable();
            $table->string('individual_jan_code');
            $table->string('brand_name')->nullable();
            $table->string('item_name_1');
            $table->string('item_name_2')->nullable();
            $table->integer('jan_start_position')->nullable();
            $table->integer('exp_start_position')->nullable();
            $table->integer('lot_start_position')->nullable();
            $table->integer('lot_length')->nullable();
            $table->string('s_power_code')->nullable();
            $table->string('s_power_code_start_position')->nullable();
            $table->string('location')->nullable();
            $table->boolean('qr_inspection_enabled');
            $table->integer('logical_stock')->nullable();
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
        Schema::dropIfExists('item_imports');
    }
};
