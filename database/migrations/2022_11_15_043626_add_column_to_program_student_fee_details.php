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
        Schema::table('program_student_fee_details', function (Blueprint $table) {
            //
            $table->foreignId('fee_added_by_user')->nullable()->constrained('members', 'id');
            $table->text('remark_from_uploader')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_student_fee_details', function (Blueprint $table) {
            //
        });
    }
};
