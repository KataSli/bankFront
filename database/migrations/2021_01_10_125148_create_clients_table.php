<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->Bigincrements('id')->primaryKey();
            $table->string('login') ->unique();
            $table->string('haslo');
            $table->string('imie_nazwisko');
            $table->string('PESEL',11) ->unique();
            $table->string('adres');
            $table->string('kod_pocztowy', 5);
            $table->string('miejscowosc',255);
            $table->boolean('jestPracownikiem');
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
        Schema::dropIfExists('clients');
    }
}
