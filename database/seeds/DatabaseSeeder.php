<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\User();
        $user->name = 'android';
        $user->email = 'android@android.com';
        $user->password = bcrypt('android');
        $user->api_token = '';
        $user->ivertinimas = 0;
        $user->telefonas = 867289894;
        $user->save();

        $user = new \App\User();
        $user->name = 'Nuomininkas';
        $user->email = 'nuomininkas@nuomininkas.com';
        $user->password = bcrypt('slaptazodis');
        $user->api_token = '';
        $user->ivertinimas = 0;
        $user->telefonas = 867289891;
        $user->save();

        $user = new \App\User();
        $user->name = 'Nuomotojoas';
        $user->email = 'Nuomotojas@Nuomotojas.com';
        $user->password = bcrypt('slaptazodis');
        $user->api_token = '';
        $user->ivertinimas = 0;
        $user->telefonas = 867289891;
        $user->save();

        $user = new \App\User();
        $user->name = 'Emilis Jakubauskas';
        $user->email = 'test@test.com';
        $user->password = bcrypt('qwerty');
        $user->api_token = '';
        $user->ivertinimas = 0;
        $user->telefonas = 867289891;
        $user->save();

        //-----------------------Skelbimu seedas--------------------------------------

        //---------Butas--------------------------------------------
        $post = new \App\Post();
        $post->patalpuTipas = 'Butas';
        $post->savivaldybe = 'Kaunas';
        $post->gyvenviete = 'Kauno m.';
        $post->mikroRaj = 'Dainava';
        $post->gatve = 'Taikos pr.';
        $post->plotas = 100;
        $post->komentaras = 'Sveiki as petras ir man patinka dalykai';
        $post->kaina = 156;
        $post->statusas = 'skelbimas';
        $post->nuomin_id = 0;
        $post->apsilankymas = '';
        $post->post_history_id = 0;
        $post->ivertinimas = 0;
        $user->posts()->save($post);


        $butas = new \App\But();
        $butas->namoNr = 13;
        $butas->butoNr = 2;
        $butas->aukstas = 7;
        $butas->kambSk = 3;
        $butas->pastatoTip = 'Blokinis';
        $butas->irengimoTip = 'Neįrengtas';
        $butas->sildymoTip = 'Elektra';
        $butas->aukstuSk = 11;
        $butas->metai = 1994;
        $post->but()->save($butas);

        //----------------Namas--------------------------------------

        $post = new \App\Post();
        $post->patalpuTipas = 'Namas';
        $post->savivaldybe = 'Vilnius';
        $post->gyvenviete = 'Vilniaus m.';
        $post->mikroRaj = 'Antakalnis';
        $post->gatve = 'Atžalyno g.';
        $post->plotas = 256;
        $post->komentaras = 'Sveiki as antanas and welcome to my crib';
        $post->kaina = 99;
        $post->statusas = 'skelbimas';
        $post->ivertinimas = 0;
        $post->nuomin_id = 0;
        $post->apsilankymas = '';
        $post->post_history_id = 0;
        $user->posts()->save($post);

        $namas = new \App\Nam();
        $namas->namoNr = 56;
        $namas->pastatoTip = 'Medinis';
        $namas->irengimoTip = 'Dalinė Apdaila';
        $namas->sildymoTip = 'Geoterminis';
        $namas->metai = 2005;
        $namas->namoTip = 'Gyvenamasis';
        $post->nam()->save($namas);

        //-----------------------------Dar vienas Namas-------------------------------
        $post = new \App\Post();
        $post->patalpuTipas = 'Namas';
        $post->savivaldybe = 'Kaunas';
        $post->gyvenviete = 'Kauno m.';
        $post->mikroRaj = 'Dainava';
        $post->gatve = 'Taikos pr.';
        $post->plotas = 256;
        $post->komentaras = 'Sveiki as ONA ir stai mano hata';
        $post->kaina = 99;
        $post->statusas = 'skelbimas';
        $post->ivertinimas = 0;
        $post->nuomin_id = 0;
        $post->apsilankymas = '';
        $post->post_history_id = 0;
        $user->posts()->save($post);

        $namas = new \App\Nam();
        $namas->namoNr = 56;
        $namas->pastatoTip = 'Medinis';
        $namas->irengimoTip = 'Dalinė Apdaila';
        $namas->sildymoTip = 'Geoterminis';
        $namas->metai = 2010;
        $namas->namoTip = 'Gyvenamasis';
        $post->nam()->save($namas);


        //------------------------Skelbimu seedas END---------------------------------

        //--------------------Grafiku seedas Start---------------------------------------
        //Pagalb lentele.

        $graph = new \App\Graph();
        $graph->diena = 1;
        $graph->laikas = '15:00-16:00';
        $graph->savaitesNr = 25;
        $graph->statusas = 'laisva';
        $graph->user_id = 3;
        $graph->nuomin_id = 0;
        $graph->post_id = 0;
        $graph->komentaras = '';
        $graph->save();

        $graph = new \App\Graph();
        $graph->diena = 1;
        $graph->laikas = '17:00-18:00';
        $graph->savaitesNr = 25;
        $graph->statusas = 'laisva';
        $graph->user_id = 3;
        $graph->nuomin_id = 0;
        $graph->post_id = 0;
        $graph->komentaras = '';
        $graph->save();

        $graph = new \App\Graph();
        $graph->diena = 2;
        $graph->laikas = '17:00-18:00';
        $graph->savaitesNr = 25;
        $graph->statusas = 'laisva';
        $graph->user_id = 3;
        $graph->nuomin_id = 0;
        $graph->post_id = 0;
        $graph->komentaras = '';
        $graph->save();

        $graph = new \App\Graph();
        $graph->diena = 3;
        $graph->laikas = '17:00-18:00';
        $graph->savaitesNr = 25;
        $graph->statusas = 'laisva';
        $graph->user_id = 3;
        $graph->nuomin_id = 0;
        $graph->post_id = 0;
        $graph->komentaras = '';
        $graph->save();

        $graph = new \App\Graph();
        $graph->diena = 4;
        $graph->laikas = '17:00-18:00';
        $graph->savaitesNr = 25;
        $graph->statusas = 'laisva';
        $graph->user_id = 3;
        $graph->nuomin_id = 0;
        $graph->post_id = 0;
        $graph->komentaras = '';
        $graph->save();

        $graph = new \App\Graph();
        $graph->diena = 5;
        $graph->laikas = '17:00-18:00';
        $graph->savaitesNr = 25;
        $graph->statusas = 'laisva';
        $graph->user_id = 3;
        $graph->nuomin_id = 0;
        $graph->post_id = 0;
        $graph->komentaras = '';
        $graph->save();

        $graph = new \App\Graph();
        $graph->diena = 6;
        $graph->laikas = '17:00-18:00';
        $graph->savaitesNr = 25;
        $graph->statusas = 'laisva';
        $graph->user_id = 3;
        $graph->nuomin_id = 0;
        $graph->post_id = 0;
        $graph->komentaras = '';
        $graph->save();

        $graph = new \App\Graph();
        $graph->diena = 7;
        $graph->laikas = '17:00-18:00';
        $graph->savaitesNr = 25;
        $graph->statusas = 'laisva';
        $graph->user_id = 3;
        $graph->nuomin_id = 0;
        $graph->post_id = 0;
        $graph->komentaras = '';
        $graph->save();

        $graph = new \App\Graph();
        $graph->diena = 3;
        $graph->laikas = '17:00-18:00';
        $graph->savaitesNr = 26;
        $graph->statusas = 'laisva';
        $graph->user_id = 3;
        $graph->nuomin_id = 0;
        $graph->post_id = 0;
        $graph->komentaras = '';
        $graph->save();

        //----------------------Grafiku seedas END---------------------------------------


    }
}
