<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSadhakReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sadhak_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('user_detail_id',100);
            $table->string('center_id')->comment('Foreign Key, Table branch');
            $table->string('user_sadhak_registration_id')->comment('Foreign Key, Table user_sadhak_registration');
            $table->string('user_sadhana_registration_preference_id')->comment('Foreign Key, table user_sadhana_registration_preferences');
            $table->string('total_rating');
            $table->text('reviews');
            $table->text('suggestion');
            $table->text("review_document")->nullable()->comment('upload document filled by user for confirmation');
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
        Schema::dropIfExists('sadhak_reviews');
    }
}
