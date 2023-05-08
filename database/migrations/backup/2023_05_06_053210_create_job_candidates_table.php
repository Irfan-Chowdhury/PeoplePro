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
        Schema::create('job_candidates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('job_id')->index('job_candidates_job_id_foreign');
            $table->string('full_name', 191);
            $table->string('email', 191);
            $table->string('phone', 191);
            $table->text('address')->nullable();
            $table->longText('cover_letter');
            $table->string('fb_id', 191)->nullable();
            $table->string('linkedin_id', 191)->nullable();
            $table->string('cv', 191);
            $table->string('status', 191);
            $table->string('remarks', 191);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_candidates');
    }
};
