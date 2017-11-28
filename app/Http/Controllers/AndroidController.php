<?php

namespace App\Http\Controllers;

use App\Photo;
use App\Review;
use App\Saskaita;
use App\User;
use App\Post;
use App\File;
use App\But;
use App\Nam;
use App\Graph;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

ini_set('max_execution_time', 300);

class AndroidController extends Controller
{


    //---------------DIS IS FOR LOCAL TESTING--------------------------------------------------------
    public function postLogin()
    {
        $photoz = new Photo();
        $photoz->path = 'lel';
            $photoz->statusas = 'pagrindine';
            $photoz->post_id = 2;
            $photoz->save();
        return "success";
    }
    //---------------DIS IS FOR LOCAL TESTING END--------------------------------------------------------

    public function postRegistracija(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();



        //Chekinama ar useris su tokiu vardu egzistuoja
        if($user != null)
        {
            return "exists";
        }
        //----------------------------------------------------


        $user = new User([
            'email' => (string)$request->input('email'),
            'name' => (string)$request->input('name'),
            'password' => bcrypt($request->input('password')),
            'api_token' => bcrypt($token = str_random(60)),
            'ivertinimas' => 0,
            'telefonas' => doubleval($request->input('numeris'))
        ]);
        $user->save(); //Issaugoja i DB iskarto, cia del to Elaquent klases or w/e

        $user = User::where('email', $request->input('email'))->first();

        return "success:".$token." ID".$user->id;
    }

    public function postPrisijungimas(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        //Chekinama ar useris su tokiu email egzistuoja
        if($user == null)
        {
            return "email"; // Return redirect error message, neteisingas email
        }

        //Chekinama ar teisingas slaptazodis
        if(Hash::check($request->input('password'), $user->password))
        {
            $user->api_token = bcrypt($token = str_random(60));
            $user->save();
            return "success:".$token." ".$user->name."ID".$user->id."TEL".$user->telefonas; //return redirect, kazkoks view or layout.
        }else
        {
            return "pass"; // return redirect error message, neteisingas pass
        }
    }

    public function postAtsijungimas(Request $request)
    {

        $user = User::where('email', $request->input('email'))->first();

        //Tikrinamas api tokenas t.y. ar tikrai bando atsijungti jau per appsa prisijunges vartotojas
        if(Hash::check($request->input('api_token'), $user->api_token)) {
            $user->api_token = "";
            $user->save();
            return "success";
        }

        return "token";
    }

    //------------------Cia prasideda pagrindinis funkcionalumas-------------------------------------------------------------
    //DIS IS SHIT, IGNORE DIS------------------------------------------------------------------------
    public function getSkelbimai(Request $request)
    {
        //Visada daromas tikrinimas ar useris is appso prisijunges
        $user = User::where('email', $request->input('email'))->first();
        if(Hash::check($request->input('api_token'), $user->api_token)) {
            //Jei is appso viskas ok

            if(Post::where('user_id', $user->id)->first() != null) {
                $posts = Post::where('user_id', $user->id);
                return $posts;
            }else
            {
                return "no";
            }
        }
    }

    public function postSkelbimas(Request $request)
    {
        if($request->file('nuotrauka') != null)
        {
            $path = $request->file('nuotrauka')->store('public');

            return "success";
        }

        return "Not so success :c";
    }
    //---------------DIS IS SHIT, IGNORE DIS END----------------------------------------------------------------------

    public function paieska(Request $request)
    {
        /*$posts = Post::where('savivaldybe', 'like', "%".$request->input('savivaldybe')."%");
        $posts = $posts->where('gyvenviete', 'like', '%'.$request->input('gyvenviete').'%')->get();
        $buts = But::where('post_id', $posts->pluck('id'))->get();
        return $buts->toJson();*/

        //$user = Auth::user(); naudot shita, vietoj zemiau esancio

        $user = User::where('email', $request->input('email'))->first();

        //$easier = Auth::user();
        //$easier = true; USE ME IN NORMAL MODE
        if(Hash::check($request->input('api_token'), $user->api_token)) {



            //Typical input
            //Atrenkamas skelbimas pagal tipinius parametrus
            $posts = Post::where('statusas', 'skelbimas');
            $posts = $posts->where('savivaldybe', 'like', "%".$request->input('savivaldybe')."%");
            $posts = $posts->where('gyvenviete', 'like', '%'.$request->input('gyvenviete').'%');
            $posts = $posts->where('mikroRaj', 'like', '%'.$request->input('mikroRaj').'%');
            $posts = $posts->where('gatve', 'like', '%'.$request->input('gatve').'%');

            //Kadangi cia turi buti integer, tikrinama ar isvis kazkas yra paduodama
            if(strlen($request->input('plotasNuo')) > 0 && strlen($request->input('plotasIki')) > 0){

                $posts = $posts->whereBetween('plotas', [(int)$request->input('plotasNuo'), (int)$request->input('plotasIki')]);
            }
            if(strlen($request->input('kainaNuo')) > 0 && strlen($request->input('kainaIki')) > 0) {

                $posts = $posts->whereBetween('kaina', [(int)$request->input('kainaNuo'), (int)$request->input('kainaIki')]);
            }



            //Atrenkama ar ieskoma namo ar buto, jei nera pasirinkto tipo switchas skipinamas

            switch ($request->input('patalpuTipas'))
            {
                case "Butas":

                    $response = $posts->where('patalpuTipas', $request->input('patalpuTipas'));

                    if($response->get()->isNotEmpty()) {
                        $buts = But::whereIn('post_id', $response->get()->pluck('id')->all());

                        //Kadangi cia turi buti integer, tikrinama ar isvis kazkas yra paduodama
                        if (strlen($request->input('aukstuSkNuo')) > 0 && strlen($request->input('aukstuSkIki')) > 0) {

                            $buts = $buts->whereBetween('aukstuSk', [(int)$request->input('aukstuSkNuo'), (int)$request->input('aukstuSkIki')]);
                        }

                        //------------Tikrinama kuris aukstas, ar pirmas, ar paskutinis, ar tarp ir etc.------------
                        if($buts->get()->isNotEmpty()) {
                            switch ($request->input('aukstas')) {
                                case "Ne Pirmas":
                                    $buts = $buts->where('aukstas', '<>', 1);
                                    break;
                                case "Ne Paskutinis":
                                    $buts = $buts->whereNotIn('aukstas', $buts->get()->pluck('aukstuSk')->all());
                                    break;
                                case "Ne pirm. Ne pask.":
                                    $buts = $buts->whereNotIn('aukstas', $buts->get()->pluck('aukstuSk')->all())->where('aukstas', '<>', 1);
                                    break;
                                case "Pirmas":
                                    $buts = $buts->where('aukstas', 1);
                                    break;
                                case "Paskutinis":
                                    $buts = $buts->whereIn('aukstas', $buts->get()->pluck('aukstuSk')->all());
                                    break;
                            }
                        }
                        //----------------------------tikrinimas baigtas-----------------------------

                        $buts = $buts->where('pastatoTip', 'like', '%' . $request->input('pastatoTip') . '%');
                        $buts = $buts->where('irengimoTip', 'like', '%' . $request->input('irengimoTip') . '%');
                        $buts = $buts->where('sildymoTip', 'like', '%' . $request->input('sildymoTip') . '%');

                        //Kadangi cia turi buti integer, tikrinama ar isvis kazkas yra paduodama
                        if (strlen($request->input('kambariuSkNuo')) > 0 && strlen($request->input('kambariuSkIki')) > 0) {

                            $buts = $buts->whereBetween('kambSk', [(int)$request->input('kambSkNuo'), (int)$request->input('kambSkIki')]);
                        }
                        if (strlen($request->input('metaiNuo')) > 0 && strlen($request->input('metaiIki')) > 0) {

                            $buts = $buts->whereBetween('metai', [(int)$request->input('metaiNuo'), (int)$request->input('metaiIki')]);
                        }
                        //json_encode(array_merge(json_decode($buts->get()->toJson(), true),json_decode($response->toJson(), true)));
                        if($buts->get()->isNotEmpty()) {
                            $response = $response->whereIn('id', $buts->get()->pluck('post_id')->all());

                            $result = [];
                            $i = 0;
                            foreach ($response->get()->toArray() as $post) {

                                $part = array_merge($post, $buts->get()->where('post_id', $post['id'])->first()->toArray());
                                //Prie arejaus prijungiam ir pagrindine nuotrauka
                                $photo = Photo::where('post_id', $part['post_id'])->where('statusas', 'pagrindine')->first();
                                if(!empty($photo)) {
                                    $part['nuot_path'] = $photo->path;
                                }else
                                {
                                    $part['nuot_path'] = 'http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/nuotraukos/nuotrauku_ner.png';
                                }
                                $result[$i] = $part;
                                $i = $i + 1;
                            }

                            $response = json_encode($result);

                        }else
                        {
                            return "none";
                        }
                    }else
                    {
                        return "none";
                    }
                    break;
                case "Namas":

                    $response = $posts->where('patalpuTipas', $request->input('patalpuTipas'));
                    if($response->get()->isNotEmpty()) {
                        $nams = Nam::whereIn('post_id', $response->get()->pluck('id')->all());

                        $nams = $nams->where('pastatoTip', 'like', '%' . $request->input('pastatoTip') . '%');
                        $nams = $nams->where('irengimoTip', 'like', '%' . $request->input('irengimoTip') . '%');
                        $nams = $nams->where('sildymoTip', 'like', '%' . $request->input('sildymoTip') . '%');
                        $nams = $nams->where('namoTip', 'like', "%" . $request->input('namoTip') . "%");

                        //Kadangi cia turi buti integer, tikrinama ar isvis kazkas yra paduodama
                        if (strlen($request->input('metaiNuo')) > 0 && strlen($request->input('metaiIki')) > 0) {

                            $nams = $nams->whereBetween('metai', [(int)$request->input('metaiNuo'), (int)$request->input('metaiIki')]);
                        }

                        if($nams->get()->isNotEmpty()) {
                            $response = $response->whereIn('id', $nams->get()->pluck('post_id')->all());

                            $result = [];
                            $i = 0;
                            foreach ($response->get()->toArray() as $post) {

                                $part = array_merge($post, $nams->get()->where('post_id', $post['id'])->first()->toArray());
                                //Prie arejaus prijungiam ir pagrindine nuotrauka
                                $photo = Photo::where('post_id', $part['post_id'])->where('statusas', 'pagrindine')->first();
                                if(!empty($photo)) {
                                    $part['nuot_path'] = $photo->path;
                                }else
                                {
                                    $part['nuot_path'] = 'http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/nuotraukos/nuotrauku_ner.png';
                                }
                                $result[$i] = $part;
                                $i = $i + 1;
                            }

                            $response = json_encode($result);

                        }else
                        {
                            return "none";
                        }
                    }else
                    {
                        return "none";
                    }
                    break;

                default:
                    $response = "none";
                    break;
            }
            return $response;

        }else
        {
            return "none";
        }
    }

