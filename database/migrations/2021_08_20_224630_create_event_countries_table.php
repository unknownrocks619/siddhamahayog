<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_countries', function (Blueprint $table) {
            $table->id();
            $table->string('meeting_id')->nullable();
            $table->string("user_detail_id")->nullable();
            $table->text('join_link');
            $table->boolean('joined')->default(false);
            $table->string('joined_at')->nullable();
            // $table->string('end_time')->nullable();
            // $table->boolean('meeting_locked')->default(false);
            // $table->string('created_by')->nullable();
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
        Schema::dropIfExists('event_countries');
    }
}
