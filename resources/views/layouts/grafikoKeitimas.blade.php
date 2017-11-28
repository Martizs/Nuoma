@extends('layouts.master')
@section('content')

    <div class="container-fluid">

        <script>
            $( function() {
               $('#savaite').on('change', function(event){
                   window.location='{{ route('layouts.grafikoKeitimas', ['id' => Auth::user()->id] ) }}?savaite='+event.target.value;
            })
            });
        </script>
        <br>
        @if(Session::has('info'))
            <div class="row">
                <div class="col-md-12">
                    <p class="alert alert-info">{{ Session::get('info') }}</p>
                </div>
            </div>
        @endif
        <label for="savaite">Savaitė:</label>
        <select id="savaite" value="{{$savaite}}">
            <option value="default" selected="selected" disabled>Pasirinkite savaitę</option>
            @for($i=0; $i < 52; $i++)
                <option id="{{$i+1}}" value="{{$i+1}}" {{$savaite == $i+1 ? "selected":""}}>{{$i+1}}</option>
            @endfor
        </select>
        @if(isset($savaite))
            @include('includes.grafikoTable')
        @endif
    </div>
@endsection