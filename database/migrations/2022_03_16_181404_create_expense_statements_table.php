<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_statements', function (Blueprint $table) {
            $table->id();
            $table->decimal("price", 11, 2);
            $table->longText("detail");
            $table->string("table_name");
            $table->integer("expense_type_id");
            $table->integer("table_id");
            $table->integer("company_id");
            $table->date("expense_date");
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
        Schema::dropIfExists('expense_statements');
    }
}
