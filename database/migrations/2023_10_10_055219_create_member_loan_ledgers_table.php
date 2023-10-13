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
        Schema::create('member_loan_ledgers', function (Blueprint $table) {
            $table->id('member_loan_ledger_id');
            $table->integer('member_loan_id');
            $table->integer('member_id');
            $table->integer('loan_id');
            $table->integer('loan_term_id');
            $table->integer('term');
            $table->double('amount');
            $table->double('interest_amount');
            $table->double('paid_amount');
            $table->double('paid_interest');
            $table->integer('year');
            $table->integer('month');
            $table->date('processed_date');
            $table->integer('user_id');
            $table->integer('status');
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
        Schema::dropIfExists('member_loan_ledgers');
    }
};
