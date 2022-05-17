<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('program_name');
            $table->string("slug");
            $table->enum('program_type',["paid","open","club","other","limited","registered_user","sadhana"])->default('paid');
            $table->string("monthly_fee")->nullable()->comment("monthly Fee Amount for paid course and can be used for limited type as well");
            $table->string("program_duration")->nullable()->comment("if field is empty program doesn't have lifespan, value should be date range.");
            $table->string("program_access")->nullable()->comment('registration, for registered participants');
            $table->string("admission_fee")->nullable()->comment("admission fee for given program.");
            $table->longText("description")->nullable();
            $table->boolean("promote")->default(false);
            $table->string('overdue_allowed')->nullable()->comment('max no. of days allowed for unpaid user.');
            $table->boolean("batch")->default(false);
            $table->boolean("zoom")->default(true);
            $table->string("meeting_id")->nullable();
            $table->string('status')->default("pending")->comment("available options: pending, active, close, inactive, review");
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
        Schema::dropIfExists('programs');
    }
}
