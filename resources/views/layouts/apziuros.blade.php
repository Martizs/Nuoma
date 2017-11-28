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
        @if($patvirtintis->isEmpty())
            <div class="text-center">
                <h2>Patvirtintų apžiūrų šiam objektui nėra</h2>
            </div>
            <a class="btn btn-warning pull-right" href="{{route('layouts.manoSkelbimai')}}">Atgal</a>
        @else
            @foreach($patvirtintis as $patvirtinti)
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
                        <td><a class="btn btn-primary" href="{{ route('layouts.atsiliepimaiApieNuomininka', ['id' => $patvirtinti['nuomin_id']]) }}">Apie Nuomininką</a></td>
                        <td>{{$patvirtinti['savaitesNr']}}</td>
                        <td>{{$dayArray[$patvirtinti['diena']]}}</td>
                        <td>{{$patvirtinti['laikas']}}</td>
                        <td><button class="btn btn-danger btn-block">Atmesti</button>
                            <form action="{{ route('layouts.apziurosPost', ['id' => $patvirtinti['post_id']]) }}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="nuomin_id" value="{{ $patvirtinti['nuomin_id'] }}">
                                <input type="hidden" name="post_id" value="{{ $patvirtinti['post_id'] }}">
                                {{ csrf_field() }}
                                <button class="btn btn-success btn-block">Išnuomotį</button>
                            </form>
                        </td>
                    </tr>
                    </tbody>
                </table>
            @endforeach
        @endif
    </div>
@endsection