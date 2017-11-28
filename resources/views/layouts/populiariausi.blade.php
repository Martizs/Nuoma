<div class="container">
    @if(Session::has('info'))
        <div class="row">
            <div class="col-md-12">
                <p class="alert alert-info">{{ Session::get('info') }}</p>
            </div>
        </div>
    @endif
    <div class="row text-center">
        <h2><strong>Populiariausi Skelbimai</strong></h2>
    </div>
    <div class="row">
        <div class="col-md-12">
            @if(count($postsPop)==0)
                <h1 class="text-center">Skelbimų nėra</h1>
            @else

            @if(count($postsPop)<3)
            @for($i=0; $i <count($postsPop); $i++)
            <div class="panel panel-default col-md-4">
                <div class="panel-body">
                    <a href="{{ route('layouts.skelbimoPerziura', ['id' => $postsPop[$i]['post_id']]) }}"><img class="img-thumbnail imageHeight"  src="{{ $photoPop[$i] }}"></a>
                    <ul>
                        <strong><li style="list-style-type: none">Miestas: {{$postsPop[$i]['savivaldybe']}}</li></strong>
                        <strong><li style="list-style-type: none">Tipas: {{$postsPop[$i]['patalpuTipas']}}</li></strong>
                        <strong><li style="list-style-type: none">Kaina: {{$postsPop[$i]['kaina']}} Eur</li></strong>
                    </ul>
                </div>
            </div>
            @endfor
            @else
                @for($i=0; $i <3; $i++)
                    <div class="panel panel-default col-md-4">
                        <div class="panel-body">
                            <a href="{{ route('layouts.skelbimoPerziura', ['id' => $postsPop[$i]['post_id']]) }}"><img class="img-thumbnail imageHeight"  src="{{ $photoPop[$i] }}"></a>
                            <ul>
                                <strong><li style="list-style-type: none">Miestas: {{$postsPop[$i]['savivaldybe']}}</li></strong>
                                <strong><li style="list-style-type: none">Tipas: {{$postsPop[$i]['patalpuTipas']}}</li></strong>
                                <strong><li style="list-style-type: none">Kaina: {{$postsPop[$i]['kaina']}} Eur</li></strong>
                            </ul>
                        </div>
                    </div>
                @endfor
            @endif
            @endif
        </div>
    </div>
</div>
