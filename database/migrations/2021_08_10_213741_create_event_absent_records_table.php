<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventAbsentRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_absent_records', function (Blueprint $table) {
            $table->id();
            $table->string('sibir_record_id')->index();
            $table->string('user_detail_id')->index();
            $table->string('absent_from');
            $table->string("nod")->nulllable();
            $table->string('absent_till')->nullable();
            $table->text('reason')->nullable();
            $table->boolean('status')->default(false);
            $table->string('absent_approved')->nullable();
            $table->string('absent_approved_by')->nullable();
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
        Schema::dropIfExists('event_absent_records');
    }
}
