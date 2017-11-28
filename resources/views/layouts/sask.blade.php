@extends('layouts.master')
@section('content')
    <br>
<div class="container">
    @if(Session::has('info'))
        <div class="row">
            <div class="col-md-12">
                <p class="alert alert-info">{{ Session::get('info') }}</p>
            </div>
        </div>
    @endif
    <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class="text-center">Sąskaitos</h4>
                    @if($skelbimas['user_id'] == Auth::user()->id)
                    <table class="table table-responsive">
                        <form action="{{ route('layouts.postSask') }}" method="post" enctype="multipart/form-data">
                        <thead>
                        <th class="col-md-2">Metai:
                            <select name="metai" id="metai" required autofocus>
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                            </select>
                        </th>
                        <th class="col-md-2">
                            <select name="menesis" id="menesis" required>
                                <option value="0">Sausis</option>
                                <option value="1">Vasaris</option>
                                <option value="2">Kovas</option>
                                <option value="3">Balandis</option>
                                <option value="4">Gegužė</option>
                                <option value="5">Birželis</option>
                                <option value="6">Liepa</option>
                                <option value="7">Rugpjūtis</option>
                                <option value="8">Rugsėjis</option>
                                <option value="9">Spalis</option>
                                <option value="10">Lapkritis</option>
                                <option value="11">Gruodis</option>
                            </select>
                        </th>
                        <th class="col-md-4">
                            <label for="dokumentas" class="btn btn-primary bottom-right">Pasirinkti Sąskaitą</label>
                            <input type="file" id="dokumentas" name="dokumentas" style="visibility: hidden;">
                            {{--<input type="text" name="name" placeholder="Įveskite failo pav." value="">--}}
                            <input type="hidden" name="post_id" value="{{ $postId }}">
                        </th>
                        <th class="col-md-2">
                            <input id="bendraSum" name="bendraSum" type="number" placeholder="Bendra sąskaitos suma" required>
                        </th>
                        <th class="col-md-2">
                            {{ csrf_field() }}
                            <button class="btn btn-success text-right" type="Submit">Pateikti</button>
                        </th>
                        </thead>
                    </form>
                    </table>
                    @endif
                    <table class="table table-responsive">
                        <thead>
                        <th>Laikotarpis</th>
                        <th>Suma</th>
                        <th>Statusas</th>
                        </thead>
                        <tbody>
                        @if(count($saskaitos)>0)
                        @for($i=0; $i<count($saskaitos); $i++)
                            <tr>
                                <td class="col-md-4">
                                    <a href="{{$saskaitos[$i]['path']}}">{{ $saskaitos[$i]['metai']}} {{  $saskaitos[$i]['menesis'] }}</a>
                                    @if($skelbimas['user_id'] == Auth::user()->id && $saskaitos[$i]['statusas'] == 'neapmokėta' )
                                    <form action="{{ route('layouts.postDeleteSas', $saskaitos[$i] ) }}" method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="id" value="{{ $postId }}">
                                        <button class="btn btn-danger glyphicon glyphicon-remove-circle" name="id" value="{{ $saskaitos[$i]['id'] }}">Ištrinti</button>
                                    </form>
                                    @endif
                                </td>
                                <td class="col-md-4">{{ $saskaitos[$i]['bendraSum']}}Eur</td>
                                @if($skelbimas['user_id'] == Auth::user()->id)
                                <td class="col-md-4">{{ $saskaitos[$i]['statusas']}}</td>
                                @else
                                    @if($saskaitos[$i]['statusas'] == 'neapmokėta')
                                        <td>
                                    <form action="{{ route('layouts.postSasStatusas') }}" method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="saskId" value="{{ $saskaitos[$i]['id'] }}">
                                        <button class="btn btn-success glyphicon glyphicon-ok" type="submit">Apmokėjau</button>
                                    </form>
                                        </td>
                                        @else
                                        <td class="col-md-4">{{ $saskaitos[$i]['statusas']}}</td>
                                        @endif

                                @endif
                            </tr>
                        @endfor
                        @else

                            <tr>
                                <td>
                                    <h3>Nėra įkeltų sąskaitų</h3>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
</div>



@endsection