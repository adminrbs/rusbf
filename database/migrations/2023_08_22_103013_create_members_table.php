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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_number', 20);
            $table->string('full_name', 200);
            $table->string('name_initials', 200);
            $table->string('full_name_unicode', 250)->nullable();
            $table->string('name_initials_unicode', 250);
            $table->string('personal_address', 250);
            $table->string('national_id_number', 15);
            $table->date('date_of_birth');
            $table->date('date_of_joining');
            $table->string('home_phone_number', 50)->nullable();
            $table->string('mobile_phone_number', 50)->nullable();
            $table->integer('serving_sub_department_id');
            $table->string('cabinet_number', 50)->nullable();
            $table->string('official_number', 50);
            $table->integer('designation_id');
            $table->string('computer_number', 50);
            $table->string('work_location_id');
            $table->string('payroll_number', 50);
            $table->integer('payroll_preparation_location_id');
            $table->string('beneficiary_full_name', 200);
            $table->string('beneficiary_relationship', 250);
            $table->string('beneficiary_private_address', 250);
            $table->string('monthly_payment_amount', 10);
            $table->integer('language_id');
            $table->string('member_whatsapp')->nullable();
            $table->string('member_email')->nullable();
            $table->string('beneficiary_email')->nullable();
            $table->string('beneficiary_nic')->nullable();
            $table->string('path', 300)->nullable();
            $table->integer('ref_by')->nullable();
            $table->integer('prepared_by');
            $table->integer('create_by')->nullable();
            $table->integer('update_by')->nullable();
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
        Schema::dropIfExists('members');
    }
};
