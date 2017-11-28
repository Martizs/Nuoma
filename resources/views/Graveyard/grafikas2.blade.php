@extends('layouts.master')
@section('content')
    @for($i=0; $i < 7; $i++)
        <div class="col-md-1">
    <label>Diena{{$i+1}}</label>
        @for($j=0; $j < 10; $j++)
        <div class="row">
            <div class="btn btn-default">Laikas</div>
        </div>
        @endfor
        </div>
    @endfor
@endsection