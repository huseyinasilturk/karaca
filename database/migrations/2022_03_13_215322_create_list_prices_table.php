<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_prices', function (Blueprint $table) {
            $table->id();
            $table->integer("company_id")->default(0)->nullable();
            $table->decimal("list_price",11,2)->default(0)->nullable();
            $table->integer("product_id")->default(0)->nullable();
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
        Schema::dropIfExists('list_prices');
    }
}
