<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objectives', function (Blueprint $table) {
            $table->id();
            $table->integer("add_user_id")->nullable();
            $table->string("name");
            $table->integer("number1")->nullable();
            $table->integer("number2")->nullable();
            $table->integer("number3")->nullable();
            $table->string("text1")->nullable();
            $table->string("text2")->nullable();
            $table->string("text3")->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('objectives');
    }
}