    public function grazintiLaikus(Request $request)
    {
        //REIKIA IDET QUERY KAD NEGRAZINTU, PREJUSIU LAIKU!!

        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            $post = Post::find(intval($request->input('post_id')));

            if($post->user_id == $user->id)
            {
                return "nuomot";
            }

            if(Graph::where('post_id', $post->id)->where('nuomin_id', $user->id)->get()->isNotEmpty())
                return 'exists';

            $graphs = Graph::where('user_id', $request->input('user_id'))->where('statusas', 'laisva');

            //Surusiuojam pagal savaites, dienas ir laika
            $graphs = $graphs->orderBy('savaitesNr')->orderBy('diena')->orderBy('laikas');
            $graphs = $graphs->get();

            if ($graphs->isEmpty())
            {
                return "none";
            }

            return $graphs->toJson();
        }

        return "no";
    }

    public function rezervuotiLaika(Request $request)
    {

        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            $graph = Graph::find(intval($request->input('id')));

            $graph->post_id = $request->input('post_id');
            $graph->nuomin_id = $user->id;
            $graph->statusas = 'rezervuojama';

            $graph->save();

            return "success";
        }

        return "no";
    }

    public function getPop(Request $request)
    {
        //Visada daromas tikrinimas ar useris is appso prisijunges
        $user = User::where('email', $request->input('email'))->first();
        if(Hash::check($request->input('api_token'), $user->api_token)) {
            //Jei is appso viskas ok


            $response = Post::orderBy('ivertinimas', 'desc')->where('statusas', 'skelbimas');

            $result = [];
            $part = [];
            $i = 0;
            foreach ($response->get()->toArray() as $post) {

                switch ($post['patalpuTipas']) {
                    case "Namas":
                        $part = array_merge($post, Nam::all()->where('post_id', $post['id'])->first()->toArray());
                        break;
                    case "Butas":
                        $part = array_merge($post, But::all()->where('post_id', $post['id'])->first()->toArray());
                        break;
                }
                //Prie arejaus prijungiam ir pagrindine nuotrauka
                $photo = Photo::where('post_id', $part['post_id'])->where('statusas', 'pagrindine')->first();
                if(!empty($photo)) {
                    $part['nuot_path'] = $photo->path;
                }else
                {
                    $part['nuot_path'] = 'http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/nuotraukos/nuotrauku_ner.png';
                }
                $result[$i] = $part;
                $i = $i + 1;
            }

            $response = json_encode($result);

            return $response;
        }

        return "no";
    }

    public function getNauj(Request $request)
    {
        //Visada daromas tikrinimas ar useris is appso prisijunges
        $user = User::where('email', $request->input('email'))->first();
        if(Hash::check($request->input('api_token'), $user->api_token)) {
            //Jei is appso viskas ok

            $response = Post::orderBy('created_at', 'desc')->where('statusas', 'skelbimas');

            $result = [];
            $i = 0;
            foreach ($response->get()->toArray() as $post) {

                switch ($post['patalpuTipas']) {
                    case "Namas":
                        $part = array_merge($post, Nam::all()->where('post_id', $post['id'])->first()->toArray());
                        break;
                    case "Butas":
                        $part = array_merge($post, But::all()->where('post_id', $post['id'])->first()->toArray());
                        break;
                }

                //Prie arejaus prijungiam ir pagrindine nuotrauka
                $photo = Photo::where('post_id', $part['post_id'])->where('statusas', 'pagrindine')->first();
                if(!empty($photo)) {
                    $part['nuot_path'] = $photo->path;
                }else
                {
                    $part['nuot_path'] = 'http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/nuotraukos/nuotrauku_ner.png';
                }
                $result[$i] = $part;
                $i = $i + 1;
            }

            $response = json_encode($result);

            return $response;
        }

        return "no";
    }

    //Grazinami vartotojo ideti skelbimai kurie nera isnuomoti
    public function getManSkelb(Request $request)
    {
        //Visada daromas tikrinimas ar useris is appso prisijunges
        $user = User::where('email', $request->input('email'))->first();
        if(Hash::check($request->input('api_token'), $user->api_token)) {
            //Jei is appso viskas ok

            $response = Post::where('user_id', $user->id)->where('statusas', 'skelbimas');

            $result = [];
            $part = [];
            $i = 0;
            foreach ($response->get()->toArray() as $post) {

                switch ($post['patalpuTipas']) {
                    case "Namas":
                        $part = array_merge($post, Nam::all()->where('post_id', $post['id'])->first()->toArray());
                        break;
                    case "Butas":
                        $part = array_merge($post, But::all()->where('post_id', $post['id'])->first()->toArray());
                        break;
                }

                //Prie arejaus prijungiam ir pagrindine nuotrauka
                $photo = Photo::where('post_id', $part['post_id'])->where('statusas', 'pagrindine')->first();
                if(!empty($photo)) {
                    $part['nuot_path'] = $photo->path;
                }else
                {
                    $part['nuot_path'] = 'http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/nuotraukos/nuotrauku_ner.png';
                }
                $result[$i] = $part;
                $i = $i + 1;
            }

            if(empty($result))
                return "none";

            $response = json_encode($result);

            return $response;
        }

        return "no";
    }

    //Grazinamos vartotojo isnuomotos patalpos
    public function getManNuomot(Request $request)
    {
        //Visada daromas tikrinimas ar useris is appso prisijunges
        $user = User::where('email', $request->input('email'))->first();
        if(Hash::check($request->input('api_token'), $user->api_token)) {
            //Jei is appso viskas ok

            $response = Post::where('user_id', $user->id)->where('statusas', 'patalpos');

            $result = [];
            $i = 0;
            foreach ($response->get()->toArray() as $post) {

                switch ($post['patalpuTipas']) {
                    case "Namas":
                        $part = array_merge($post, Nam::all()->where('post_id', $post['id'])->first()->toArray());
                        break;
                    case "Butas":
                        $part = array_merge($post, But::all()->where('post_id', $post['id'])->first()->toArray());
                        break;
                }

                //Prie arejaus prijungiam ir pagrindine nuotrauka
                $photo = Photo::where('post_id', $part['post_id'])->where('statusas', 'pagrindine')->first();
                if(!empty($photo)) {
                    $part['nuot_path'] = $photo->path;
                }else
                {
                    $part['nuot_path'] = 'http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/nuotraukos/nuotrauku_ner.png';
                }
                $result[$i] = $part;
                $i = $i + 1;
            }

            if(empty($result))
                return "none";

            $response = json_encode($result);

            return $response;
        }

        return "no";
    }

    //grazinamos vartotojo issinuomotos patalpos
    public function getManNuomin(Request $request)
    {
        //Visada daromas tikrinimas ar useris is appso prisijunges
        $user = User::where('email', $request->input('email'))->first();
        if(Hash::check($request->input('api_token'), $user->api_token)) {
            //Jei is appso viskas ok

            $response = Post::where('nuomin_id', $user->id)->where('statusas', 'patalpos');

            $result = [];
            $i = 0;
            foreach ($response->get()->toArray() as $post) {

                switch ($post['patalpuTipas']) {
                    case "Namas":
                        $part = array_merge($post, Nam::all()->where('post_id', $post['id'])->first()->toArray());
                        break;
                    case "Butas":
                        $part = array_merge($post, But::all()->where('post_id', $post['id'])->first()->toArray());
                        break;
                }

                //Prie arejaus prijungiam ir pagrindine nuotrauka
                $photo = Photo::where('post_id', $part['post_id'])->where('statusas', 'pagrindine')->first();
                if(!empty($photo)) {
                    $part['nuot_path'] = $photo->path;
                }else
                {
                    $part['nuot_path'] = 'http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/nuotraukos/nuotrauku_ner.png';
                }
                $result[$i] = $part;
                $i = $i + 1;
            }

            if(empty($result))
                return "none";

            $response = json_encode($result);

            return $response;
        }

        return "no";
    }

    //grazinamos su rezervavimu susijusios patalpos
    public function getRezervSkelb(Request $request)
    {
        //Visada daromas tikrinimas ar useris is appso prisijunges
        $user = User::where('email', $request->input('email'))->first();
        if(Hash::check($request->input('api_token'), $user->api_token)) {
            //Jei is appso viskas ok

            //Sukuriamas rezervacijos grafiku susijusiu su vartotoju queris
            $graphs = Graph::where('statusas', '<>', 'laisva')->where('nuomin_id', '<>', 0);
            $graphs = $graphs->where('user_id', $user->id)->orWhere('nuomin_id', $user->id);

            if($graphs->get()->isEmpty())
                return "none";



            //Pagal rezervacijas grazinami skelbimai vartotojui
            $response = Post::whereIn('id', $graphs->get()->pluck('post_id')->all());

            $result = [];
            $i = 0;

            $part = [];

            $response = $response->get();

            foreach ($graphs->get()->toArray() as $graph) {


                //Nuomotojo atmestos patalpos turi buti negrazinamos jam, tai ir padaro sitas ifas
                if(!($graph['user_id'] == $user->id && $graph['statusas'] == 'atmesta')) {

                    //Nuomininko atsauktos patalpos turi buti negrazinamos jam, tai ir padaro sitas ifas
                    if(!($graph['nuomin_id'] == $user->id && $graph['statusas'] == 'atsaukta')) {
                        $post = $response->where('id', $graph['post_id'])->first()->toArray();


                        switch ($post['patalpuTipas']) {
                            case "Namas":
                                $part = array_merge($post, Nam::all()->where('post_id', $post['id'])->first()->toArray());
                                $part = array_merge($part, $graph); //Prie Json pridedam ir rezervavimo laikus
                                break;
                            case "Butas":
                                $part = array_merge($post, But::all()->where('post_id', $post['id'])->first()->toArray());
                                $part = array_merge($part, $graph); //Prie Json pridedam ir rezervavimo laikus
                                break;
                        }


                        //Prie arejaus prijungiam ir pagrindine nuotrauka
                        $photo = Photo::where('post_id', $part['post_id'])->where('statusas', 'pagrindine')->first();
                        if(!empty($photo)) {
                            $part['nuot_path'] = $photo->path;
                        }else
                        {
                            $part['nuot_path'] = 'http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/nuotraukos/nuotrauku_ner.png';
                        }
                        $result[$i] = $part;
                        $i = $i + 1;
                    }
                }
            }


            if(empty($result))
                return "none";

            $response = json_encode($result);
            return $response;
        }

        return "no";
    }

    public function patvirtintiLaika(Request $request)
    {

        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            $graph = Graph::find(intval($request->input('id')));


            $graph->statusas = 'patvirtinta';

            $graph->save();

            return "success";
        }

        return "no";
    }

    //Patalpu nuomotojas atmeta rezervavimo laika
    public function atmestiLaika(Request $request)
    {

        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            //Atmestas laikas issaugojamas kaip atmestas iki kol Nuominankas patvirtins kad supranta kodel tai atmesta
            $graph = Graph::find(intval($request->input('id')));
            $diena = $graph->diena;
            $laikas = $graph->laikas;
            $savaitesNr = $graph->savaitesNr;

            $graph->statusas = 'atmesta';
            $graph->komentaras = (string)$request->input('komentaras');
            $graph->save();

            //Sukuriamas naujas toks pats laisvas laikas, kitiems vartotojams
            $graph = new Graph();
            $graph->diena = $diena;
            $graph->laikas = $laikas;
            $graph->savaitesNr = $savaitesNr;
            $graph->statusas = 'laisva';
            $graph->user_id = $user->id;
            $graph->nuomin_id = 0;
            $graph->post_id = 0;
            $graph->komentaras = '';
            $graph->save();

            return "success";
        }
        return "no";
    }

    //Patalpu potencialus nuomininkas atsaukia rezervavimo laika
    public function atsauktiLaika(Request $request)
    {

        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            //Atmestas laikas issaugojamas kaip atmestas iki kol Nuominankas patvirtins kad supranta kodel tai atmesta
            $graph = Graph::find(intval($request->input('id')));






            $diena = $graph->diena;
            $laikas = $graph->laikas;
            $savaitesNr = $graph->savaitesNr;
            $id = $graph->user_id;

            //Jei nuomininkas nori atsaukti dar nepatvirtinta susitikimo laika, tai nuomotojas apie tai nebus informuojamas
            if($graph->statusas === 'rezervuojama') {
                $graph->diena = $diena;
                $graph->laikas = $laikas;
                $graph->savaitesNr = $savaitesNr;
                $graph->statusas = 'laisva';
                $graph->user_id = $id;
                $graph->nuomin_id = 0;
                $graph->post_id = 0;
                $graph->komentaras = '';
                $graph->save();
            }else
            {//Kitu atveju nuomotojas informuojamas
                $graph->statusas = 'atsaukta';
                $graph->komentaras = (string)$request->input('komentaras');
                $graph->save();

                //Sukuriamas naujas toks pats laisvas laikas, kitiems vartotojams
                $graph = new Graph();
                $graph->diena = $diena;
                $graph->laikas = $laikas;
                $graph->savaitesNr = $savaitesNr;
                $graph->statusas = 'laisva';
                $graph->user_id = $id;
                $graph->nuomin_id = 0;
                $graph->post_id = 0;
                $graph->komentaras = '';
                $graph->save();
            }



            return "success";
        }
        return "no";
    }

    public function perzVart(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            $user = User::find(intval($request->input('user_id')));

            return $user->toJson();

        }

        return "no";
    }

    //DUNNO WHY IT HERE
    public function pasalintiLaika(Request $request)
    {

        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            $graph = Graph::find(intval($request->input('id')));

            $graph->delete();

            return "success";
        }

        return "no";
    }

    public function istrintSkelb(Request $request)
    {

        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            $post = Post::find(intval($request->input('post_id')));

            //Jeigu egzistuoja skelbimas kurio susitikimo laikas yra patvirtintas arba rezervuojamas, tai jo istrinti negalima

            $graphs = Graph::where('statusas', 'patvirtinta')->orWhere('statusas', 'rezervuojama')->get();

            if($graphs->isNotEmpty()) {
                $graphs = $graphs->where('post_id', $post->id);
                if ($graphs->isNotEmpty())
                    return "exists";
            }


            switch ($post->patalpuTipas)
            {
                case "Namas":
                    $nam = Nam::where('post_id', $post->id)->first();
                    $nam->delete();
                    break;
                case "Butas":
                    $but = But::where('post_id', $post->id)->first();
                    $but->delete();
                    break;
            }

            //Grafiku laikai su statusas atmesta irgi istrinami
            $graphs = Graph::where('post_id', $post->id)->where('statusas', 'atmesta');
            if($graphs->get()->isNotEmpty()) {
                $graphs->delete();
            }

            //Grafiku laikai su statusas atsaukta irgi istrinami
            $graphs = Graph::where('post_id', $post->id)->where('statusas', 'atsaukta');
            if($graphs->get()->isNotEmpty()) {
                $graphs->delete();
            }



            //Visi susija reviews istrinami
            $reviews = Review::where('rev_id', $post->id)->where('statusas', 'skelbimas');
            if($reviews->get()->isNotEmpty()) {
                $reviews->delete();
            }

            //Visos nuotraukos istrinamos
            $photos = Photo::where('post_id', $post->id)->get();
            foreach ($photos as $photo)
            {
                $prefix = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/";
                $delPath = str_replace($prefix, "", $photo->path);


                Storage::delete($delPath);

                $photo->delete();
            }


            $post->delete();
            return "success";
        }

        return "no";
    }

    public function redaguotSkelb(Request $request)
    {

        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            $post = Post::find(intval($request->input('post_id')));

            $post->patalpuTipas = (string)$request->input('patalpuTipas');
            $post->savivaldybe = (string)$request->input('savivaldybe');
            $post->gyvenviete = (string)$request->input('gyvenviete');
            $post->mikroRaj = (string)$request->input('mikroRaj');
            $post->gatve =(string) $request->input('gatve');
            $post->plotas = intval($request->input('plotas'));
            $post->komentaras = (string)$request->input('komentaras');
            $post->kaina = intval($request->input('kaina'));

            $post->save();



            switch ($post->patalpuTipas) {

                case "Namas":
                    $namas = Nam::where('post_id', intval($request->input('post_id')))->first();
                    $namas->namoNr = intval($request->input('namoNr'));
                    $namas->pastatoTip = (string)$request->input('pastatoTip');
                    $namas->irengimoTip = (string)$request->input('irengimoTip');
                    $namas->sildymoTip = (string)$request->input('sildymoTip');
                    $namas->metai = intval($request->input('metai'));
                    $namas->namoTip = (string)$request->input('namoTip');
                    $namas->save();

                    break;

                case "Butas":
                    $butas = But::where('post_id', intval($request->input('post_id')))->first();
                    $butas->namoNr = intval($request->input('namoNr'));
                    $butas->butoNr = intval($request->input('butoNr'));
                    $butas->aukstas = intval($request->input('aukstas'));
                    $butas->kambSk = intval($request->input('kambSk'));
                    $butas->pastatoTip = (string)$request->input('pastatoTip');
                    $butas->irengimoTip = (string)$request->input('irengimoTip');
                    $butas->sildymoTip = (string)$request->input('sildymoTip');
                    $butas->aukstuSk = intval($request->input('aukstuSk'));
                    $butas->metai = intval($request->input('metai'));
                    $butas->save();
                    break;
            }

            //Nuotrauku ikelimas
            $i = 1;
            while($request->file('pic'.$i) != null)
            {
                $path = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/".$request->file('pic'.$i)->store('nuotraukos');

                $photo = new Photo();
                $photo->path = $path;
                $photo->statusas = 'paprasta';
                $post->photos()->save($photo);

                $i = $i + 1;
            }

            //Nuotrauku istrynimas
            $i = 0;
            while($request->input('remove'.$i) != null)
            {
                $photo = Photo::where('post_id', $post->id)->where('path', $request->input('remove'.$i))->first();

                $prefix = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/";
                $delPath = str_replace($prefix, "", $photo->path);

                Storage::delete($delPath);

                $photo->delete();
                $i = $i + 1;
            }

            //statuso keitimas
            if(intval($request->input('pagrNuot')) != 0) {
                $i = 1;
                $photos = Photo::where('post_id', $post->id)->where('statusas', '<>', 'patvirtinta')->where('statusas', '<>', 'nepatvirtinta')
                    ->where('statusas', '<>', 'atmesta')->get();
                foreach ($photos as $photo) {
                    //statusas nustatomas ar pagrindine ar ne
                    if (intval($request->input('pagrNuot')) == $i) {
                        $photo->statusas = 'pagrindine';
                    } else {
                        $photo->statusas = 'paprasta';
                    }
                    $post->photos()->save($photo);
                    $i = $i + 1;
                }
            }

            return "success";
        }
        return "no";
    }

    public function isnuomoti(Request $request)
    {

        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            $post = Post::find(intval($request->input('post_id')));

            $post->statusas = 'patalpos'; //Patalpos isnuomotos todel ju statusas pakeiciamas i true

            $email = (string)$request->input('email2');

            if(strlen($email) > 0) {

                $nuomin = User::where('email', $email)->first();

                if(empty($nuomin))
                    return "none";

                if($post->user_id == $nuomin->id)
                {
                    return "nuomot";
                }

            }else
            {
                if(intval($request->input('nuomin_id')) == 0)
                    return "none";

                $nuomin = User::find(intval($request->input('nuomin_id')));
            }

            $post->nuomin_id = $nuomin->id;
            $post->save();



            //Vadovaujantis ideja kad nuomininkas ir nuomotojas susitiko sutartu metu ir issinuomavo patalpas
            //Susitikimo laikas istrinamas is duombazes
            $graph = Graph::where('nuomin_id', $nuomin->id)->where('post_id', $post->id)->where('statusas', 'patvirtinta')->first();
            if(!empty($graph)) {
                $graph->delete();
            }

             //Visi kiti nuomininkai informuojami kad patalpos jau isnuomotos
            $graphs = Graph::where('post_id', $post->id)->where('statusas', '<>', 'atmesta')->get();
            foreach ($graphs as $graph)
            {
                if($graph->statusas === 'atsaukta')
                {
                    $graph->delete();
                    continue;
                }

                //Atmestas laikas issaugojamas kaip atmestas iki kol Nuominankas patvirtins kad supranta kodel tai atmesta
                $diena = $graph->diena;
                $laikas = $graph->laikas;
                $savaitesNr = $graph->savaitesNr;
                $graph->statusas = 'atmesta';
                $graph->komentaras = 'Patalpos jau išnuomotos';
                $graph->save();

                //Sukuriamas naujas toks pats laisvas laikas, kitiems vartotojams
                $Ngraph = new Graph();
                $Ngraph->diena = $diena;
                $Ngraph->laikas = $laikas;
                $Ngraph->savaitesNr = $savaitesNr;
                $Ngraph->statusas = 'laisva';
                $Ngraph->user_id = $user->id;
                $Ngraph->nuomin_id = 0;
                $Ngraph->post_id = 0;
                $Ngraph->komentaras = '';
                $Ngraph->save();
            }

            return "success";
        }

        return "no";
    }

    //Issaugojami skaitliuku duomenys
    public function saveSkaitlRodm(Request $request)
    {

        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            $post = Post::find(intval($request->input('post_id')));

            //Tikrinama ar saskaita jau yra pildyta siom patalpom, siais metais ir siam menesiui
            if(!empty($saskaita = Saskaita::where('post_id', $post->id)->where('menesis', (string)$request->input('menesis'))
                ->where('metai', intval($request->input('metai')))->first())) {

                //Jei dar saskaita nesudaryta siem duomenim tai ja galima redaguoti
                if(strcmp($saskaita->statusas, 'duomenys') == 0) {
                    $saskaita->metai = intval($request->input('metai'));
                    $saskaita->menesis = (string)$request->input('menesis');
                    $saskaita->elektra = floatval($request->input('elektra'));
                    $saskaita->dujos = floatval($request->input('dujos'));
                    $saskaita->karstas = floatval($request->input('karstas'));
                    $saskaita->saltas = floatval($request->input('saltas'));
                    $saskaita->bendraSum = 0;
                    $saskaita->statusas = 'duomenys'; //Nes pateikti tik skaitliuku duomenys
                    $saskaita->path = '';

                    $saskaita->save();
                }else
                {//Jei sudaryta tai nebegalima
                    return "exists";
                }
            }
            else
            {
                $saskaita = new Saskaita();

                $saskaita->metai = intval($request->input('metai'));
                $saskaita->menesis = (string)$request->input('menesis');
                $saskaita->elektra = floatval($request->input('elektra'));
                $saskaita->dujos = floatval($request->input('dujos'));
                $saskaita->karstas = floatval($request->input('karstas'));
                $saskaita->saltas = floatval($request->input('saltas'));
                $saskaita->bendraSum = 0;
                $saskaita->statusas = 'duomenys'; //Nes pateikti tik skaitliuku duomenys
                $saskaita->path = '';

                $post->saskaitas()->save($saskaita);
            }


            return 'success';
        }

        return 'no';
    }

    //Grazina nuotraukas pries
    public function getNuotPries(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            $photos = Photo::where('post_id', intval($request->input('post_id')))->where('statusas', '<>', 'paprasta')->where('statusas', '<>', 'pagrindine');

            if($photos->get()->isNotEmpty())
            {
                return $photos->get()->toJson();

            }else
            {
                return "none";
            }
        }

        return "no";
    }

    //Ikeliama nuotrauka
    public function postIkeltNuot(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();


        if (Hash::check($request->input('api_token'), $user->api_token)) {

            if($request->file('nuotrauka') != null)
            {
                $post = Post::find(intval($request->input('post_id')));

                $path = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/".$request->file('nuotrauka')->store('nuotraukos');

                $photo = new Photo();
                $photo->path = $path;
                $photo->statusas = 'nepatvirtinta';

                $post->photos()->save($photo);

                return "success";
            }

            return "Not so success :c";

        }

        return "no";
    }

    //Ikeliama nuotrauka
    public function grazintSkaitlDuom(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            $saskaita = Saskaita::where('post_id', intval($request->input('post_id')))->get();

            if(!empty($saskaita))
            {
                return $saskaita->toJson();

            }else
            {
                return "none";
            }

        }

        return "no";
    }

    //Keiciamas nuotraukos statusas
    public function postNuotStat(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            $photo = Photo::find(intval($request->input('id')));

            $photo->statusas = (string)$request->input('statusas');

            $photo->save();
            return "success";
        }

        return "no";
    }

    //Grazina dokumentus
    public function getDok(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            $files = File::where('post_id', intval($request->input('post_id')));

            if($files->get()->isNotEmpty())
            {
                return $files->get()->toJson();

            }else
            {
                return "none";
            }
        }
        return "no";
    }

    //Ikeliamas dokumentas
    public function postIkeltDok(Request $request)
    {

        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            if($request->file('dokumentas') != null)
            {

                $post = Post::find(intval($request->input('post_id')));

                $path = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/".$request->file('dokumentas')->store('dokumentai');

                $file = new File();
                $file->path = $path;
                $file->name = $request->input('name');
                $file->statusas = 'nepatvirtinta';
                $file->user_id = $user->id;

                $post->files()->save($file);

                return "success";
            }

            return "Not so success :c";
        }
        return "no";
    }

    //Istrinamas dokumentas
    public function postDeleteDok(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            $file = File::find(intval($request->input('id')));

            if(!empty($file))
            {
                $prefix = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/";
                $delPath = str_replace($prefix, "", $file->path);

                Storage::delete($delPath);

                $file->delete();

                return "success";
            }

            return "Not so success :c";
        }
        return "no";
    }

    //Dokumento statusas patvirtinamas arba atmetamas
    public function postStatDok(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            $file = File::find(intval($request->input('id')));

            if(!empty($file))
            {
                if(strcmp((string)$request->input('statusas'), "patvirtinta") == 0)
                {
                    $file->statusas = "patvirtinta";
                    $file->save();
                    return "success";
                }else if(strcmp((string)$request->input('statusas'), "atmesta") == 0)
                {
                    $file->statusas = "atmesta";
                    $file->save();
                    return "success";
                }
            }

            return "Not so success :c";
        }
        return "no";
    }

    //Grazina saskaitu failus
    public function getSas(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            $saskaitos = Saskaita::where('post_id', intval($request->input('post_id')))->where('path', '<>', '');

            if($saskaitos->get()->isNotEmpty())
            {
                return $saskaitos->get()->toJson();

            }else
            {
                return "none";
            }
        }
        return "no";
    }

    //Istrinama saskaita
    public function postDeleteSas(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            $saskaita = Saskaita::find(intval($request->input('id')));

            if(!empty($saskaita))
            {
                $prefix = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/";
                $delPath = str_replace($prefix, "", $saskaita->path);

                Storage::delete($delPath);

                $saskaita->delete();

                return "success";
            }

            return "Not so success :c";
        }
        return "no";
    }

    //Saskaitos statusas pakeiciamas
    public function postStatSas(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            $saskaita = Saskaita::find(intval($request->input('id')));

            if(!empty($saskaita))
            {
                $saskaita->statusas = "apmokėta";
                $saskaita->save();
                return "success";
            }

            return "Not so success :c";
        }
        return "no";
    }

    //Ikeliamas dokumentas
    public function postIkeltSas(Request $request)
    {

        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            if($request->file('dokumentas') != null)
            {

                $post = Post::find(intval($request->input('post_id')));

                //Tikrinama ar saskaita jau yra pildyta siom patalpom, siais metais ir siam menesiui
                if(!empty($saskaita = Saskaita::where('post_id', $post->id)->where('menesis', (string)($request->input('menesis')))
                    ->where('metai', intval($request->input('metai')))->first())) {


                    if(strlen($saskaita->path) > 0)
                    {
                        return "exists";
                    }

                    $path = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/".$request->file('dokumentas')->store('saskaitos');


                    $saskaita->bendraSum = floatval($request->input('bendraSum'));
                    $saskaita->statusas = 'neapmokėta';
                    $saskaita->path = $path;

                    $saskaita->save();
                }
                else
                {
                    $path = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/".$request->file('dokumentas')->store('saskaitos');

                    $saskaita = new Saskaita();
                    $saskaita->metai = intval($request->input('metai'));
                    $saskaita->menesis = (string)($request->input('menesis'));
                    $saskaita->elektra = 0;
                    $saskaita->dujos = 0;
                    $saskaita->karstas = 0;
                    $saskaita->saltas = 0;
                    $saskaita->bendraSum = floatval($request->input('bendraSum'));
                    $saskaita->statusas = 'neapmokėta';
                    $saskaita->path = $path;

                    $post->saskaitas()->save($saskaita);

                }


                return "success";
            }

            return "Not so success :c";
        }
        return "no";
    }

    //Issaugojamas apsilankymas
    public function postApsilank(Request $request)
    {

        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            $post = Post::find(intval($request->input('post_id')));
            $post->apsilankymas = $request->input('apsilankymas');

            $post->save();

            return "success";
        }
    }

    //Sukuriamas skelbimas
    public function postSkelb(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            $post = new Post();

            $post->patalpuTipas = (string)$request->input('patalpuTipas');
            $post->savivaldybe = (string)$request->input('savivaldybe');
            $post->gyvenviete = (string)$request->input('gyvenviete');
            $post->mikroRaj = (string)$request->input('mikroRaj');
            $post->gatve =(string) $request->input('gatve');
            $post->plotas = intval($request->input('plotas'));
            $post->komentaras = (string)$request->input('komentaras');
            $post->kaina = intval($request->input('kaina'));
            $post->statusas = 'skelbimas';
            $post->ivertinimas = 0;
            $post->nuomin_id = 0;
            $post->apsilankymas = "";
            $post->post_history_id = 0;

            $user->posts()->save($post);

            switch ($post->patalpuTipas) {

                case "Namas":
                    $namas = new Nam();
                    $namas->namoNr = intval($request->input('namoNr'));
                    $namas->pastatoTip = (string)$request->input('pastatoTip');
                    $namas->irengimoTip = (string)$request->input('irengimoTip');
                    $namas->sildymoTip = (string)$request->input('sildymoTip');
                    $namas->metai = intval($request->input('metai'));
                    $namas->namoTip = (string)$request->input('namoTip');

                    $post->nam()->save($namas);

                    break;

                case "Butas":
                    $butas = new But();
                    $butas->namoNr = intval($request->input('namoNr'));
                    $butas->butoNr = intval($request->input('butoNr'));
                    $butas->aukstas = intval($request->input('aukstas'));
                    $butas->kambSk = intval($request->input('kambSk'));
                    $butas->pastatoTip = (string)$request->input('pastatoTip');
                    $butas->irengimoTip = (string)$request->input('irengimoTip');
                    $butas->sildymoTip = (string)$request->input('sildymoTip');
                    $butas->aukstuSk = intval($request->input('aukstuSk'));
                    $butas->metai = intval($request->input('metai'));

                    $post->but()->save($butas);
                    break;
            }

            //Nuotrauku ikelimas
            $i = 1;

            while($request->file('pic'.$i) != null)
            {
                $path = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/".$request->file('pic'.$i)->store('nuotraukos');

                $photo = new Photo();
                $photo->path = $path;

                //statusas nustatomas ar pagrindine ar ne
                if(intval($request->input('pagrNuot')) == $i)
                {
                    $photo->statusas = 'pagrindine';
                }else {
                    $photo->statusas = 'paprasta';
                }
                $post->photos()->save($photo);

                $i = $i + 1;
            }
            return "success";
        }
        return "no";
    }

    //Issaugojami pakeisti vartotojo duomenys
    public function postKeistDuom(Request $request)
    {

        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            $user->name = (string)$request->input('name');
            $user->telefonas = doubleval($request->input('telefonas'));

            $checkUser = User::where('email', $request->input('email2'))->first();

            if(strcasecmp($user->email, $request->input('email2')) == 0)
            {
                $user->email = $request->input('email2');
            }else if(empty($checkUser))
            {
                $user->email = $request->input('email2');
            }else
            {
                return "exists";
            }

            $user->save();

            return "success";
        }
    }

    //Issaugojamas pakeistas vartotojo slaptazodis
    public function postKeistPass(Request $request)
    {

        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            if(Hash::check($request->input('password'), $user->password))
            {
                $user->password = bcrypt($request->input('password2'));
                $user->save();
            }else
            {
                return "wrong";
            }

            return "success";
        }
    }

    //Grazinamas vartotojo grafikas
    public function getGrafikas(Request $request)
    {

        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            $graphs = Graph::where('user_id', $user->id)->where('statusas', '<>', 'atsaukta')->where('statusas', '<>', 'atmesta')->get();

            if($graphs->isEmpty())
            {
                return "none";
            }else
            {
                return $graphs->toJson();
            }

        }

    }

    //Issaugojamas grafikas. I SI METODA PADUODAMA LABAI DIDELIS JSON ARRAY!
    //Kur 0 indexe email ir api tokenas
    public function postGrafikas(Request $request)
    {


        $array = $request->all();

        $user = User::where('email', $array[0]["email"])->first();
        if (Hash::check($array[0]["api_token"], $user->api_token)) {

            $graphs = Graph::where('user_id', $user->id)->where('statusas', 'laisva');



            if($graphs->get()->isNotEmpty())
            {
                $graphs->delete();
            }

            unset($array[0]);//Istrinam email ir Api array dali

            //return [$array[1]];


            Graph::insert($array); //Bulk Save

            return ["success"];
        }

        return ["no"];
    }

    //Nuoma nutraukiama ir isnuomotos patalpos vel patampa skelbimu ir taip pat istorijos objektu
    public function postNutraukt(Request $request)
    {

        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            $postHist = Post::find(intval($request->input('post_id')));

            //Skelbimas issaugojamas kaip istorija bus skirta atsiliepimam ir vertinimam
            $postHist->statusas = 'istorija';
            $postHist->save();

            //Idedamas naujas skelbimas su tokiais pat duomenim
            $post = new Post();

            $post->patalpuTipas = $postHist->patalpuTipas;
            $post->savivaldybe = $postHist->savivaldybe;
            $post->gyvenviete = $postHist->gyvenviete;
            $post->mikroRaj = $postHist->mikroRaj;
            $post->gatve = $postHist->gatve;
            $post->plotas = $postHist->plotas;
            $post->komentaras = $postHist->komentaras;
            $post->kaina = $postHist->kaina;
            $post->statusas = 'skelbimas';
            $post->ivertinimas = $postHist->ivertinimas;
            $post->nuomin_id = 0;
            $post->apsilankymas = "";
            $post->post_history_id = $postHist->id;


            $user->posts()->save($post);


            switch ($post->patalpuTipas) {

                case "Namas":
                    $namHist = Nam::where('post_id', $postHist->id)->first();

                    $namas = new Nam();
                    $namas->namoNr = $namHist->namoNr;
                    $namas->pastatoTip = $namHist->pastatoTip;
                    $namas->irengimoTip = $namHist->irengimoTip;
                    $namas->sildymoTip = $namHist->sildymoTip;
                    $namas->metai = $namHist->metai;
                    $namas->namoTip =  $namHist->namoTip;

                    $post->nam()->save($namas);

                    break;

                case "Butas":
                    $butHist = But::where('post_id', $postHist->id)->first();

                    $butas = new But();
                    $butas->namoNr = $butHist->namoNr;
                    $butas->butoNr = $butHist->butoNr;
                    $butas->aukstas =  $butHist->aukstas;
                    $butas->kambSk = $butHist->kambSk;
                    $butas->pastatoTip = $butHist->pastatoTip;
                    $butas->irengimoTip = $butHist->irengimoTip;
                    $butas->sildymoTip = $butHist->sildymoTip;
                    $butas->aukstuSk = $butHist->aukstuSk;
                    $butas->metai = $butHist->metai;

                    $post->but()->save($butas);
                    break;
            }

            //Perkopijuojamos nuotraukos i naujaji skelbima
            $photos = Photo::where('post_id', $postHist->id)->get();
            if($photos->isNotEmpty()) {


                foreach($photos as $photo)
                {

                    $prefix = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/nuotraukos/";
                    $prefix2 = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/";
                    $orgPath = str_replace($prefix, "", $photo->path);
                    $newPath = 'nuotraukos/N'.$orgPath;
                    $orgPath = 'nuotraukos/'.$orgPath;


                    //statusas nustatomas ar pagrindine ar ne, ir per kopijuojamos tik pagrindines ir paprastos
                    if (strcmp($photo->statusas, 'pagrindine') == 0) {
                        Storage::copy($orgPath, $newPath);
                        $photoz = new Photo();
                        $photoz->path = $prefix2.$newPath;
                        $photoz->statusas = 'pagrindine';
                        $photoz->post_id = $post->id;
                        $photoz->save();

                    } else if (strcmp($photo->statusas, 'paprasta') == 0){
                        Storage::copy($orgPath, $newPath);
                        $photoz = new Photo();
                        $photoz->path = $prefix2.$newPath;
                        $photoz->statusas = 'paprasta';
                        $photoz->post_id = $post->id;
                        $photoz->save();
                    }

                }

            }

            //Atsiliepimai prijungiami prie naujojo skelbimo
            $reviews = Review::where('statusas', 'skelbimas')->where('rev_id', $postHist->id)->get();

            foreach ($reviews as $review)
            {
                $review->rev_id = $post->id;
                $review->save();
            }

            return "success";
        }

        return "no";

    }

    //Grazinami vartotojo ideti skelbimai kurie nera isnuomoti
    public function getIstorija(Request $request)
    {
        //Visada daromas tikrinimas ar useris is appso prisijunges
        $user = User::where('email', $request->input('email'))->first();
        if(Hash::check($request->input('api_token'), $user->api_token)) {
            //Jei is appso viskas ok

            $response = Post::where('user_id', $user->id)->orWhere('nuomin_id', $user->id)->get();

            if($response->isEmpty()) {
                return "none";
            }

            $response = $response->where('statusas', 'istorija');

            if($response->isEmpty()) {
                return "none";
            }

            $result = [];
            $part = [];
            $i = 0;

            foreach ($response->toArray() as $post) {

                switch ($post['patalpuTipas']) {
                    case "Namas":
                        $part = array_merge($post, Nam::all()->where('post_id', $post['id'])->first()->toArray());
                        break;
                    case "Butas":
                        $part = array_merge($post, But::all()->where('post_id', $post['id'])->first()->toArray());
                        break;
                }
                //Prie arejaus prijungiam ir pagrindine nuotrauka
                $photo = Photo::where('post_id', $part['post_id'])->where('statusas', 'pagrindine')->first();
                if(!empty($photo)) {
                    $part['nuot_path'] = $photo->path;
                }else
                {
                    $part['nuot_path'] = 'http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/nuotraukos/nuotrauku_ner.png';
                }
                //Idededam patalpu areju ir visu patalpu areju
                $result[$i] = $part;
                if(intval($result[$i]['user_id']) < 0)
                {
                    $result[$i]['user_id'] = (string)(-1*intval($result[$i]['user_id']));
                }else if(intval($result[$i]['nuomin_id']) < 0)
                {
                    $result[$i]['nuomin_id'] = (string)(-1*intval($result[$i]['nuomin_id']));
                }

                $i = $i + 1;
            }

            if(empty($result))
                return "none";

            $response = json_encode($result);

            return $response;
        }

        return "no";
    }

    //Paliekamas atsiliepimas ir ivertinimas apie patalpas ir/arba vartotoja
    public function paliktAtsIvert(Request $request)
    {
        //Visada daromas tikrinimas ar useris is appso prisijunges
        $user = User::where('email', $request->input('email'))->first();
        if(Hash::check($request->input('api_token'), $user->api_token)) {
            //Jei is appso viskas ok

            $review = Review::where('user_id', $user->id)->where('statusas', (string)$request->input('statusas'));
            if(strcmp((string)$request->input('statusas'), 'skelbimas') == 0) {
                $post = Post::where('post_history_id', intval($request->input('rev_id')))->first();
                $rev_id = $post->id;
            }else
            {
                $rev_id = intval($request->input('rev_id'));
            }
               $review = $review->where('rev_id', $rev_id);

            if($review->get()->isNotEmpty())
            {
                return "exists";

            }else {

                $review = new Review();
                $review->statusas = (string)$request->input('statusas'); //Ar atsiliepimas apie skelbima ar apie vartotoja
                $review->atsiliepimas = (string)$request->input('atsiliepimas');
                $review->ivertinimas = doubleval($request->input('ivertinimas'));
                $review->user_id = $user->id;


                //Ivertinimo dalis
                if(strcmp((string)$request->input('statusas'), 'skelbimas') == 0)
                {
                    //Atrandamas skelbimas kuriam turetu priklausyti ivertinimas ir atsiliepimas
                    $post = Post::where('post_history_id', intval($request->input('rev_id')))->first();
                    $review->rev_id = $post->id;
                    $review->save();

                    //Skaiciuojamas ivertinimas ir issaugojamas tam paciam postui
                    $reviews = Review::where('rev_id', intval($request->input('rev_id')))->where('statusas', 'skelbimas');
                    $count = $reviews->count();

                    $ivertinimas = 0;
                    foreach ($reviews->get()->toArray() as $review)
                    {
                        $ivertinimas = $ivertinimas + $review['ivertinimas'];
                    }

                    //CIA SITO REIKIA KADANGI NAUJAS REVIEW DAR PILNAI NEISSISAUGOJO!
                    $ivertinimas =  $ivertinimas + doubleval($request->input('ivertinimas'));
                    $count = $count + 1;

                    $ivertinimas = $ivertinimas/$count;

                    $post->ivertinimas = $ivertinimas;
                    $post->save();

                }else
                {
                    //Atrandamas vartotojas kuriam turetu priklausyti ivertinimas ir atsiliepimas
                    $user = User::find(intval($request->input('rev_id')));
                    $review->rev_id = $user->id;
                    $review->save();

                    //Skaiciuojamas ivertinimas ir issaugojamas tam paciam postui
                    $reviews = Review::where('rev_id', intval($request->input('rev_id')))->where('statusas', 'vartotojas');
                    $count = $reviews->count();

                    $ivertinimas = 0;
                    foreach ($reviews->get()->toArray() as $review)
                    {
                        $ivertinimas = $ivertinimas + $review['ivertinimas'];
                    }


                    //CIA SITO REIKIA KADANGI NAUJAS REVIEW DAR PILNAI NEISSISAUGOJO!
                    $ivertinimas =  $ivertinimas + doubleval($request->input('ivertinimas'));
                    $count = $count + 1;




                    $ivertinimas = $ivertinimas/$count;

                    $user->ivertinimas = $ivertinimas;
                    $user->save();
                }

                return "success";
            }

        }

        return "no";
    }

    //Istrinamas istorijos irasas
    public function istrintIstorija(Request $request)
    {

        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {


            $post = Post::find(intval($request->input('post_id')));



            //Jei nuomininkas ir nuomotojas istrina istorija is savo paskyros, istorija su visom savo asociacijom taip pat istrinama.
            if($post->user_id < 0 || $post->nuomin_id < 0) {

                //Istrinami visi dokumentai susija su patalpom
                $delete = File::where('post_id', $post->id)->get();
                if ($delete->isNotEmpty()) {

                    foreach ($delete as $del) {
                        $prefix = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/";
                        $delPath = str_replace($prefix, "", $del->path);

                        Storage::delete($delPath);

                        $del->delete();
                    }
                }


                //Istrinamos visos saskaitos susija su patalpom
                $delete = Saskaita::where('post_id', $post->id)->get();
                if ($delete->isNotEmpty()) {

                    foreach ($delete as $del) {
                        $prefix = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/";
                        $delPath = str_replace($prefix, "", $del->path);

                        Storage::delete($delPath);

                        $del->delete();
                    }
                }

                //Istrinamos visos nuotraukos susija su patalpom
                $delete = Photo::where('post_id', $post->id)->get();
                if ($delete->isNotEmpty()) {

                    foreach ($delete as $del) {
                        $prefix = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/";
                        $delPath = str_replace($prefix, "", $del->path);

                        Storage::delete($delPath);

                        $del->delete();
                    }
                }

                //IIIIR istrinamos pacios patalpos
                switch ($post->patalpuTipas)
                {
                    case "Namas":
                        $nam = Nam::where('post_id', $post->id)->first();
                        $nam->delete();
                        break;
                    case "Butas":
                        $but = But::where('post_id', $post->id)->first();
                        $but->delete();
                        break;
                }
                $post->delete();


                return "success";

            }else //Kitu atveju nustatoma kad istorija nebutu rodoma atitinkamam vartotojui
            {
                if($post->user_id == $user->id)
                {
                    $post->user_id = (-1*$user->id);
                    $post->save();
                }else
                {
                    $post->nuomin_id = (-1*$user->id);
                    $post->save();
                }

                return "success";
            }
        }
        return "no";
    }

    public function getAtsiliepimai(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            $reviews = Review::where('statusas', (string) $request->input('statusas'))->where('rev_id', intval($request->input('rev_id')))->get();

            if($reviews->isEmpty())
            {
                return "none";
            }

            $users = User::whereIn('id', $reviews->pluck('user_id')->all())->get();

            $atsakymas = [];
            $i = 0;

            foreach ($reviews->toArray() as $review)
            {
                $atsakymas[$i] = array_merge($review, $users->where('id', $review['user_id'])->first()->toArray());
                $i = $i + 1;
            }
            return $atsakymas;
        }

        return "no";
    }

    public function getNuotraukos(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('api_token'), $user->api_token)) {

            $post = Post::find(intval($request->input('post_id')));

            $photos = Photo::where('post_id', $post->id)->where('statusas', '<>','patvirtinta')->where('statusas', '<>', 'nepatvirtinta')
            ->where('statusas', '<>', 'atmesta')->get();

            if($photos->isEmpty())
            {
                return "none";
            }

            return $photos;
        }
    }
}
