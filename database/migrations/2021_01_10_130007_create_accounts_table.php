<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->Bigincrements('id')->primaryKey();
            $table->string('numer',26);
            $table->decimal('saldo',20,2);
            $table->timestamps();
        });

        $internalBilling = app('App\Http\Controllers\AccountController')->calculateAccountNumber('00000000000001');
        $mainBilling = app('App\Http\Controllers\AccountController')->calculateAccountNumber('00000000000002');
        $expressBilling = app('App\Http\Controllers\AccountController')->calculateAccountNumber('00000000000003');
        $data = array( "numer" => $internalBilling, "saldo" => 0,"created_at" => Carbon::now()->toDateTimeString());
        DB::table('accounts')->insert($data);
        $data = array( "numer" => $mainBilling, "saldo" => 0,"created_at" => Carbon::now()->toDateTimeString());
        DB::table('accounts')->insert($data);
        $data = array( "numer" => $expressBilling, "saldo" => 0,"created_at" => Carbon::now()->toDateTimeString());
        DB::table('accounts')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
