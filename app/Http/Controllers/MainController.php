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
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use merge;

ini_set('max_execution_time', 300);

class MainController extends Controller
{
//    public function getNuomininkasIndex()
//    {
//        return view('layouts.nuomininkas');
//    }
//
//    public function postNuomininkas(Request $request)
//    {
//        $posts = Post::where('pavadinimas', 'like', "%".$request->input('pavadinimas')."%")->
//        where('vieta', 'like', "%".$request->input('pavadinimas')."%")->
//        whereBetween('kaina', [$request->input('kainaN'), $request->input('kainaI')])->get();
//
//        return view('layouts.search', ['posts' => $posts]);
//
//    }
//
//
//    public function getNuomotojasIndex()
//    {
//        return view('layouts.nuomotojas');
//    }
//
//    public function getSkelbimas()
//    {
//        return view('layouts.skelbimas');
//    }
//
//    public function getSkelbimai()
//    {
//        $user = Auth::user();
//        //$files = null;
//
//        $posts = Post::where('user_id', $user->id)->paginate(3);
//        $files = File::all();
//        return view('layouts.skelbimai', ['posts' => $posts], ['files' => $files]);
//    }
//
//
//    /*public function postSkelbimas(Request $request)
//    {
//        $post = new Post([
//            'pavadinimas' => $request->input('pavadinimas'),
//            'vieta' => $request->input('vieta'),
//            'kaina' => $request->input('kaina'),
//        ]);
//
//        $user = Auth::user();
//
//
//        $user->posts()->save($post);
//
//        if($request->file('nuotrauka') != null)
//        {
//            $path = $request->file('nuotrauka')->store('public');
//
//            $file = new File(['path' => $path]);
//
//            $post->files()->save($file);
//        }
//
//        return redirect()->route('layouts.nuomotojas')->
//        with('info', 'Sėkmingai išsaugota');
//    }*/
//
//    public function  getSkelbimasRed($id)
//    {
//        $post = Post::find($id);
//        if(Gate::denies('update-post', $post))
//        {
//            return redirect()->back();
//        }
//        $post = Post::find($id);
//        return view('layouts.skelbimasRed', ['post' => $post, 'postId' => $id]);
//    }
//
//
//    public function postSkelbimasRed(Request $request)
//    {
//        $post = Post::find($request->input('id'));
//        if(Gate::denies('update-post', $post))
//        {
//            return redirect()->back();
//        }
//
//            $post->pavadinimas = $request->input('pavadinimas');
//            $post->vieta = $request->input('vieta');
//            $post->kaina = $request->input('kaina');
//
//        $post->save();
//
//        return redirect()->route('layouts.skelbimai')->
//        with('info', 'Sėkmingai redaguota');
//    }
//
//    public function getSkelbimasDel($id)
//    {
//        $post = Post::find($id);
//        if(Gate::denies('update-post', $post))
//        {
//            return redirect()->back();
//        }
//        $post->delete();
//        return redirect()->route('layouts.skelbimai')->
//        with('info', 'Skelbimas ištrintas');
//    }
//
//    public function getGrafikas()
//    {
//        $user = Auth::user();
//        if(Graph::where('user_id', $user->id)->first() != null) {
//            $graph = Graph::where('user_id', $user->id)->first();
//        }else{
//            $graph = null;
//        }
//        return view('layouts.grafikas', ['graph' => $graph]);
//    }
//
//    public function getEditGrafikas()
//    {
//        $user = Auth::user();
//        if(Graph::where('user_id', $user->id)->first() != null) {
//            $graph = Graph::where('user_id', $user->id)->first();
//        }else{
//            $graph = Graph::where('user_id', 0)->first();
//        }
//
//        return view('layouts.pildytGrafika', ['graph' => $graph]);
//    }
//
//    public function postEditGrafikas(Request $request)
//    {
//
//        $graph = new Graph([
//            'pirmadienis' => $request->input('pirmadienis'),
//            'antradienis' => $request->input('antradienis'),
//            'treciadienis' => $request->input('treciadienis'),
//            'ketvirtadienis' => $request->input('ketvirtadienis'),
//            'penktadienis' => $request->input('penktadienis'),
//            'sestadienis' => $request->input('sestadienis'),
//            'sekmadienis' => $request->input('sekmadienis')
//        ]);
//
//        $user = Auth::user();
//
//            if (Graph::where('user_id', $user->id)->first() == null) {
//                $user->graphs()->save($graph);
//            } else {
//                $graph->save();
//            }
//        return redirect()->route('layouts.grafikas', ['graph' => $graph])->
//        with('info', 'Grafikas sėkmingai išsaugotas');
//    }
    //public function getManNuomin(Request $request)
//    {
//        //Visada daromas tikrinimas ar useris is appso prisijunges
//        $user = Auth::user();
//
//        $response = Post::where('nuomin_id', $user->id)->where('statusas', 'patalpos');
//
//        $result = [];
//        $i = 0;
//        foreach ($response->get()->toArray() as $post) {
//
//            switch ($post['patalpuTipas']) {
//                case "Namas":
//                    $part = array_merge($post, Nam::all()->where('post_id', $post['id'])->first()->toArray());
//                    break;
//                case "Butas":
//                    $part = array_merge($post, But::all()->where('post_id', $post['id'])->first()->toArray());
//                    break;
//            }
//            $result[$i] = $part;
//            $i = $i + 1;
//        }
//
//        if(empty($result))
//            return "none";
//
//        return $response;
//    }
    public function paieska(Request $request)
    {
        /*$posts = Post::where('savivaldybe', 'like', "%".$request->input('savivaldybe')."%");
        $posts = $posts->where('gyvenviete', 'like', '%'.$request->input('gyvenviete').'%')->get();
        $buts = But::where('post_id', $posts->pluck('id'))->get();
        return $buts->toJson();*/

        //$user = Auth::user(); naudot shita, vietoj zemiau esancio
        $user = Auth::user();
//
        //$easier = Hash::check($request->input('api_token'), $user->api_token);
        $easier = true; //USE ME IN NORMAL MODE
        if($easier) {


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
                            $photo = [];
                            $result = [];
                            $i = 0;
                            foreach ($response->get()->toArray() as $post) {
                                $photoPart = Photo::where('post_id', $post['id'])->where('statusas', 'pagrindine')->first();
                                if ($photoPart != null) {
                                    $photoPart = $photoPart->path;
                                }
                                else{
                                    $photoPart = 'http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/nuotraukos/nuotrauku_ner.png';
                                }
                                $part = array_merge($post, $buts->get()->where('post_id', $post['id'])->first()->toArray());
                                $photo[$i] = $photoPart;
                                $result[$i] = $part;
                                $i = $i + 1;
                            }

                            $response = $result;

                        }else
                        {
                            return view('layouts.paieskosRezultatai', ['rezultatai' => false]);
                        }
                    }else
                    {
                        return view('layouts.paieskosRezultatai', ['rezultatai' => false]);
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
                                $photoPart = Photo::where('post_id', $post['id'])->where('statusas', 'pagrindine')->first();
                                if ($photoPart != null) {
                                    $photoPart = $photoPart->path;
                                }
                                else{
                                    $photoPart = 'http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/nuotraukos/nuotrauku_ner.png';
                                }
                                $part = array_merge($post, $nams->get()->where('post_id', $post['id'])->first()->toArray());
                                $photo[$i] = $photoPart;
                                $result[$i] = $part;
                                $i = $i + 1;
                            }

