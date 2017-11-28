<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

    //Naudojama lokaliam testavimui
    Route::get('lel', [
        'uses' => 'AndroidController@postLogin'
    ]);

    Route::post('login', [
        'uses' => 'AndroidController@postPrisijungimas'
    ]);

    Route::post('register', [
        'uses' => 'AndroidController@postRegistracija'
    ]);

    Route::post('logoff', [
        'uses' => 'AndroidController@postAtsijungimas'
    ]);

    Route::post('skelbimai', [
        'uses' => 'AndroidController@getSkelbimai'
    ]);

    Route::post('skelbimas', [
        'uses' => 'AndroidController@postSkelbimas'
    ]);

    Route::post('paieska', [
        'uses' => 'AndroidController@paieska'
    ]);

    Route::post('getLaikai', [
        'uses' => 'AndroidController@grazintiLaikus'
    ]);

    Route::post('postRezLaikas', [
        'uses' => 'AndroidController@rezervuotiLaika'
    ]);

    Route::post('postPop', [
        'uses' => 'AndroidController@getPop'
    ]);

    Route::post('postNauj', [
        'uses' => 'AndroidController@getNauj'
    ]);

    Route::post('getManSkelb', [
        'uses' => 'AndroidController@getManSkelb'
    ]);

    Route::post('getManNuomot', [
        'uses' => 'AndroidController@getManNuomot'
    ]);

    Route::post('getManNuomin', [
        'uses' => 'AndroidController@getManNuomin'
    ]);

    Route::post('getRezervSkelb', [
        'uses' => 'AndroidController@getRezervSkelb'
    ]);

    Route::post('patvirtintiLaika', [
        'uses' => 'AndroidController@patvirtintiLaika'
    ]);
    Route::post('atmestiLaika', [
        'uses' => 'AndroidController@atmestiLaika'
    ]);
    Route::post('atsauktiLaika', [
        'uses' => 'AndroidController@atsauktiLaika'
    ]);

    Route::post('perzVart', [
        'uses' => 'AndroidController@perzVart'
    ]);

    Route::post('pasalintiLaika', [
        'uses' => 'AndroidController@pasalintiLaika'
    ]);

    Route::post('istrintSkelb', [
        'uses' => 'AndroidController@istrintSkelb'
    ]);

    Route::post('redaguotSkelb', [
        'uses' => 'AndroidController@redaguotSkelb'
    ]);

    Route::post('isnuomoti', [
        'uses' => 'AndroidController@isnuomoti'
    ]);

    Route::post('saveSkaitlRodm', [
        'uses' => 'AndroidController@saveSkaitlRodm'
    ]);

    Route::post('getNuotPries', [
        'uses' => 'AndroidController@getNuotPries'
    ]);

    Route::post('postIkeltNuot', [
        'uses' => 'AndroidController@postIkeltNuot'
    ]);

    Route::post('grazintSkaitlDuom', [
        'uses' => 'AndroidController@grazintSkaitlDuom'
    ]);

    Route::post('postNuotStat', [
        'uses' => 'AndroidController@postNuotStat'
    ]);

    Route::post('getDok', [
        'uses' => 'AndroidController@getDok'
    ]);

    Route::post('postIkeltDok', [
        'uses' => 'AndroidController@postIkeltDok'
    ]);

    Route::post('postDeleteDok', [
        'uses' => 'AndroidController@postDeleteDok'
    ]);

    Route::post('postStatDok', [
        'uses' => 'AndroidController@postStatDok'
    ]);

    Route::post('getSas', [
        'uses' => 'AndroidController@getSas'
    ]);

    Route::post('postDeleteSas', [
        'uses' => 'AndroidController@postDeleteSas'
    ]);

    Route::post('postStatSas', [
        'uses' => 'AndroidController@postStatSas'
    ]);

    Route::post('postIkeltSas', [
        'uses' => 'AndroidController@postIkeltSas'
    ]);

    Route::post('postApsilank', [
        'uses' => 'AndroidController@postApsilank'
    ]);

    Route::post('postSkelb', [
        'uses' => 'AndroidController@postSkelb'
    ]);

    Route::post('postKeistDuom', [
        'uses' => 'AndroidController@postKeistDuom'
    ]);

    Route::post('postKeistPass', [
        'uses' => 'AndroidController@postKeistPass'
    ]);

    Route::post('getGrafikas', [
        'uses' => 'AndroidController@getGrafikas'
    ]);

    Route::post('postGrafikas', [
    'uses' => 'AndroidController@postGrafikas'
    ]);

    Route::post('postNutraukt', [
        'uses' => 'AndroidController@postNutraukt'
    ]);

    Route::post('getIstorija', [
        'uses' => 'AndroidController@getIstorija'
    ]);

    Route::post('paliktAtsIvert', [
        'uses' => 'AndroidController@paliktAtsIvert'
    ]);

    Route::post('istrintIstorija', [
        'uses' => 'AndroidController@istrintIstorija'
    ]);

    Route::post('getAtsiliepimai', [
        'uses' => 'AndroidController@getAtsiliepimai'
    ]);

    Route::post('getNuotraukos', [
        'uses' => 'AndroidController@getNuotraukos'
    ]);
