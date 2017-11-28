@extends('layouts.master')

@section('content')
    @if(Session::has('info'))
        <div class="row">
            <div class="col-md-12">
                <p class="alert alert-info">{{ Session::get('info') }}</p>
            </div>
        </div>
    @endif
    <div class="container">
        <div class="row text-center" >
            <div>
                <h1>Mano Paskyra</h1>
            </div>
        </div>
    </div>
    <div>

    </div>
    <div class="container">
        <div class="row" >
            <div>
                <ul class="col-md-offset-2" >
                    <li class="customPadding btn btn-primary col-md-3"><h4><a class="customButton" style="text-decoration: none; color: ghostwhite" href="{{ route('layouts.duomenuKeitimas') }}">Duomenų keitimas</a></h4></li>
                    <li class="customPadding btn btn-primary col-md-3"><h4><a class="customButton" style="text-decoration: none; color: ghostwhite" href="{{ route('layouts.slaptKeitimas') }}">Slaptažodžio keitimas</a></h4></li>
                    <li class="customPadding btn btn-primary col-md-3 "><h4><a class="customButton" style="text-decoration: none; color: ghostwhite" href="{{ route('layouts.grafikoKeitimas', ['id' => Auth::user()->id ]) }}">Apžiūrų grafikas</a></h4></li>
                </ul>
            </div>
        </div>
    </div>
@endsection