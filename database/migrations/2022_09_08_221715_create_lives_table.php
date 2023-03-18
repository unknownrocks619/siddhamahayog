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
        Schema::create('lives', function (Blueprint $table) {
            $table->id();
            $table->foreignId("program_id")->constrained("programs", "id");
            $table->boolean("live")->default(true);
            $table->foreignId("section_id")->nullable()->constrained("program_sections", "id");
            $table->string("meeting_id")->nullable();
            $table->foreignId("zoom_account_id")->constrained('zoom_accounts', "id");
            $table->longText("admin_start_url")->nullable();
            $table->longText("join_url")->nullable();
            $table->string("ends_at")->nullable();
            $table->boolean('lock')->default(false);
            $table->longText("lock_text")->nullable();
            $table->integer("started_by")->nullable();
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
        Schema::dropIfExists('lives');
    }
};
