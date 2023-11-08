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
        Schema::create('death_gratuity_requests_attachments', function (Blueprint $table) {
            $table->id('death_gratuity_requests_attachments_id');
            $table->integer('death_gratuity_requestss_id')->nullable();
            $table->string('description')->nullable();
            $table->string('attachment')->nullable();
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
        Schema::dropIfExists('death_gratuity_requests_attachments');
    }
};
