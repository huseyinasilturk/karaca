<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVeresiyesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veresiyes', function (Blueprint $table) {
            $table->id();
            $table->integer("musteri_id")->nullable();
            $table->integer("veresiye_tipi")->nullable();
            $table->string("toplamFiyat")->nullable();
            $table->string("ödenenFiyat")->nullable();
            $table->string("detail")->nullable();
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
        Schema::dropIfExists('veresiyes');
    }
}
