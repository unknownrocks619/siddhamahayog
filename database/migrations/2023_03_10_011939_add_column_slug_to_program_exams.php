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
        Schema::table('program_exams', function (Blueprint $table) {
            //
            $table->longText('slug')->after('title')->nullable();
            $table->longText('section_id')->after('slug')->nullable();
            $table->longText('batch_id')->after('section_id')->nullable();
            $table->longText('exam_settings')->after('question_by_category')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_exams', function (Blueprint $table) {
            //
            $table->dropColumn('slug');
            $table->longText('section_id');
            $table->longText("batch_id");
            $table->longText('exam_settings');
        });
    }
};
