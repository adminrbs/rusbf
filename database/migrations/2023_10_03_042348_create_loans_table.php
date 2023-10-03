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
        Schema::create('loans', function (Blueprint $table) {
            $table->id("loan_id");
            $table->string("loan_code",20)->nullable();
            $table->string("loan_name",100)->nullable();
            $table->string("description",255)->nullable();
            $table->decimal("amount",10,2)->nullable();
            $table->decimal("duration_of_membership",10,2)->nullable();
            $table->string("remarks",255)->nullable();

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
        Schema::dropIfExists('loans');
    }
};
