@extends('layouts.master')

@section('content')
    <div class="quote">
        <div class="title m-b-md">
            Jus nuomininkas - Iveskite paieskos kriterijus
        </div>
    </div>
    <form action="{{ route('layouts.search') }}" method="post">
        <div class="form-group">
            <label  class="spaaaaaace">Pavadinimas</label>  <label class="spaaaaaace" >Vieta</label>
        </div>
        <div class="form-group">
            <input type="text" class="little-box" id="pavadinimas" name="pavadinimas">  <input type="text" class="little-box" id="vieta" name="vieta">
        </div>
        <div class="form-group">
            <label  class="spaaaaaace">Kaina Nuo</label>    <label class="spaaaaaace">Kaina Iki</label>
        </div>
        <div class="form-group">
            <input class="little-box" type="number" id="kainaN" name="kainaN">  <input class="little-box" type="number"id="kainaI" name="kainaI">
        </div>
        {{ csrf_field() }}
        <button type="submit" class="btn btn-primary">Ieškoti</button>
    </form>

    <div class="container">
        @yield('search')
    </div>

@endsection