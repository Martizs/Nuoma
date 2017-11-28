@extends('layouts.master')

@section('content')
<label class="label-info"> Į laukelius įveskite laiką tokiu formatu: 16:00-17:00 </label>
<label class="label-info">Jei norite įvesti daugiau nei viena laiką atskirkite juos taip: 16:00-17:00, 20:00-21:00</label>
<div class="little-box">
    <form action="{{ route('layouts.pildytGrafika') }}" method="post">
        <div class="little-box">
            <label for="title">Pirmadienis</label>
            <input type="text" class="little-box" id="pirmadienis" name="pirmadienis"
                   value="{{$graph->pirmadienis}}">
        </div>
        <div class="little-box">
            <label for="content">Antradienis</label>
            <input type="text" class="little-box" id="antradienis" name="antradienis"
                   value="{{$graph->antradienis}}">
        </div>
        <div class="little-box">
            <label for="content">Trečiadienis</label>
            <input type="text" class="little-box" id="treciadienis" name="treciadienis"
                   value="{{$graph->treciadienis}}">
        </div>
        <div class="little-box">
            <label for="content">Ketvirtadienis</label>
            <input type="text" class="little-box" id="ketvirtadienis" name="ketvirtadienis"
                   value="{{$graph->ketvirtadienis}}">
        </div>
        <div class="little-box">
            <label for="content">Penktadienis</label>
            <input type="text" class="little-box" id="penktadienis" name="penktadienis"
                   value="{{$graph->penktadienis}}">
        </div>
        <div class="little-box">
            <label for="content">Šeštadienis</label>
            <input type="text" class="little-box" id="sestadienis" name="sestadienis"
                   value="{{$graph->sestadienis}}">
        </div>
        <div class="little-box">
            <label for="content">Sekmadienis</label>
            <input type="text" class="little-box" id="sekmadienis" name="sekmadienis"
                   value="{{$graph->sekmadienis}}">
        </div>
        {{ csrf_field() }}
        <button type="submit" class="btn btn-primary">Išsaugoti</button>

    </form>
    <hr>
</div>
@endsection