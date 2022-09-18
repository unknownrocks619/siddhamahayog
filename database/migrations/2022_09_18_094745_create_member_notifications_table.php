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
        Schema::create('member_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId("member_id")->constrained("members", "id");
            $table->text("title");
            $table->longText('body');
            $table->string('notification_type')->nullable()->comment("attach a model from which notification was generated.");
            $table->string("notification_id")->nullable();
            $table->string("type")->default("message")->comment("available option: model, message");
            $table->string("level")->default('info')->comment("available optiosn: info, error, warning, notice");
            $table->boolean("seen")->default(false);
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
        Schema::dropIfExists('member_notifications');
    }
};
