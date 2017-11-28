@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <hr>
            <p class="quote">Jus esate nuomotojas</p>
        </div>
        @if(\Illuminate\Support\Facades\Session::has('info'))
            <div class="row">
                <div class="col-md-12">
                    <p class="alert alert-info">{{\Illuminate\Support\Facades\Session::get('info')}}</p>
                </div>
            </div>
        @endif
        <div>
            <form action="{{ route('layouts.skelbimas') }}" method="get">
                <button type="submit" class="btn btn-primary">Ideti skelbimą</button>
            </form>
        </div>
        <hr>
        <div>
            <form action="{{ route('layouts.skelbimai') }}" method="get">
                <button type="submit" class="btn btn-primary">Perziureti savo skelbimus</button>
            </form>
        </div>
        <hr>
        <div>
            <form action="{{ route('layouts.grafikas') }}" method="get">
                <button type="submit" class="btn btn-primary">Susitikimų grafikas</button>
            </form>
        </div>
    </div>
@endsection