                            $response = $result;

                        }else
                        {
                            return view('layouts.paieskosRezultatai', ['rezultatai' => false]);
                        }
                    }else
                    {
                        return view('layouts.paieskosRezultatai', ['rezultatai' => false]);
                    }
                    break;

                default:
                    return 'neegzistuoja';
                    break;
            }

            return view('layouts.paieskosRezultatai')
                ->with('rezultatai', $response)
                ->with('nuotrauka', $photo);

        }else
        {
            return 'no';
        }
    }
    public function postSkelbimas(Request $request)
    {
            $post = new Post();
            $post->patalpuTipas = (string)$request->input('patalpuTipas');
            $post->savivaldybe = (string)$request->input('savivaldybe');
            $post->gyvenviete = (string)$request->input('gyvenviete');
            $post->mikroRaj = (string)$request->input('mikrorajonas');
            $post->gatve =(string) $request->input('gatve');
            $post->plotas = intval($request->input('plotas'));
            $post->komentaras = (string)$request->input('komentaras');
            $post->kaina = intval($request->input('kaina'));
            $post->statusas = 'skelbimas';
            $post->ivertinimas = 0;
            $post->nuomin_id = 0;
            $post->apsilankymas = "";
            $post->post_history_id = 0;

            $user = Auth::user();
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
        //$i = 1;


            $path = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/".$request->file('pic')->store('nuotraukos');
            //Local testing
            //$path = $request->file('nuotrauka')->store('nuotraukos');
            $photo = new Photo();
            $photo->path = $path;
            //statusas nustatomas ar pagrindine ar ne

                $photo->statusas = 'pagrindine';

//            else {
//                $photo->statusas = 'paprasta';
//            }
            $post->photos()->save($photo);

            //$i = $i + 1;


        return redirect()->back()->with('info', 'Skelbimas įkeltas sėkmingai');
    }
//    public function postSkelb(Request $request)
//    {
//        $user = User::where('email', $request->input('email'))->first();
//        if (Hash::check($request->input('api_token'), $user->api_token)) {
//
//            $post = new Post();
//
//            $post->patalpuTipas = (string)$request->input('patalpuTipas');
//            $post->savivaldybe = (string)$request->input('savivaldybe');
//            $post->gyvenviete = (string)$request->input('gyvenviete');
//            $post->mikroRaj = (string)$request->input('mikroRaj');
//            $post->gatve =(string) $request->input('gatve');
//            $post->plotas = intval($request->input('plotas'));
//            $post->komentaras = (string)$request->input('komentaras');
//            $post->kaina = intval($request->input('kaina'));
//            $post->statusas = 'skelbimas';
//            $post->ivertinimas = 0;
//            $post->nuomin_id = 0;
//            $post->apsilankymas = "";
//            $post->post_history_id = 0;
//
//            $user->posts()->save($post);
//
//            switch ($post->patalpuTipas) {
//
//                case "Namas":
//                    $namas = new Nam();
//                    $namas->namoNr = intval($request->input('namoNr'));
//                    $namas->pastatoTip = (string)$request->input('pastatoTip');
//                    $namas->irengimoTip = (string)$request->input('irengimoTip');
//                    $namas->sildymoTip = (string)$request->input('sildymoTip');
//                    $namas->metai = intval($request->input('metai'));
//                    $namas->namoTip = (string)$request->input('namoTip');
//
//                    $post->nam()->save($namas);
//
//                    break;
//
//                case "Butas":
//                    $butas = new But();
//                    $butas->namoNr = intval($request->input('namoNr'));
//                    $butas->butoNr = intval($request->input('butoNr'));
//                    $butas->aukstas = intval($request->input('aukstas'));
//                    $butas->kambSk = intval($request->input('kambSk'));
//                    $butas->pastatoTip = (string)$request->input('pastatoTip');
//                    $butas->irengimoTip = (string)$request->input('irengimoTip');
//                    $butas->sildymoTip = (string)$request->input('sildymoTip');
//                    $butas->aukstuSk = intval($request->input('aukstuSk'));
//                    $butas->metai = intval($request->input('metai'));
//
//                    $post->but()->save($butas);
//                    break;
//            }
//
//            //Nuotrauku ikelimas
//            $i = 1;
//
//            while($request->file('pic'.$i) != null)
//            {
//                $path = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/".$request->file('pic'.$i)->store('nuotraukos');
//
//                $photo = new Photo();
//                $photo->path = $path;
//
//                //statusas nustatomas ar pagrindine ar ne
//                if(intval($request->input('pagrNuot')) == $i)
//                {
//                    $photo->statusas = 'pagrindine';
//                }else {
//                    $photo->statusas = 'paprasta';
//                }
//                $post->photos()->save($photo);
//
//                $i = $i + 1;
//            }
//            return "success";
//        }
//        return "no";
//    }
    public function postIkeltPaprastaNuot(Request $request)
    {
        $user = Auth::user();

            $post = Post::find(intval($request->input('post_id')));

            $path = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/".$request->file('nuotrauka')->store('nuotraukos');
            //Local testing
            //$path = $request->file('nuotrauka')->store('nuotraukos');
            $photo = new Photo();
            $photo->path = $path;
            $photo->statusas = 'paprasta';

            $post->photos()->save($photo);

            //$photo = Photo::where('post_id', $post->id);
            return redirect()->back()
                ->with('info', 'Papildoma nuotrauka įkelta sėkmingai');


//        return redirect()->back()->with('info', 'Įvyko nenumatyta problema');
    }
    public function postIstrintiSkelbima(Request $request)
    {

        $user = Auth::user();

            $post = Post::find(intval($request->input('post_id')));

            //Jeigu egzistuoja skelbimas kurio susitikimo laikas yra patvirtintas arba rezervuojamas, tai jo istrinti negalima

            $graphs = Graph::where('statusas', 'patvirtinta')->orWhere('statusas', 'rezervuojama')->get();

            if($graphs->isNotEmpty()) {
                $graphs = $graphs->where('post_id', $post->id);
                if ($graphs->isNotEmpty())
                    return redirect()->back()->with('infoBad', 'Ištrinti nepavyko, kadangi jūs įsipareigojęs objektą aprodyti');
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
                //$prefix = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/";
                $delPath = $photo->path;
                Storage::delete($delPath);

                $photo->delete();
            }
            $post->delete();
            return redirect()->back()->with('info', 'Skelbimas ištrintas sėkmingai');
    }
