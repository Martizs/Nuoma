<div class="container">
    @if(Session::has('info'))
        <div class="row">
            <div class="col-md-12">
                <p class="alert alert-info">{{ Session::get('info') }}</p>
            </div>
        </div>
    @endif
    <div class="row text-center">
        <h2><strong>Naujausi Skelbimai</strong></h2>
    </div>
    <div class="row row-eq">
        <div class="col-md-12">
            @if(count($postsNauj)==0)
                <h1 class="text-center">Skelbimų nėra</h1>
                @else
            @if(count($postsNauj)<3)
            @for($i=0; $i <count($postsNauj); $i++)
                <div class="panel panel-default col-md-4">
                    <div class="panel-body block">
                        <a href="{{ route('layouts.skelbimoPerziura', ['id' => $postsNauj[$i]['post_id']]) }}"><img class="img-thumbnail imageHeight"  src="{{ $photoNauj[$i] }}"></a>
                        <ul>
                            <strong><li style="list-style-type: none">Miestas: {{$postsNauj[$i]['savivaldybe']}}</li></strong>
                            <strong><li style="list-style-type: none">Tipas: {{$postsNauj[$i]['pastatoTip']}}</li></strong>
                            <strong><li style="list-style-type: none">Kaina: {{$postsNauj[$i]['kaina']}} Eur</li></strong>
                        </ul>
                    </div>
                </div>
            @endfor
            @else
                @for($i=0; $i <3; $i++)
                    <div class="panel panel-default col-md-4">
                        <div class="panel-body block">
                            <a href="{{ route('layouts.skelbimoPerziura', ['id' => $postsNauj[$i]['post_id']]) }}"><img class="img-thumbnail imageHeight"  src="{{ $photoNauj[$i] }}"></a>
                            <ul>
                                <strong><li style="list-style-type: none">Miestas: {{$postsNauj[$i]['savivaldybe']}}</li></strong>
                                <strong><li style="list-style-type: none">Tipas: {{$postsNauj[$i]['pastatoTip']}}</li></strong>
                                <strong><li style="list-style-type: none">Kaina: {{$postsNauj[$i]['kaina']}} Eur</li></strong>
                            </ul>
                        </div>
                    </div>
                @endfor
            @endif
            @endif
        </div>
    </div>
</div>