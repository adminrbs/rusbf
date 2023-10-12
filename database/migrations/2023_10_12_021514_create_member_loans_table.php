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
        Schema::create('member_loans', function (Blueprint $table) {
            $table->id('member_loan_id');
            $table->integer('member_id');
            $table->integer('loan_id');
            $table->integer('loan_term_id');
            $table->decimal('no_of_terms')->nullable();
            $table->decimal('term_amount')->nullable();
            $table->decimal('term_interest_amount')->nullable();
            $table->decimal('term_interest_precentage')->nullable();
            $table->decimal('loan_amount');
            $table->decimal('current_term')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('member_loans');
    }
};
