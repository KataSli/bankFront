<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_accounts', function (Blueprint $table) {
            $table->Bigincrements('id')->primaryKey();
            $table->unsignedBigInteger('id_klienta');
            $table->unsignedBigInteger('id_konta');
            $table->foreign('id_klienta')->references('id')->on('clients')->onUpdate('cascade');
            $table->foreign('id_konta')->references('id')->on('accounts')->onUpdate('cascade');
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
        Schema::dropIfExists('client_accounts');
    }
}
