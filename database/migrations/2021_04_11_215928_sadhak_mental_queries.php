<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SadhakMentalQueries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('sadhak_mental_quries',function (Blueprint $table) {
            $table->id();
            $table->string('user_detail_id');
            $table->boolean('is_visitor_alone')->default(false)->nullable()->comment("if true, visitor is not alone or is with someone");
            $table->string('visitors_relative_name',100)->nullable()->comment('if visitor is not alone, provide who is there with visitor');
            $table->string('visitors_relative_relation',100)->nullable()->comment('visitor relation with relative');
            $table->string('visitors_relative_contact',100)->nullable();
            $table->boolean('is_first_visit')->default(false)->nullable()->comment();
            $table->boolean('have_physical_difficulties')->default(false)->nullable()->comment();
            $table->text('describe_physical_difficulties')->nullable();
            $table->boolean('have_mental_problem')->default(false)->nullable();
            $table->text('describe_mental_difficulties')->nullable();
            $table->boolean('have_practiced_before')->default(false)->nullable();
            $table->boolean('will_help')->default(false)->nullable();
            $table->string('ads_source',100)->nullable();
            $table->boolean('is_agreed_terms')->default(false)->nullable();
            $table->boolean('is_sadhak_linked')->default(false)->nullable();
            $table->string('sadhak_linked_id',100)->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
