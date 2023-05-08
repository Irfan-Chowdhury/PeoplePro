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
        Schema::create('official_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id')->nullable()->index('official_documents_company_id_foreign');
            $table->unsignedBigInteger('document_type_id')->nullable()->index('official_documents_document_type_id_foreign');
            $table->unsignedBigInteger('added_by')->nullable()->index('official_documents_added_by_foreign');
            $table->string('document_title', 191);
            $table->string('identification_number', 191);
            $table->mediumText('description')->nullable();
            $table->string('document_file', 191)->nullable();
            $table->date('expiry_date');
            $table->tinyInteger('is_notify')->nullable();
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
        Schema::dropIfExists('official_documents');
    }
};
