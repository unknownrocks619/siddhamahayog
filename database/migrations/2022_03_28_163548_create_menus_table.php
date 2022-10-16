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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('menu_name');
            $table->string('slug');
            $table->text("description")->nullable();
            $table->enum('menu_type', ["home", "gallery", 'about', 'contact', 'events', 'products', 'service', 'blog', 'donation', 'live', 'volunteer', 'page', 'post'])->default('home');
            $table->string('parent_menu')->nullable()->default(false);
            $table->string('sort_by')->default(1);
            $table->enum('menu_position', ["top", "main_menu", "footer_menu"])->default('main_menu');
            $table->boolean('active')->default(true);
            $table->string('display_type')->default("public")->comment('Available optiosn: draft, protected, private');
            $table->text('meta_title')->nullable();
            $table->string('menu_featured_image')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_image')->nullable();
            $table->text('meta_keyword')->nullable();
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
        Schema::dropIfExists('menus');
    }
};
