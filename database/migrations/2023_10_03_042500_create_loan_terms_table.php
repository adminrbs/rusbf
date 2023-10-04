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
        Schema::create('loan_terms', function (Blueprint $table) {
            $table->id("loan_term_id");
            $table->integer("loan_id");
            $table->string("no_of_terms")->nullable();
            $table->decimal("term_amount")->nullable();
            $table->decimal("term_interest_amount")->nullable();
            $table->integer("term_interest_precentage")->nullable(); // Use 'integer' here
            $table->string("remarks")->nullable();
           
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
        Schema::dropIfExists('loan_terms');
    }
};
