<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_statements', function (Blueprint $table) {
            $table->id();
            $table->integer("product_id");
            $table->integer("price");
            $table->integer("amount");
            $table->string("detail");
            $table->integer("company_id");
            $table->integer("customer_id");
            $table->integer("sell_person_id")->default(0);
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
        Schema::dropIfExists('income_statements');
    }
}
