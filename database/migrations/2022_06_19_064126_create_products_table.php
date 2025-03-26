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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->nullable();
            $table->string('slug', 100)->nullable()->unique();
            $table->longText('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->bigInteger('views')->nullable()->default(1);
            $table->bigInteger('quantity')->nullable()->default(0);
            $table->enum('negotiable', ['Yes', 'No'])->default('No');
            $table->enum('tax', ['Yes', 'No'])->default('No');
            $table->enum('approvals', ['Approved', 'Pending', 'Rejected'])->default('Pending');
            $table->mediumText('seo_title')->nullable();
            $table->mediumText('seo_keyword')->nullable();
            $table->mediumText('seo_description')->nullable();
            $table->boolean('is_featured')->default(0);
            $table->string('prebooking')->default(1);
            $table->string('commisions')->default(1);
            // $table->integer('brand_id');
            $table->integer('super_store_status')->default(0);
            $table->boolean('status')->default(1);
            // $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
};
