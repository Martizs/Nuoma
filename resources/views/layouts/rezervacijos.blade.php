@extends('layouts.master')
@section('content')
<div class="container">
    @if(Session::has('info'))
        <div class="row">
            <div class="col-md-12">
                <p class="alert alert-info">{{ Session::get('info') }}</p>
            </div>
        </div>
    @endif
    @if($rezervas->isEmpty())
        <div class="text-center">
            <h2>Rezervacijų šiam objektui nėra</h2>
        </div>
        <a class="btn btn-warning pull-right" href="{{route('layouts.manoSkelbimai')}}">Atgal</a>
    @else
    @foreach($rezervas as $rezerva)
        <table class="table table-responsive">
            <thead>
            <th>Nuomininko Vardas:</th>
            <th>Savaitės Nr:</th>
            <th>Diena:</th>
            <th>Laikas:</th>
            <th></th>
            </thead>
            <tbody>
            <tr>
                <td><a class="btn btn-primary" href="{{ route('layouts.atsiliepimaiApieNuomininka', ['id' => $rezerva['nuomin_id']]) }}">Apie Nuomininką</a></td>
                <td>{{$rezerva['savaitesNr']}}</td>
                <td>{{$rezerva['laikas']}}</td>
                <td>{{$dayArray[$rezerva['diena']]}}</td>
                <td>
                    <form action="{{ route('layouts.rezervacijosAtmestiPost', ['id' => $rezerva['post_id']]) }}" method="post" enctype="multipart/form-data">
                    <textarea id="komentaras" name="komentaras" type="form-control" rows="2" placeholder="Komentaras kodėl atmetate"></textarea>
                        <input type="hidden" name="id" value="{{ $rezerva['id'] }}">
                        {{ csrf_field() }}
                    <button class="btn btn-danger btn-block" type="submit" >Atmesti</button>
                    </form>
                </td>
                <td>
                    <form action="{{ route('layouts.rezervacijosPost', ['id' => $rezerva['post_id']]) }}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="{{ $rezerva['id'] }}">
                        {{ csrf_field() }}
                    <button class="btn btn-success btn-block" type="submit">Patvirtinti rezervaciją</button>
                    </form>
                </td>

            </tr>
            </tbody>
        </table>
    @endforeach
    @endif
</div>
@endsection