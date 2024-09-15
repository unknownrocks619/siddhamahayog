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
        Schema::table('images', function (Blueprint $table) {
            //
            $table->string('bucket_type')
                    ->after('access_type')
                    ->default('local')
                    ->comment('currently available: local,cloudinary');

            $table->string('public_id')->nullable()->after('bucket_type');
            $table->longText('bucket_upload_response')->after('public_id')->nullable();
            $table->longText('upload_revision')->nullable()->after('bucket_upload_response');
            $table->string('bucket_filename')->nullable()->after('upload_revision');
            $table->string('bucket_filepath')->nullable()->after('bucket_filename');
            $table->string('bucket_signature')->nullable()->after('bucket_filepath');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            //
            $table->dropColumn(['bucket_type','public_id','bucket_upload_response','upload_revision','bucket_filename','bucket_filepath','bucket_signature']);
        });
    }
};
