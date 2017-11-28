@extends('layouts.master')

@section('content')
    <div class="quote">
        <div class="title m-b-md">
            Grafikas
        </div>
    </div>
    @if(\Illuminate\Support\Facades\Session::has('info'))
        <div class="row">
            <div class="col-md-12">
                <p class="alert alert-info">{{\Illuminate\Support\Facades\Session::get('info')}}</p>
            </div>
        </div>
    @endif
    @if($graph != null)
    <div class="row">
        <div>
        <label>Sudarytas grafikas</label>
        </div>
        <label for="content">Pirmadienis</label>
        <p>{{$graph->pirmadienis}}</p>
        <label for="content">Antradienis</label>
        <p>{{$graph->antradienis}}</p>
        <label for="content">Trečiadienis</label>
        <p>{{$graph->treciadienis}}</p>
        <label for="content">Ketvirtadienis</label>
        <p>{{$graph->ketvirtadienis}}</p>
        <label for="content">Penktadienis</label>
        <p>{{$graph->penktadienis}}</p>
        <label for="content">Šeštadienis</label>
        <p>{{$graph->sestadienis}}</p>
        <label for="content">Sekmadienis</label>
        <p>{{$graph->sekmadienis}}</p>
    </div>
    @else
        <p>Nėra grafiko</p>
    @endif
    <hr>
    <div>
        <form action="{{ route('layouts.pildytGrafika') }}" method="get">
            <button type="submit" class="btn btn-primary">Tvarkyti grafiką</button>
        </form>
    </div>
@endsection