//    public function getNauj()
//    {
//        //Visada daromas tikrinimas ar useris is appso prisijunges
//            //Jei is appso viskas ok
//    }
    public function getHome(){
        $response = Post::orderBy('created_at', 'desc')->where('statusas', 'skelbimas');

        $resultNauj = [];
        $i = 0;
        foreach ($response->get()->toArray() as $post) {
            $photoPart = Photo::where('post_id', $post['id'])->where('statusas', 'pagrindine')->first();
            if ($photoPart != null) {
                $photoPart = $photoPart->path;
            }
            else{
                $photoPart = 'http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/nuotraukos/nuotrauku_ner.png';
            }
            switch ($post['patalpuTipas']) {
                case "Namas":
                    $part = array_merge($post, Nam::all()->where('post_id', $post['id'])->first()->toArray());
                    break;
                case "Butas":
                    $part = array_merge($post, But::all()->where('post_id', $post['id'])->first()->toArray());
                    break;
            }
            $photoNauj[$i] = $photoPart;
            $resultNauj[$i] = $part;
            $i = $i + 1;
        }
        $response = Post::orderBy('ivertinimas', 'desc')->where('statusas', 'skelbimas');

        $resultPop = [];
        $i = 0;
        foreach ($response->get()->toArray() as $post) {
            $photoPart = Photo::where('post_id', $post['id'])->where('statusas', 'pagrindine')->first();
            if ($photoPart != null) {
                $photoPart = $photoPart->path;
            }
            else{
                $photoPart = 'http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/nuotraukos/nuotrauku_ner.png';
            }
            switch ($post['patalpuTipas']) {
                case "Namas":
                    $part = array_merge($post, Nam::all()->where('post_id', $post['id'])->first()->toArray());
                    break;
                case "Butas":
                    $part = array_merge($post, But::all()->where('post_id', $post['id'])->first()->toArray());
                    break;
            }
            $photoPop[$i] = $photoPart;
            $resultPop[$i] = $part;
            $i = $i + 1;
        }
        return view('layouts.home')
            ->with('photoNauj', $photoNauj)
            ->with('postsNauj', $resultNauj)
            ->with('photoPop', $photoPop)
            ->with('postsPop', $resultPop);
    }

    //Grazinamos vartotojo isnuomotos ir issinuomotos patalpos

    public function getManNuomot()
    {
        //Visada daromas tikrinimas ar useris is appso prisijunges
        $user = Auth::user();

            //Jei is appso viskas ok
//isnuomoti objektai
        $response = Post::where('user_id', $user->id)->where('statusas', 'patalpos');

        $isnuomoti = [];
       // $nuominkas = [];
        $photoIsnuomoti = [];
            $i = 0;
        foreach ($response->get()->toArray() as $post) {
            $photoPart = Photo::where('post_id', $post['id'])->where('statusas', 'pagrindine')->first();
            if ($photoPart != null) {
                $photoPart = $photoPart->path;
            }
            else{
                $photoPart = 'http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/nuotraukos/nuotrauku_ner.png';
            }
                switch ($post['patalpuTipas']) {
                    case "Namas":
                        $part = array_merge($post, Nam::all()->where('post_id', $post['id'])->first()->toArray());
                        break;
                    case "Butas":
                        $part = array_merge($post, But::all()->where('post_id', $post['id'])->first()->toArray());
                        break;
                }
                $part= array_merge($part, User::find($part ['nuomin_id'])->toArray() );
                $photoIsnuomoti[$i] = $photoPart;
                $isnuomoti[$i] = $part;
                //$nuominkas[$i] = User::find($isnuomoti[$i] ['nuomin_id']);
                $i = $i + 1;
            }

//Issinuomoti objektai
        $response = Post::where('nuomin_id', $user->id)->where('statusas', 'patalpos');

        $issinuomoti = [];
        $photoIssinuomoti = [];
        $i = 0;

        foreach ($response->get()->toArray() as $post) {
            $photoPart = Photo::where('post_id', $post['id'])->where('statusas', 'pagrindine')->first();
            if ($photoPart != null) {
                $photoPart = $photoPart->path;
            }
            else{
                $photoPart = 'http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/nuotraukos/nuotrauku_ner.png';
            }
            switch ($post['patalpuTipas']) {
                case "Namas":
                    $part = array_merge($post, Nam::all()->where('post_id', $post['id'])->first()->toArray());
                    break;
                case "Butas":
                    $part = array_merge($post, But::all()->where('post_id', $post['id'])->first()->toArray());
                    break;
            }
            $part= array_merge($part, User::find($part ['user_id'])->toArray() );
            $photoIssinuomoti[$i] = $photoPart;
            $issinuomoti[$i] = $part;
            $i = $i + 1;
        }
        return view('layouts.objPerziura')
                ->with('photoIsnuomoti', $photoIsnuomoti)
                ->with('photoIssinuomoti', $photoIssinuomoti)
                ->with('manoIsnuomoti', $isnuomoti)
                ->with('manoIssinuomoti', $issinuomoti);
    }
    public function getIstorija(Request $request)
    {
        //Visada daromas tikrinimas ar useris is appso prisijunges
        $user = Auth::user();
            //Jei is appso viskas ok

            $response = Post::where('user_id', $user->id)->orWhere('nuomin_id', $user->id)->get();
//            $nuomotojas = User::find($response->user_id);
//            $nuomininkas = User::find($response->nuomin_id);
            if($response->isEmpty()) {
                return redirect()->back();
            }

            $response = $response->where('statusas', 'istorija');

            if($response->isEmpty()) {
                return redirect()->back();
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
                //$photo[$i]->path = $part['nuot_path'];
                if(intval($result[$i]['user_id']) < 0)
                {
                    $result[$i]['user_id'] = (string)(-1*intval($result[$i]['user_id']));
                }else if(intval($result[$i]['nuomin_id']) < 0)
                {
                    $result[$i]['nuomin_id'] = (string)(-1*intval($result[$i]['nuomin_id']));
                }

                $i = $i + 1;
            }
            return view('layouts.nuomosIstorija')
//                ->with('nuomotojas', $nuomotojas)
//                ->with('nuomininkas', $nuomininkas)
                    ->with('nuomosIstorija', $result);
                    //->with('photo', $photo);
    }
    //grazinami vartotojo skelbimai
    public function getManoSkelbimai(Request $request)
    {
        //Visada daromas tikrinimas ar useris is appso prisijunges
        $user = Auth::user();

            $response = Post::where('user_id', $user->id)->where('statusas', 'skelbimas');

            $result = [];
            $part = [];
            $i = 0;
            $photo = [];
            foreach ($response->get()->toArray() as $post){

                $photoPart = Photo::where('post_id', $post['id'])->where('statusas', 'pagrindine')->first();
                if ($photoPart != null) {
                    $photoPart = $photoPart->path;
                }
                else{
                    $photoPart = 'http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/nuotraukos/nuotrauku_ner.png';
                }
                switch ($post['patalpuTipas']) {
                    case "Namas":
                        $part = array_merge($post, Nam::all()->where('post_id', $post['id'])->first()->toArray());
                        break;
                    case "Butas":
                        $part = array_merge($post, But::all()->where('post_id', $post['id'])->first()->toArray());
                        break;
                }
                $photo[$i] = $photoPart;
                $result[$i] = $part;
                $i = $i + 1;
            }
//            if(empty($result))
//                return "none";


            //$response = json_encode($result);
        //return $result;
        return view('layouts.manoSkelbimai')
            ->with('nuotrauka', $photo)
            ->with('manoSkelbimai', $result);

    }
    public function postRasytiAtsiliepima(Request $request)
    {
        //Visada daromas tikrinimas ar useris is appso prisijunges
        $user = Auth::user();

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
                return redirect()->back()->with('info', 'Jau esate palikę atsiliepimą!');

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

                return redirect()->back()->with('info', 'Atsiliepimas yra įrašytas!');
            }

    }
    public function  getSkelbimoPerziura($id)
    {
        $post = Post::find($id);
        $user = User::find($post->user_id);
        //return $user;
        $pagrindine = Photo::where('post_id', $id)->where('statusas', 'pagrindine')->first();
        $paprastos = Photo::where('post_id', $id)
            ->where('statusas', '<>', 'atmesta')
            ->where('statusas', '<>', 'patvirtinta')
            ->where('statusas', '<>', 'nepatvirtinta')->get()->toArray();

        return view('layouts.skelbimoPerziura')
        ->with('nuomotojas', $user)
        ->with('post', $post)
        ->with('pagrindine', $pagrindine)
        ->with('paprastos', $paprastos)
        ->with('postId', $id);
    }
    public function  getObjektas($id)
    {
        //$user = Auth::user()->toArray();
        $post = Post::find($id)->toArray();
        //$merge = array_merge($post
        //return $post;
        return view('layouts.objektas')
        ->with('post', $post)
        ->with('postId', $id);
    }

    public function getSkaitRodmenys(Request $request, $id)
    {
        $yearArray = array("2017","2018","2019");
        $monthArray = array("Sausis","Vasaris","Kovas","Balandis","Gegužė","Birželis","Liepa","Rugpjūtis","Rugsėjis","Spalis","Lapkritis","Gruodis");
        $metai = $request->query('metai');
        $menesis = $request->query('menesis');
        $user=Auth::user();
        $post=Post::find($id);
        $skelbimas=Post::where('id', $id)->first();
        $saskaitas=Saskaita::where('post_id', $id)->where('metai', $metai)->where('menesis', $menesis)->first();
        return view('layouts.skaitRodmenys')
                    ->with('yearArray', $yearArray)
                    ->with('monthArray', $monthArray)
                    ->with('metaiURL', $metai)
                    ->with('menesisURL', $menesis)
                    ->with('saskaitas', $saskaitas)
                    ->with('skelbimas', $skelbimas)
                    ->with('postId', $post->id)
                    ->with('savininkas', $user);
    }

    public function postSkaitiklioRodmenys(Request $request)
    {

        $user = Auth::user();

            $post = Post::find(intval($request->input('post_id')));

            //Tikrinama ar saskaita jau yra pildyta siom patalpom, siais metais ir siam menesiui
            if(!empty($saskaita = Saskaita::where('post_id', $post->id)->where('menesis', (string)$request->input('menesis'))
                ->where('metai', intval($request->input('metai')))->first())) {

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
        return redirect()->back()->with('info', 'Skaitiklio rodmenys sėkmingai pateikti');
    }
    public function postApsilank(Request $request)
    {
            $user = Auth::user();
            $post = Post::find(intval($request->input('post_id')));
            $post->apsilankymas = $request->input('apsilankymas');
            $post->save();
            return redirect()->back()->with('info', 'Apie apsilankymą pranešta sėkmingai');
    }
    public function getAtsiliepimaiApieNuomotoja($id)
    {
        $atsakymas = [];
        //$post=Post::find($id);
        $user = User::find($id);
            $reviews = Review::where('statusas', 'vartotojas')->where('rev_id', $user->id)->get();

            if($reviews->isEmpty())
            {
                return view('layouts.atsiliepimaiApieNuomotoja' )
                    ->with('atsakymas', $atsakymas)
                    ->with('info', 'Atsiliepimų nėra');
            }

            $users = User::whereIn('id', $reviews->pluck('user_id')->all())->get();
            $atsakymas = [];
            $i = 0;

            foreach ($reviews->toArray() as $review)
            {
                $atsakymas[$i] = $review;
                $i = $i + 1;
            }
            //return $atsakymas;
            return view('layouts.atsiliepimaiApieNuomotoja')
            ->with('atsakymas', $atsakymas);
    }
    public function getAtsiliepimaiApieObjekta($id)
    {
        $atsakymas = [];
        $post=Post::find($id);
        $user = Auth::user();
        $reviews = Review::where('statusas', 'skelbimas')->where('rev_id', $post->id)->get();

        if($reviews->isEmpty())
        {
            return view('layouts.atsiliepimaiApieObjekta' )
                ->with('atsakymas', $atsakymas)
                ->with('info', 'Atsiliepimų nėra');
        }

        $users = User::whereIn('id', $reviews->pluck('user_id')->all())->get();
        $atsakymas = [];
        $i = 0;

        foreach ($reviews->toArray() as $review)
        {
            $atsakymas[$i] = $review;
            $i = $i + 1;
        }
        //return $atsakymas;
        return view('layouts.atsiliepimaiApieObjekta')
            ->with('atsakymas', $atsakymas);
    }
    public function getAtsiliepimaiApieNuomininka($id)
    {
        //$post=Post::find($id);
        $user = User::find($id);
        $reviews = Review::where('statusas', 'vartotojas')->where('rev_id', $user->id)->get();
        $atsakymas = [];
        if($reviews->isEmpty())
        {
            return view('layouts.atsiliepimaiApieNuomininka' )
                ->with('id', $user->id)
                ->with('atsakymas', $atsakymas)
                ->with('info', 'Atsiliepimų nėra');
        }

        $users = User::whereIn('id', $reviews->pluck('user_id')->all())->get();

        $i = 0;

        foreach ($reviews->toArray() as $review)
        {
            $atsakymas[$i] = $review;
            $i = $i + 1;
        }
        //return $atsakymas;
        return view('layouts.atsiliepimaiApieNuomininka')
            ->with('id', $user->id)
            ->with('atsakymas', $atsakymas);
    }

    public function getGrafikas(Request $request, $id)
    {
        $savaite = $request->query('savaite');
        $diena = $request->query('diena');
        $post = Post::find($id);
        //$user = Auth::user()->find($id);
        $dayArray = array("", "Pirmadienis", "Antradienis", "Trečiadienis", "Ketvirtadienis", "Penktadienis", "Šeštadienis", "Sekmadienis");
            $graphs = Graph::where('user_id', $post->user_id)->where('statusas', '<>', 'atsaukta')->where('statusas', '<>', 'atmesta')->get();
            $laikais = Graph::where('user_id', $post->user_id)->where('statusas', '<>', 'atsaukta')->where('statusas', '<>', 'atmesta')->where('savaitesNr', $savaite)->where('diena', $diena)->orderBy('laikas', 'asc')->get();
            //return $graphs;
            //return $laikais;
                return view('layouts.rezervuoti')
                    ->with('postId', $post->id)
                    ->with('grafikas', $graphs)
                    ->with('dayArray', $dayArray)
                    ->with('post', $post)
                    ->with('savaite', $savaite)
                    ->with('diena', $diena)
                    ->with('laikais', $laikais);
    }
    public function getPerziuretiRezervacijas($postId){

        $post = Post::find($postId);
        $user = Auth::user();
        $dayArray = array("", "Pirmadienis", "Antradienis", "Trečiadienis", "Ketvirtadienis", "Penktadienis", "Šeštadienis", "Sekmadienis");
        $rezervacijos = Graph::where('post_id', $postId)->where('user_id', $user->id)->where('statusas', 'rezervuojama')->get();
//        foreach($rezervacijos as $rezervacijo){
//            $nuomin = User::where('id', $rezervacijo->nuomin_id)->get();
//        }

        return view('layouts.rezervacijos')
            ->with('dayArray', $dayArray)
            ->with('rezervas', $rezervacijos)
            ->with('skelbimas', $post);

    }
    public function getManoRezervacijos($id)
    {
        $user = User::find($id)->first();
        $dayArray = array("", "Pirmadienis", "Antradienis", "Trečiadienis", "Ketvirtadienis", "Penktadienis", "Šeštadienis", "Sekmadienis");
        $rezervacijos = Graph::where('nuomin_id', $id)
            ->where('statusas', '<>', 'laisva')->get();


        return view('layouts.manoRezervacijos')
            ->with('dayArray', $dayArray)
            ->with('rezervacijos', $rezervacijos);
    }
    public function postAtsauktiRezervacija(Request $request)
    {

        $user = Auth::user();

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

            return redirect()->back()
                ->with('info', 'Rezervacijos statusas sėkmingai pakeistas');
    }
    public function postPatvirtintiLaika(Request $request)
    {
        $user = Auth::user();
            $graph = Graph::find(intval($request->input('id')));
            $graph->statusas = 'patvirtinta';
            $graph->save();
        return redirect()->back()->with('info', 'Laikas sėkmingai patvirtintas');

    }
    public function getPerziuretiApziuras($postId){
        $post = Post::find($postId);
        $user = Auth::user();
        $dayArray = array("", "Pirmadienis", "Antradienis", "Trečiadienis", "Ketvirtadienis", "Penktadienis", "Šeštadienis", "Sekmadienis");
        $patvirtinti = Graph::where('post_id', $postId)->where('user_id', $user->id)->where('statusas', 'patvirtinta')->get();

        return view('layouts.apziuros')
            ->with('patvirtintis', $patvirtinti)
            ->with('dayArray', $dayArray)
            ->with('skelbimas', $post);

    }
    public function postIsnuomoti(Request $request)
    {
        $user = Auth::user();
            $post = Post::find(intval($request->input('post_id')));

            $post->statusas = 'patalpos'; //Patalpos isnuomotos todel ju statusas pakeiciamas i true

//            $email = (string)$request->input('email2');

//            if(strlen($email) > 0) {
//
//                $nuomin = User::where('email', $email)->first();
//
//                if(empty($nuomin))
//                    return "none";
//
//                if($post->user_id == $nuomin->id)
//                {
//                    return "nuomot";
//                }
//
//            }else
//            {
                if(intval($request->input('nuomin_id')) == 0)
                    return redirect()->back()->with('info', 'nuomininkas neegzistuoja');

                $nuomin = User::find(intval($request->input('nuomin_id')));
//            }

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

            return redirect()->back()->with('success', 'Vartotojui patalpos išnuomotos');
    }
    public function rezervuotiLaika(Request $request, $id)
    {
        $savaite = $request->query('savaite');
        $diena = $request->query('diena');
        $user = Auth::user();
        $post = Post::find($id);
        $dayArray = array("", "Pirmadienis", "Antradienis", "Trečiadienis", "Ketvirtadienis", "Penktadienis", "Šeštadienis", "Sekmadienis");
            $graph = Graph::find(intval($request->input('laikoId')));

            $graph->post_id = $request->input('post_id');
            $graph->nuomin_id = $user->id;

            $graph->statusas = 'rezervuojama';

            $graph->save();

            return redirect()->back()
                ->with('postId', $post->id)
                ->with('info', 'Rezervacijos laikas nusiųstas nuomotojui patvirtinti')
                //->with('grafikas', $graphs)
                ->with('dayArray', $dayArray)
                ->with('post', $post)
                ->with('savaite', $savaite)
                ->with('diena', $diena);
                //->with('laikais', $laikais);
    }
    public function postAtmestiLaika(Request $request)
    {

        $user = Auth::user();

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

            return redirect()->back()->with('info', 'Apžiūros rezervacija atmesta');
    }
    //Issaugojamas grafikas. I SI METODA PADUODAMA LABAI DIDELIS JSON ARRAY!
    //Kur 0 indexe email ir api tokenas
    public function getAtvykPranesimas($id)
    {
        $user = Auth::user();
        $post = Post::find($id);
        return view('layouts.atvykPranesimas')
            ->with('user', $user)
            ->with('skelbimas', $post);
    }

    public function getPaskyra($id)
    {
        return view('layouts.paskyra', ['id' => $id]);
    }

    public function getIdejimas()
    {
        return view('layouts.skelbimoIdejimas');
    }

    public function getDuomenuKeitimas()
    {
        return view('layouts.duomenuKeitimas');
    }
    public function getSas($id)
    {
        $user = Auth::user()->first();
        $post = Post::find($id)->first();

        $saskaitos = Saskaita::where('post_id', $id)->where('path', '<>', '');
        if($saskaitos->get()->isNotEmpty())
        {
            $result = $saskaitos->get()->toArray();
            return view('layouts.sask')
                ->with('saskaitos', $result)
                ->with('postId', $id)
                ->with('skelbimas', $post)
                ->with('vartotojas', $user);
        }
        else
        {
            $result = $saskaitos->get()->toArray();
            return view('layouts.sask')
                ->with('saskaitos', $result)
                ->with('postId', $id)
                ->with('skelbimas', $post)
                ->with('vartotojas', $user);
        }
    }
    public function postStatSas(Request $request)
    {
        $user = Auth::user()->get();

            $saskaita = Saskaita::find(intval($request->input('saskId')));

            if(!empty($saskaita))
            {
                $saskaita->statusas = "apmokėta";
                $saskaita->save();
                return redirect()->back()->with('info','Sąskaita pažymėta kaip amokėta');
            }
            return redirect()->back()->with('info','Nutiko nenumatytas įvykis');
    }
    public function postNutrauktiNuoma(Request $request)
    {
        $user = Auth::user();

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
            return redirect()->route('layouts.objPerziura')->with('info', 'Objekto Nuomojimas nutrauktas');

    }
    public function postDeleteSas(Request $request)
    {
        $user = Auth::user();
            $saskaita = Saskaita::find(intval($request->input('id')));

            if(!empty($saskaita))
            {
                //$prefix = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/";
                //$delPath = str_replace($prefix, "", $saskaita->path);
                $delPath = $saskaita->path;
                Storage::delete($delPath);
                $saskaita->delete();

                return redirect()->back()->with('info', 'Sąskaita sėkmingai ištrinta');
            }
        return redirect()->back()->with('info', 'Įvyko nenumatytas įvykis');
    }

    public function postIkeltSas(Request $request)
    {

        $user = Auth::user();
        if($request->file('dokumentas') != null)
        {

            $post = Post::find(intval($request->input('post_id')));


            $monthArray = array("Sausis", "Vasaris", "Kovas", "Balandis", "Gegužė", "Birželis", "Liepa", "Rugpjūtis", "Rugsėjis", "Spalis", "Lapkritis", "Gruodis");

            //Tikrinama ar saskaita jau yra pildyta siom patalpom, siais metais ir siam menesiui
            if(!empty($saskaita = Saskaita::where('post_id', $post->id)->where('menesis', $monthArray[intval($request->input('menesis'))])
                ->where('metai', intval($request->input('metai')))->first())) {


                if(strlen($saskaita->path) > 0)
                {
                    return redirect()->back()->with('info', 'Jau esate pateikę sąskaitą šiam mėnesiui');
                }


                $path = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/".$request->file('dokumentas')->store('saskaitos');
                //lokal testing
                //$path = $request->file('dokumentas')->store('saskaitos');

                $saskaita->bendraSum = floatval($request->input('bendraSum'));
                $saskaita->statusas = 'neapmokėta';
                $saskaita->path = $path;

                $saskaita->save();

                return redirect()->back()->with('info', 'Sąskaita įkelta sėkmingai');
            }
            else
            {
                $path = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/".$request->file('dokumentas')->store('saskaitos');
                //for lokal testing
                //$path = $request->file('dokumentas')->store('saskaitos');

                $saskaita = new Saskaita();
                $saskaita->metai = intval($request->input('metai'));
                $saskaita->menesis = $monthArray[intval($request->input('menesis'))];
                $saskaita->elektra = 0;
                $saskaita->dujos = 0;
                $saskaita->karstas = 0;
                $saskaita->saltas = 0;
                $saskaita->bendraSum = floatval($request->input('bendraSum'));
                $saskaita->statusas = 'neapmokėta';
                $saskaita->path = $path;

                $post->saskaitas()->save($saskaita);
            }

            return redirect()->back();
        }
    }

    public function getDokIkelimas($id)
    {
        $user = Auth::user();

            $files = File::where('post_id', $id);

            $post = Post::where('id', $id)->first();
            $i=0;
            if($files->get()->isNotEmpty())
            {

                $result = $files->get()->toArray();
                //$savininkas = User::where('id', $files['user_id'])->first();
                return view('layouts.dokIkelimas')
                ->with('failai', $result)
                ->with('docId', $id)
                ->with('skelbimas', $post);
//                ->with('savininkas', $savininkas);
            }else
            {
                $result = $files->get()->toArray();
                //$savininkas = User::where('id', $files['user_id'])->first();
                return view('layouts.dokIkelimas')
                ->with('failai', $result)
                ->with('docId', $id)
                ->with('skelbimas', $post);
//                ->with('savininkas', $savininkas);
            }
    }
    public function postDokIkelimas(Request $request)
    {
        $user = Auth::user();
        if($request->file('dokumentas') != null)
        {

            $post = Post::find(intval($request->input('post_id')));

            $path = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/".$request->file('dokumentas')->store('dokumentai');
            //Local testing
            //$path = $request->file('dokumentas')->store('dokumentai');

            $file = new File();
            $file->path = $path;
            $file->name = $request->input('name');
            $file->statusas = 'nepatvirtinta';
            $file->user_id = $user->id;

            $post->files()->save($file);
            $files = File::where('post_id', $post->id);


            $result = $files->get()->toArray();


                return redirect()->route('layouts.dokIkelimas', ['docId' => $post->id])->with('info', 'Dokumentas sėkmingai įkeltas');
        }
        return redirect()->back()->with('info', 'Įvyko nenumatyta klaida');
    }

    public function postDeleteDok(Request $request)
    {
        $user = Auth::user();

        $file = File::find(intval($request->input('id')));
        $post = Post::find(intval($request->input('post_id')));
        if(!empty($file))
        {
            //$prefix = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/";
            //$delPath = str_replace($prefix, "", $file->path);
            $delPath = $file->path;
            Storage::delete($delPath);

            $file->delete();

            $files = File::where('post_id', $post->id);

                $result = $files->get()->toArray();


           return redirect()->route('layouts.dokIkelimas', ['docId' => $post->id])->with('info', 'Dokumentas sėkmingai ištrintas');
        }
        return redirect()->back()->with('info', 'Įvyko nenumatyta klaida');
    }
    public function postStatDok(Request $request)
    {
        $user = Auth::user();

            $file = File::find(intval($request->input('dokumentoId')));

            if(!empty($file))
            {
                if(strcmp((string)$request->input('statusas'), "patvirtinta") == 0)
                {
                    $file->statusas = "patvirtinta";
                    $file->save();
                    return redirect()->back()->with('info', 'Dokumentas sėkmingai patvirtintas');
                }else if(strcmp((string)$request->input('statusas'), "atmesta") == 0)
                {
                    $file->statusas = "atmesta";
                    $file->save();
                    return redirect()->back()->with('info', 'Dokumentas sėkmingai atmestas');
                }
            }

        return redirect()->back()->with('info', 'Įvyko nenumatyta klaida');
    }
    public function getNuotraukuIkelimas($id)
    {
        $user = Auth::user();

        $photo = Photo::where('post_id', $id);
        $post = Post::where('id', $id)->first();
        $nuominName = User::where('id', $post['nuomin_id'])->first();
        //return $nuominName;
        if($photo->get()->isNotEmpty())
        {
            $result = $photo->get()->toArray();
            return view('layouts.nuotraukuIkelimas')
                ->with('nuotraukos', $result)
                ->with('photoId', $id)
                ->with('skelbimas', $post)
                ->with('nuominName', $nuominName);
        }else
        {
            $result = $photo->get()->toArray();
            return view('layouts.nuotraukuIkelimas')
                ->with('nuotraukos', $result)
                ->with('photoId', $id)
                ->with('skelbimas', $post)
                ->with('nuominName', $nuominName);
        }
    }

    public function postStatNuotrauka(Request $request)
    {
        $user = Auth::user();

        $photo = Photo::find(intval($request->input('photoId')));
//        if(!empty($file))
//        {
            if(strcmp((string)$request->input('statusas'), "patvirtinta") == 0)
            {

                $photo->statusas = "patvirtinta";
                $photo->save();
                return redirect()->back()->with('info', 'Nuotrauka sėkmingai patvirtinta');
            }else if(strcmp((string)$request->input('statusas'), "atmesta") == 0)
            {

                $photo->statusas = "atmesta";
                $photo->save();
                return redirect()->back()->with('info', 'Nuotrauka atmesta');
            }
//        }
//        return redirect()->back()->with('info', 'Nepavyko');
    }
    public function postDeleteNuotrauka(Request $request)
    {
        $user = Auth::user();

        $photo = Photo::find(intval($request->input('id')));
        $post = Post::find(intval($request->input('post_id')));
        if(!empty($photo))
        {
            //$prefix = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/";
            //$delPath = str_replace($prefix, "", $file->path);
            $delPath = $photo->path;
            Storage::delete($delPath);

            $photo->delete();

            $photos = Photo::where('post_id', $post->id);

            $result = $photos->get()->toArray();


            return redirect()->route('layouts.nuotraukuIkelimas', ['photoId' => $post->id])->with('info', 'Nuotrauka ištrinta');
        }
        return redirect()->back()->with('info', 'Įvyko nenumatyta klaida');
    }
    public function postIkeltNuot(Request $request)
    {
        $user = Auth::user();
        if($request->file('nuotrauka') != null)
        {
            $post = Post::find(intval($request->input('post_id')));

            $path = "http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/".$request->file('nuotrauka')->store('nuotraukos');
            //Local testing
            //$path = $request->file('nuotrauka')->store('nuotraukos');
            $photo = new Photo();
            $photo->path = $path;
            $photo->statusas = 'nepatvirtinta';

            $post->photos()->save($photo);

            $photo = Photo::where('post_id', $post->id);
            $result = $photo->get()->toArray();
            //$result[count($result)]=$photo;
            return redirect()->route('layouts.nuotraukuIkelimas', ['photoId' => $post->id]);

        }
        return redirect()->back();
    }






    public function getSlaptKeitimas()
    {
        return view('layouts.slaptKeitimas');
    }
    public function getObjektuPerziura()
    {
        return view('layouts.objPerziura');
    }
    public function getNuomosIstorija()
    {
        return view('layouts.nuomosIstorija');
    }
    public function getGrafikoKeitimas(Request $request, $id)
    {
        $savaite = $request->query('savaite');
        $post = Post::find($id);
        $user = Auth::user()->find($id);
        $dayArray = array("Pirmadienis", "Antradienis", "Trečiadienis", "Ketvirtadienis", "Penktadienis", "Šeštadienis", "Sekmadienis");
        $graphs = Graph::where('user_id', $id)->where('statusas', 'laisva')->where('savaitesNr', $savaite)->get();

//        //return $graphs;
//        if($graphs->isEmpty())
//        {
//
//            return redirect()->back();
//        }else
//        {
            $graphs= $graphs->toArray();
            //return $graphs;
            return view('layouts.grafikoKeitimas', ['grafikas' => $graphs], ['dayArray' => $dayArray])->with('savaite', $savaite);
//        }
    }

    public function postGrafikas(Request $request, $id)
    {
        $array = $request->all();
        /** @param \Illuminate\Database\Eloquent\Builder $graphs  */
        $graphs = Graph::where('user_id', $id)->where('statusas', 'laisva');
        $insertList = [];
        if(!isset($array['data']))
            return ['success'];

        foreach($array['data'] as $graphCl){
            $graph = [
                'diena' => $graphCl['diena'],
                'laikas' => $graphCl['laikas'],
                'savaitesNr' => $graphCl['savaite'],
                'statusas' => 'laisva',
                'user_id' => $id,
                'nuomin_id' => 0,
                'post_id' => 0,
                'komentaras' => ''
            ];

            /** @param \App\Graph $graphDb  */
            $graphDb = $graphs->where([
                'diena' => $graph['diena'],
                'laikas' => $graph['laikas'],
                'savaitesNr' => $graph['savaitesNr']
            ])->first();

            if ($graphDb == null && $graphCl['create'] == 'true'){
                array_push($insertList, $graph);
            }
            if ($graphDb != null && $graphCl['create'] == 'false') {
                $graphDb->delete();
            }
        }
        if(count($insertList) > 0) {
            Graph::insert($insertList);
        }
        return ["success"];
    }
    public function duplicateWeekForAll(Request $request, $id) {
        $savaite = $request->input('savaite');

        $insertList = [];
        $weekGraphs = Graph::where('user_id', $id)
            ->where('statusas', 'laisva')
            ->where('savaitesNr', $savaite)
            ->get();
        for ($i=1; $i<=52; $i++) {
            foreach ($weekGraphs as $template) {
                $week = $template->getOriginal();
                unset($week['id']);
                $week['savaitesNr'] = $i;
                array_push($insertList, $week);

            }
        }
        Graph::where('user_id', $id)
            ->delete();

        Graph::insert($insertList);
    }

    public function getPaliktiAtsiliepimaVart($id)
    {
        $user=User::find($id);
       return view('layouts.rasytiAtsiliepimaApieVart')
           ->with('user', $user);
    }
    public function getPaliktiAtsiliepimaObj($id)
    {
        $post=Post::find($id);
        return view('layouts.rasytiAtsiliepimaApieObjekta')
            ->with('post', $post);
    }

    public function getSask()
    {
        return view('layouts.sask');
    }
    public function getPaieska()
    {
        return view('layouts.paieska');
    }
    public function getInfo()
    {
        return phpinfo();
    }

}
