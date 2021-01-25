<?php

namespace App\Http\Controllers;

use App\Account;
use App\Client;
use App\ClientAccount;
use App\Transfer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;
use Spatie\ArrayToXml\ArrayToXml;

class TransferController extends Controller
{
    //TODO: wysyłanie do API JR + wywołanie o odpowiedniej porze + pobieranie danych nadawcy z bazy + pełny numer konta
    public function sendFiles()
    {
        $transfers = Transfer::where('status', '=', 2)->get()->toArray();
        $amount = 0;

        foreach ($transfers as $t) {
            $amount = $amount + $t['kwota'];
        }
        $array = ['Bank data' => ['Bank' => '132421', 'Amount' => $amount], 'Transfer' => $transfers];
        $result = ArrayToXml::convert($array, 'Data');
        return $result;
    }

    public function getTransfers(Request $request)
    {
        $account = $request->get('account_number');
        $transfers = Transfer::where('nadawca', '=', $account)->orWhere('odbiorca', '=', $account)->orderBy('created_at', 'desc')->get();
        return $transfers;
    }

    public function getNewestTransfers(Request $request)
    {
        $account = $request->get('account_number');
        $transfers = Transfer::where('nadawca', '=', $account)->orWhere('odbiorca', '=', $account)->orderBy('created_at', 'desc')->take(5)->get();
        return $transfers;
    }

    //TODO: wywołanie o odpowiedniej porze
    public function getFile()
    {

    }

    //TODO: konto docelowe nie istnieje
    public function internalTransfer(Request $request)
    {
        $kwota = $request->get('kwota');
        $kwota = floatval ($kwota);
        $nadawca = $request->get('nadawca');
        $konto_nad = Account::where('numer', '=', $nadawca)->get()->first();

        $id_nad = ClientAccount::where('id_konta','=',$konto_nad->id)->get()->first();

        $dane_nad = Client::where('id','=',$id_nad->id_klienta)->get()->first();

        $transfer = new Transfer();
        $transfer->nadawca = $nadawca;
        $transfer->nazwa_nad = $dane_nad->imie_nazwisko;
        $transfer->adres_nad = $dane_nad->adres;
        $transfer->miejscowosc_nad = $dane_nad->miejscowosc;
        $transfer->kod_pocztowy_nad = $dane_nad->kod_pocztowy;

        $odbiorca = $request->get('odbiorca');
        $transfer->odbiorca = $odbiorca;
        $transfer->tytul = $request->get('tytul');
        $transfer->kwota = $kwota;
        $transfer->nazwa_odb = $request->get('imie_nazwisko');

        $transfer->adres_odb = $request->get('adres');
        $transfer->miejscowosc_odb = $request->get('miejscowosc');
        $transfer->kod_pocztowy_odb = $request->get('kod');
        $transfer->jawny = 1;
        $transfer->typ = 1;

        $transfer->created_at = Carbon::now()->toDateTimeString();

        if ($konto_nad->saldo < $kwota) {
            $transfer->status = 5;
            $transfer->save();
            return 0;
        }

        app('App\Http\Controllers\AccountController')->changeBalance($nadawca, $kwota*(-1));

        //Warunek określający inicjacją weryfikacji przelewu
        if ($kwota > 1000) {
            //changeBillingAccountBalance
            app('App\Http\Controllers\AccountController')->changeInternalBillingAccountBalance($kwota);
            $transfer->status = 1;
            $transfer->save();

            app('App\Http\Controllers\VerificationController')->systemVerification($transfer); //wysłanie przelewu do wewnętrnzej jednostki rozliczeniowej
            return 1;
        } else {
            $transfer->status = 4;
            $ret = app('App\Http\Controllers\AccountController')->changeBalance($odbiorca, $kwota);
            $transfer->save();

            return 1;
        }
    }

    public function standardTransfer(Request $request)
    {
        $kwota = $request->get('kwota');
        $kwota = floatval ($kwota);
        $nadawca = $request->get('nadawca');
        $konto_nad = Account::where('numer', '=', $nadawca)->get()->first();
        $id_nad = ClientAccount::where('id_konta','=',$konto_nad->id)->get()->first();
        $dane_nad = Client::where('id','=',$id_nad->id_klienta)->get()->first();
        $transfer = new Transfer();
        $transfer->nadawca = $nadawca;
        $transfer->nazwa_nad = $dane_nad->imie_nazwisko;
        $transfer->adres_nad = $dane_nad->adres;
        $transfer->miejscowosc_nad = $dane_nad->miejscowosc;
        $transfer->kod_pocztowy_nad = $dane_nad->kod_pocztowy;
        $transfer->odbiorca =$request->get('odbiorca');
        $transfer->tytul = $request->get('tytul');
        $transfer->kwota = $kwota;
        $transfer->nazwa_odb = $request->get('imie_nazwisko');
        $transfer->adres_odb = $request->get('adres');
        $transfer->miejscowosc_odb = $request->get('miejscowosc');
        $transfer->kod_pocztowy_odb = $request->get('kod');
        $transfer->typ = 2;
        $transfer->jawny = 1;
        $transfer->created_at = Carbon::now()->toDateTimeString();
        if ($konto_nad->saldo < $kwota) {
            $transfer->status = 5;
            $transfer->save();
            return 0;
        }
        $transfer->status = 2;
        app('App\Http\Controllers\AccountController')->changeBalance($nadawca, $kwota*(-1));
        app('App\Http\Controllers\AccountController')->changeStandardBillingAccountBalance($kwota);
        $transfer->save();
        return 1;
    }



    public function expressTransfer(Request $request)
    {
        $kwota = $request->get('kwota');
        $nadawca = $request->get('nadawca');
        $saldo = Account::where('numer_konta', '=', $nadawca)->get();

        if ($saldo < $kwota) {
            return 0;
        }
        $transferToBilling = new Transfer();
        $transferToBilling->nadawca = $nadawca;
        $transferToBilling->odbiorca = '7013242100000000000001';


        $odbiorca = $request->get('odbiorca');
        $transfer = new Transfer();
        $transfer->nadawca = $nadawca;
        $transfer->odbiorca = $odbiorca;
        $transfer->tytul = $request->get('tytul');
        $transfer->kwota = $kwota;
        $transfer->nazwa = $request->get('imie_nazwisko');
        $transfer->adres = $request->get('adres');
        $transfer->miejscowosc = $request->get('miejscowosc');
        $transfer->kod_pocztowy = $request->get('kod');
        $transfer->typ = 2;
        $transfer->created_at = Carbon::now()->toDateTimeString();
        $transfer->status = 2;
        $transfer->save();
        //dodać odnośnik do API drugiego banku
        /*
         Request $req
         if($req) {
            $transfer->status = 3;
            $transfer->update();
            return 1;
        }
        else {
        $transfer->status = 4;
        return 0;
        }
         */
        return 1;
    }

    public function getAllManualVerifications() {
        $transfers = Transfer::where('status','=',1);
        return $transfers->toJson();
    }

    public function getAllAwaitingTransfer() {
        $transfers = Transfer::where('status','=',2);
        return $transfers->toJson();
    }
}
