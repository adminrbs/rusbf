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
        Schema::create('member_contribution_ledgers', function (Blueprint $table) {
            $table->id('member_contribution_ledger_id');
            $table->integer('contribution_id');
            $table->integer('member_id');
            $table->integer('year');
            $table->integer('month');
            $table->double('amount');
            $table->date('processed_date');
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
        Schema::dropIfExists('member_contribution_ledgers');
    }
};
