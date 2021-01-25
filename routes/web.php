<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});


Route::post('/', function () {
    return view('index');
});

Route::get('/strona_glowna.php', function() {
   return view('strona_glowna');
});

Route::post('/strona_glowna.php', function() {
    return view('strona_glowna');
});

Route::get('/przelew.php', function() {
    return view('przelew');
});
Route::get('/historia.php', function() {
    return view('historia');
});
Route::get('/po_przelewie.php', function() {
    return view('po_przelewie');
});
Route::get('/pracownik.php', function() {
    return view('pracownik');
});


