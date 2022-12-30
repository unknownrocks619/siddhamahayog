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
            $table->id();
            $table->string('product_name');
            $table->string("slug");
            $table->string('product_type')->default('digital')->comment('digital', 'physical', 'both', 'services');
            $table->boolean('active')->default(false);
            $table->longText("short_description")->nullable();
            $table->longText('full_description')->nullable();
            $table->string('price');
            $table->longText("remarks");
            $table->boolean("allow_download")->default(false);
            $table->timestamps();
            $table->softDeletes();
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
