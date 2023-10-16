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
        Schema::create('members_loan_requests', function (Blueprint $table) {
            $table->id('members_loan_request_id');
            $table->integer('member_id');
            $table->string('membership_no');
            $table->string('contact_no')->nullable();
            $table->integer('service_period')->nullable();
            $table->date('date_of_enlistment')->nullable();
            $table->decimal('Monthly_basic_salary', 10, 2)->nullable();
            $table->string('computer_no', 50)->nullable();
            $table->string('nic_no')->nullable();
            $table->integer('manner_of_repayment')->nullable();
            $table->string('reason')->nullable();
            $table->string('private_address', 255)->nullable();
            $table->date('date')->nullable();
            $table->integer('loan_id');
            $table->integer('term_id');
            $table->integer('prepared_by')->nullable();
            $table->integer('corrected_by')->nullable();
            $table->integer('approval_status')->default(0);


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
        Schema::dropIfExists('members_loan_requests');
    }
};
