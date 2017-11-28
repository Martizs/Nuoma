@extends('layouts.master')

@section('content')
    <br>
<div class="container">
    @if(Session::has('info'))
        <div class="row">
            <div class="col-md-12">
                <p class="alert alert-info">{{ Session::get('info') }}</p>
            </div>
        </div>
    @endif
    <div class="col-md-6 row text-center">
        <div class="panel panel-default">
            <div class="panel-body">
        {{--@if($post['patalpuTipas']=="Namas")--}}
            {{--<div>--}}
                {{--<img class="img-thumbnail imageHeight text-center"  src="{{ URL::to('logo/Nams.jpg') }}">--}}
            {{--</div>--}}
        {{--@else--}}
            {{--<div>--}}
                {{--<img class="img-thumbnail imageHeight text-center" src="{{ URL::to('logo/Buts.jpg') }}">--}}
            {{--</div>--}}
        {{--@endif--}}
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        @for($i=0; $i<count($paprastos); $i++)
                        <li data-target="#myCarousel" data-slide-to="{{$i+1}}"></li>
                        @endfor
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        @if($pagrindine!=null)
                        <div class="item active">
                            <img src="{{$pagrindine['path']}}" alt="none">
                        </div>
                        @else
                        <div class="item active">
                            <img src="http://marbar4.stud.if.ktu.lt/Nuoma2/storage/app/nuotraukos/nuotrauku_ner.png" alt="none">
                        </div>
                        @endif
                        @for($i=0; $i<count($paprastos); $i++)
                        <div class="item">
                            <img src="{{$paprastos[$i]['path']}}" alt="none">
                        </div>
                        @endfor
                    </div>

                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>

            <div class="row panel-body text-center">
                <h4>Atsiliepimai</h4>
                <a href="{{ route('layouts.atsiliepimaiApieNuomotoja', $nuomotojas->id) }}" class="btn btn-primary">Apie Nuomotoją</a>
                <a href="{{ route('layouts.atsiliepimaiApieObjekta', $post['id']) }}" class="btn btn-primary">Apie Objektą</a>
                <hr>
            </div>
            <div class="panel-body">
                @if($post['user_id'] == Auth::user()->id)
                <div class="col-md-6">
                    <form action="{{ route('layouts.skelbimoNuotIkelimas') }}" method="post" enctype="multipart/form-data">
                        <label for="nuotrauka" class="btn btn-primary">Pasirinkite Nuotrauka</label>
                        <input type="file" id="nuotrauka" name="nuotrauka" style="visibility: hidden">
                        <input type="hidden" name="post_id" value="{{ $post['id'] }}">
                        {{ csrf_field() }}
                        <button class="btn btn-success" type="submit">Įkelti</button>
                    </form>
                </div>
                @else
                    <div class="col-md-6">
                    </div>
                @endif
                <div class="col-md-6">
                    <ul class="list-unstyled">
                        <li>Nuomotojas: {{$nuomotojas['name']}}</li>
                        <li>Telefonas: {{ $nuomotojas['telefonas']  }}</li>
                    </ul>
                </div>
            </div>
            @if($post['user_id'] != Auth::user()->id)
            <div class="panel-body text-right">
                <a href="{{ route('layouts.rezervuoti', $post['id']) }}" class="btn btn-primary">Rezervuoti Apžiūrą</a>
            </div>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-responsive">
                    <h3>Objekto Duomenys</h3>
                    <tbody>
                    <tr>
                        <td>Savivaldybė:</td>
                        <td>{{$post['savivaldybe']}}</td>
                    </tr>
                    <tr>
                        <td>Gyvenvietė:</td>
                        <td>{{$post['gyvenviete']}}</td>
                    </tr>
                    <tr>
                        <td>Mikrorajonas:</td>
                        <td>{{$post['mikroRaj']}}</td>
                    </tr>
                    <tr>
                        <td>Gatvė:</td>
                        <td>{{$post['gatve']}}</td>
                    </tr>
                    <tr>
                        <td>Patalpų Tipas:</td>
                        <td>{{$post['patalpuTipas']}}</td>
                    </tr>
                    <tr>
                        <td>Plotas:</td>
                        <td>{{$post['plotas']}}</td>
                    </tr>
                    {{--<tr>--}}
                        {{--<td>Pastato Tipas:</td>--}}
                        {{--<td>{{$post ['pastatoTip']}}</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>Šildymo Tipas:</td>--}}
                        {{--<td>{{$post['sildymoTip']}}</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>Įrengimo Tipas:</td>--}}
                        {{--<td>{{$post['irengimoTip']}}</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        <td>Kaina:</td>
                        <td>{{$post['kaina']}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection