<?php

namespace App\Http\Controllers;

use App\Transfer;
use Carbon\Carbon;
use Cassandra\Bigint;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function systemVerification(Transfer $transfer) {
        $ostatnie = Transfer::where('nadawca','=',$transfer->nadawca)->where('created_at','>', Carbon::now()->subDays(3));
        if($ostatnie != null) {
            $suma = 0;
            foreach($ostatnie as $i) {
                $suma = $suma + $i->kwota;
            }
        }
        if($suma > 5000) {
            //do ręcznej weryfikacji
            $transfer->status = 1;
            $transfer->update();
        }
        else {
            $transfer->status = 4;
            app('App\Http\Controllers\AccountController')->changeInternalBillingAccountBalance($transfer->kwota*(-1));
            app('App\Http\Controllers\AccountController')->newBalance($transfer->odbiorca, $transfer->kwota);
            $transfer->update();
        }
    }

    public function manualVerification(Request $request) {
        $id = $request->get('id');
        $ver = $request->get('ver');
        $transfer = Transfer::where('id','=',$id)->get();
        if($ver) {
            $transfer->status = 4;
            app('App\Http\Controllers\AccountController')->changeInternalBillingAccountBalance($transfer->kwota*(-1));
            app('App\Http\Controllers\AccountController')->newBalance($transfer->odbiorca, $transfer->kwota);
            $transfer->update();
        }
        else {
            $transfer->status = 5;
            app('App\Http\Controllers\AccountController')->changeInternalBillingAccountBalance($transfer->kwota*(-1));
            app('App\Http\Controllers\AccountController')->newBalance($transfer->nadawca, $transfer->kwota);
            $transfer->update();
        }
    }
}
