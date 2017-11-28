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
        <div class="row text-center"><h2>Mano Rezervacijos</h2></div>
        @if($rezervacijos->isEmpty())
            <div class="row text-center"><h3>Rezervacijų nėra</h3></div>
        @else
            <table class="table table-responsive">
                <th class="col-md-2">Savaitės Nr:</th>
                <th class="col-md-2">Diena:</th>
                <th class="col-md-2">Laikas:</th>
                <th class="col-md-2">Statusas:</th>
                <th class="col-md-2"></th>
                @foreach($rezervacijos as $rezervacijo)
                <tr>
                    <td>
                        {{$rezervacijo['savaitesNr']}}
                    </td>
                    <td>
                        {{$dayArray[$rezervacijo['diena']]}}
                    </td>
                    <td>
                        {{$rezervacijo['laikas']}}
                    </td>
                    <td>
                        {{$rezervacijo['statusas']}}
                    </td>
                    <td>
                        @if($rezervacijo['statusas'] == 'rezervuojama' or $rezervacijo['statusas'] == 'atmesta')
                        <form action="{{ route('layouts.atsauktiRezervacija') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="{{ $rezervacijo['id'] }}">
                            {{ csrf_field() }}
                        <button class="btn btn-danger" type="submit">Ištrinti</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>
        @endif
</div>
@endsection