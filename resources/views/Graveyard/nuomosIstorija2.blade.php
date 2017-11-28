@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row text-center page-header">
            <h1>Nuomos Istorija</h1>

        </div>
        <div class="panel panel-default col-md-12">
            <div class="panel-body col-md-6">
                <div class="row text-center page-header">
                    <h4>Išsinuomoti Objektai</h4>
                </div>
                @for($i=0;$i<3;$i++)
                    @if(true)
                        <div class="row">
                            <div class="panel-body col-md-6">
                                <div>
                                    <img class="img-thumbnail" src="{{ URL::to('logo/Nams.jpg') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5>Adresas:</h5>
                                <h5>Nuomotojas:</h5>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                            </div>
                            <a class="btn btn-success right"href="{{route('layouts.rasytiAtsiliepima')}}">Palikti Atsiliepimą</a>
                        </div>
                    @else
                        <div class="text-center">
                            <br><br>
                            <h2>Išnuomotų objektų nėra</h2>
                            <br><br>
                        </div>
                    @endif
                @endfor
            </div>
            <div class="panel-body col-md-6">
                <div class="row text-center page-header">
                    <h4>Išnuomoti Objektai</h4></div>
                @for($i=0;$i<3;$i++)
                    @if(true)
                        <div class="row">
                            <div class="panel-body col-md-6">
                                <div>
                                    <img class="img-thumbnail" src="{{ URL::to('logo/Nams.jpg') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5>Adresas:</h5>
                                <h5>Nuomininkas:</h5>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                            </div>
                            <a class="btn btn-success right"href="{{route('layouts.rasytiAtsiliepima')}}">Palikti Atsiliepimą</a>
                        </div>
                    @else
                        <div class="text-center">
                            <br><br>
                            <h2>Išnuomotų objektų nėra</h2>
                            <br><br>
                        </div>
                    @endif
                @endfor
            </div>
        </div>


    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
@endsection