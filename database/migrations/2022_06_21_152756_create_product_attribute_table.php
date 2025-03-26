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
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
	        $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->string('sku')->nullable();
            $table->string('sizes')->nullable();
            $table->string('colors')->nullable();
            $table->double('real_prices', 11, 2)->default(0);
            $table->double('sale_prices', 12, 2)->default(0);
	        $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
	        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('product_attribute');
    }
};
