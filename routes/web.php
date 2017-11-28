<?php

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

use Illuminate\Support\Facades\Request;

Route::get('/', [
    'uses' => 'MainController@getHome',
    'as' => 'layouts.home',
]);
Route::get('apie', function () {
    return view('other.about');
})->name('other.about');

Route::get('duk', function () {
    return view('other.duk');
})->name('other.duk');

Route::get('susisiekti', function () {
    return view('other.contact');
})->name('other.contact');

/*Route::get('paieska', function () {
    return view('layouts.paieska');
})->name('layouts.paieska');*/


Route::group(['middleware' => 'auth'], function (){

    Route::group(['prefix' => 'nuomininkas'], function (){

        Route::get('', [
            'uses' => 'MainController@getNuomininkasIndex',
            'as' => 'layouts.nuomininkas',
        ]);

        Route::post('', [
            'uses' => 'MainController@postNuomininkas',
            'as' => 'layouts.search',
        ]);

    });
    Route::get('paskyra/{id}', [
        'uses' => 'MainController@getPaskyra',
        'as' => 'layouts.paskyra',
    ]);
    Route::get('paieska', [
        'uses' => 'MainController@getPaieska',
        'as' => 'layouts.paieska',
    ]);
    Route::post('paieska', [
        'uses' => 'MainController@paieska',
        'as' => 'layouts.paieska',
    ]);
    Route::get('idejimas', [
        'uses' => 'MainController@getIdejimas',
        'as' => 'layouts.skelbimoIdejimas',
    ]);
    Route::get('duomenuKeitimas', [
        'uses' => 'MainController@getDuomenuKeitimas',
        'as' => 'layouts.duomenuKeitimas',
    ]);
    Route::get('slaptazodzioKeitimas', [
        'uses' => 'MainController@getSlaptKeitimas',
        'as' => 'layouts.slaptKeitimas',
    ]);
    Route::get('objPerziura', [
        'uses' => 'MainController@getManNuomot',
        'as' => 'layouts.objPerziura',
    ]);
    Route::get('nuomos_Istorija', [
        'uses' => 'MainController@getIstorija',
        'as' => 'layouts.nuomosIstorija',
    ]);
    Route::get('grafikas/{id}', [
        'uses' => 'MainController@getGrafikoKeitimas',
        'as' => 'layouts.grafikoKeitimas',
    ]);
    Route::post('grafikas/{id}', [
        'uses' => 'MainController@postGrafikas',
    ]);
    Route::post('grafikasAll/{id}', [
        'uses' => 'MainController@duplicateWeekForAll',
    ]);
    Route::get('objektas/{id}', [
        'uses' => 'MainController@getObjektas',
        'as' => 'layouts.objektas',
    ]);
    Route::post('objektasNutraukti', [
        'uses' => 'MainController@postNutrauktiNuoma',
        'as' => 'layouts.nutrauktiNuoma',
    ]);

    Route::get('dokIkelimas/{id}', [
        'uses' => 'MainController@getDokIkelimas',
        'as' => 'layouts.dokIkelimas',
    ]);
    Route::post('dokIkelimas', [
        'uses' => 'MainController@postDokIkelimas',
        'as' => 'layouts.dokIkelimasPost',
    ]);
    Route::post('dokTrinimas', [
        'uses' => 'MainController@postDeleteDok',
        'as' => 'layouts.dokTrinimas',
    ]);
    Route::post('dokumentoStatusas', [
        'uses' => 'MainController@postStatDok',
        'as' => 'layouts.dokumentuStatusoKeitimas',
    ]);
    Route::get('nuotraukosIkelimas/{id}', [
        'uses' => 'MainController@getNuotraukuIkelimas',
        'as' => 'layouts.nuotraukuIkelimas',
    ]);
    Route::post('nuotraukosIkelimas', [
        'uses' => 'MainController@postIkeltNuot',
        'as' => 'layouts.nuotraukuIkelimasPost',
    ]);
    Route::post('nuotraukosStatusas', [
        'uses' => 'MainController@postStatNuotrauka',
        'as' => 'layouts.nuotraukuStatusoKeitimas',
    ]);
    Route::post('nuotraukosTrinimas', [
        'uses' => 'MainController@postDeleteNuotrauka',
        'as' => 'layouts.nuotraukosTrinimas',
    ]);
    Route::get('pateiktiRodmenis/{id}', [
        'uses' => 'MainController@getSkaitRodmenys',
        'as' => 'layouts.skaitRodmenys',
    ]);
    Route::post('pateiktiRodmenis', [
        'uses' => 'MainController@postSkaitiklioRodmenys',
        'as' => 'layouts.skaitRodmenysPost',
    ]);
    Route::get('rasytiAtsiliepimaApieVart/{id}', [
        'uses' => 'MainController@getPaliktiAtsiliepimaVart',
        'as' => 'layouts.rasytiAtsiliepimaApieVart',
    ]);
    Route::get('rasytiAtsiliepimaApieObjekta/{id}', [
        'uses' => 'MainController@getPaliktiAtsiliepimaObj',
        'as' => 'layouts.rasytiAtsiliepimaApieObjekta',
    ]);
    Route::get('atsiliepimaiApieNuomotoja/{id}', [
        'uses' => 'MainController@getAtsiliepimaiApieNuomotoja',
        'as' => 'layouts.atsiliepimaiApieNuomotoja',
    ]);
    Route::get('atsiliepimaiApieNuomininka/{id}', [
        'uses' => 'MainController@getatsiliepimaiApieNuomininka',
        'as' => 'layouts.atsiliepimaiApieNuomininka',
    ]);
    Route::get('atsiliepimaiApieObjekta/{id}', [
        'uses' => 'MainController@getAtsiliepimaiApieObjekta',
        'as' => 'layouts.atsiliepimaiApieObjekta',
    ]);
    Route::post('rasytiAtsiliepimaVart', [
        'uses' => 'MainController@postRasytiAtsiliepima',
        'as' => 'layouts.rasytiAtsiliepimaApieVartPost'
    ]);
    Route::post('rasytiAtsiliepimaObj', [
        'uses' => 'MainController@postRasytiAtsiliepima',
        'as' => 'layouts.rasytiAtsiliepimaApieObjektaPost'
    ]);
    Route::get('atvykPranesimas/{id}', [
        'uses' => 'MainController@getAtvykPranesimas',
        'as' => 'layouts.atvykPranesimas',
    ]);
    Route::post('atvykPranesimas', [
        'uses' => 'MainController@postApsilank',
        'as' => 'layouts.atvykPranesimasPost',
    ]);
    Route::get('sask/{id}', [
        'uses' => 'MainController@getSas',
        'as' => 'layouts.sask',
    ]);
    Route::post('sask', [
        'uses' => 'MainController@postIkeltSas',
        'as' => 'layouts.postSask',
    ]);
    Route::post('saskTrinimas', [
        'uses' => 'MainController@postDeleteSas',
        'as' => 'layouts.postDeleteSas',
    ]);
    Route::post('saskStatusas', [
        'uses' => 'MainController@postStatSas',
        'as' => 'layouts.postSasStatusas',
    ]);
    Route::get('skelbimoIdejimas', [
        'uses' => 'MainController@getIdejimas',
        'as' => 'layouts.skelbimoIdejimas'
    ]);
    Route::post('skelbimoIdejimas', [
        'uses' => 'MainController@postSkelbimas',
        'as' => 'layouts.skelbimoIdejimas'
    ]);
    Route::post('nuotraukosIkelimasSkelbimas', [
        'uses' => 'MainController@postIkeltPaprastaNuot',
        'as' => 'layouts.skelbimoNuotIkelimas'
    ]);

    Route::post('skelbimoTrinimas/{id}', [
        'uses' => 'MainController@postIstrintiSkelbima',
        'as' => 'layouts.postIstrintiSkelbima'
    ]);

    Route::get('skelbimoPerziura/{id}', [
        'uses' => 'MainController@getSkelbimoPerziura',
        'as' => 'layouts.skelbimoPerziura',
    ]);
    Route::get('manoSkelbimai', [
        'uses' => 'MainController@getManoSkelbimai',
        'as' => 'layouts.manoSkelbimai',
    ]);
    Route::get('manoRezervacijos/{id}', [
        'uses' => 'MainController@getManoRezervacijos',
        'as' => 'layouts.manoRezervacijos',
    ]);
    Route::post('atsauktiRezervacija', [
        'uses' => 'MainController@postAtsauktiRezervacija',
        'as' => 'layouts.atsauktiRezervacija',
    ]);

    Route::get('rezervuoti/{id}', [
        'uses' => 'MainController@getGrafikas',
        'as' => 'layouts.rezervuoti',
    ]);
    Route::post('rezervuoti/{id}', [
        'uses' => 'MainController@rezervuotiLaika',
        'as' => 'layouts.rezervuoti',
    ]);
    Route::get('rezervacijos/{id}', [
        'uses' => 'MainController@getPerziuretiRezervacijas',
        'as' => 'layouts.rezervacijos',
    ]);
    Route::post('patvirtinti/{id}', [
        'uses' => 'MainController@postPatvirtintiLaika',
        'as' => 'layouts.rezervacijosPost'
    ]);
    Route::post('atmesti/{id}', [
        'uses' => 'MainController@postAtmestiLaika',
        'as' => 'layouts.rezervacijosAtmestiPost'
    ]);
    Route::get('apziuros/{id}', [
        'uses' => 'MainController@getPerziuretiApziuras',
        'as' => 'layouts.apziuros',
    ]);
    Route::post('isnuomoti/{id}', [
        'uses' => 'MainController@postIsnuomoti',
        'as' => 'layouts.apziurosPost',
    ]);

    Route::get('info', [
        'uses' => 'MainController@getInfo',
    ]);



    /*Route::group(['prefix' => 'nuomotojas'], function (){


        Route::get('', [
            'uses' => 'MainController@getNuomotojasIndex',
            'as' => 'layouts.nuomotojas',
        ]);

        Route::get('skelbimas', [
            'uses' => 'MainController@getSkelbimas',
            'as' => 'layouts.skelbimas',
        ]);

        Route::post('skelbimas', [
            'uses' => 'MainController@postSkelbimas',
            'as' => 'layouts.skelbimas',
        ]);

        Route::get('skelbimasRed/{id}', [
            'uses' => 'MainController@getSkelbimasRed',
            'as' => 'layouts.skelbimasRed',
        ]);

        Route::post('skelbimasRed', [
            'uses' => 'MainController@postSkelbimasRed',
            'as' => 'layouts.skelbimasUp',
        ]);

        Route::get('istrinti/{id}', [
            'uses' => 'MainController@getSkelbimasDel',
            'as' => 'layouts.delete'
        ]);

        Route::get('skelbimai', [
            'uses' => 'MainController@getSkelbimai',
            'as' => 'layouts.skelbimai',
        ]);

    });*/
});

Auth::routes();

Route::post('login', [
    'uses' => 'SigninController@signin',
    'as' => 'auth.signin'
]);
