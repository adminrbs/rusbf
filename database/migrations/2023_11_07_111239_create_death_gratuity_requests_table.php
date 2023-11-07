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
        Schema::create('death_gratuity_requests', function (Blueprint $table) {
            $table->id('death_gratuity_requestss_id');
            $table->integer('member_id');
            $table->integer('designation_id');
            $table->integer('serving_sub_department_id');
            $table->string('full_name_of_the_deceased_person')->nullable();
            $table->string('date_and _place_of_death')->nullable();
            $table->string('relationship_to_the_deceased_person')->nullable();
            $table->string('age_of_deceased')->nullable();
            $table->string('gender_of_deceased_person')->nullable();
            $table->string('death_certificate_No')->nullable();
            $table->date('issued_date')->nullable();
            $table->string('issued_place')->nullable();
            $table->string('birth_certificate_no')->nullable();
            $table->string('marriage_certificate_no')->nullable();
            $table->date('gs_date')->nullable();
            $table->date('date_of_oic')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('death_gratuity_requests');
    }
};
