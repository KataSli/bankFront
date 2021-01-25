<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->increments('id')->primaryKey();
            $table->string('nadawca',26);
            $table->string('odbiorca',26);
            $table->decimal('kwota',20,2);
            $table->enum('typ',['wewnetrzny','miedzybankowy','ekspresowy']);
            $table->string('tytul',140);
            $table->string('nazwa', 255);
            $table->string('adres');
            $table->string('kod_pocztowy',5);
            $table->string('miejscowosc',255);
            $table->boolean('jawny');
            $table->enum('status',['oczekuje na weryfikacje','w trakcie realizacji','wyslany','zrealizowany','odrzucony']);
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
        Schema::dropIfExists('transfers');
    }
}
