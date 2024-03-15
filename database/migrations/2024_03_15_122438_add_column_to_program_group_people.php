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
        Schema::table('program_group_people', function (Blueprint $table) {
            //
            $table->string('full_name')->nullable()->after('group_id');
            $table->string('phone_number')->nullable()->after('full_name');
            $table->string('email')->nullable()->after('phone_number');
            $table->string('group_uuid')->nullable()->after('colour');
            $table->boolean('is_card_generated')->default(false)->after('group_uuid');
            $table->integer('profile_id')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_group_people', function (Blueprint $table) {
            //
            $table->dropColumn(['full_name',
            'phone_number',
            'email',
            'group_uuid',
            'is_card_generated',
            'profile_id',]);
        });
    }
};
