<?php

namespace App\Http\Controllers;
session_start();
use Illuminate\Http\Request;
use App\Client;

class ClientController extends Controller
{
    public function getAllClients() {
        $clients = Client::all();
        return $clients;
    }
    public function getOneClient($id) {
        $client = Client::where('id','=',$id)->get();
        return $client;
    }

    public function loginUser(Request $request){
        $login = $request->get('login');
        $password = $request->get('password');
        $client = Client::where('login','=',$login)->get()->first();

       if($client != null) {
            if($login = $client['login'] && strcmp($password,$client['haslo'])==0) {
                $result = ['ID' => $client['id'],'name' => $client['imie_nazwisko'], 'jestPracownikiem' => $client['jestPracownikiem']];
                $json = json_encode($result);

                return  $json;

            }
        }
       return  (json_encode(['ID' => -1]));
    }
}
