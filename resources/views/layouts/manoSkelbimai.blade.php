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
    @if(Session::has('infoBad'))
            <div class="row">
                <div class="col-md-12">
                    <p class="alert alert-danger">{{ Session::get('infoBad') }}</p>
                </div>
            </div>
    @endif
    <div class="panel panel-default col-md-12">
        <div class="panel-body col-md-12">
            <table class="table table-responsive">
                <th class="col-md-4 pull-left"><a class="btn btn-primary" href="{{ route('layouts.manoRezervacijos', ['id' => Auth::user()['id']] ) }}">Rezervacijos</a></th>
                <th class="col-md-4 text-center"><h2>Mano Skelbimai</h2></th>
                <th class="col-md-4 text-center"></th>
                <tbody>
                @if(count($manoSkelbimai)==0)
                    <tr>
                        <td class="col-md-4">
                        </td>
                        <td class="col-md-4">
                            <div class="text-center">
                                <h2>Aktyvių skelbimų nėra</h2>
                            </div>
                        </td>
                        <td class="col-md-4">
                        </td>
                    </tr>
                @else
                @for($i = 0; $i < count($manoSkelbimai); $i++)
                <tr>
                    <td>
                        <div>
                            <a href="{{ route('layouts.skelbimoPerziura', ['id' => $manoSkelbimai[$i]['post_id']]) }}"><img class="img-thumbnail imageHeight"  src="{{ $nuotrauka[$i] }}"></a>
                        </div>
                    </td>
                    <td>
                        <table class="table table-responsive">
                            <tbody>
                            <tr>
                                <td>Savivaldybė:</td>
                                <td>{{$manoSkelbimai[$i]['savivaldybe']}}</td>
                            </tr>
                            <tr>
                                <td>Gyvenvietė:</td>
                                <td>{{$manoSkelbimai[$i]['gyvenviete']}}</td>
                            </tr>
                            <tr>
                                <td>Mikrorajonas:</td>
                                <td>{{$manoSkelbimai[$i]['mikroRaj']}}</td>
                            </tr>
                            <tr>
                                <td>Gatvė:</td>
                                <td>{{$manoSkelbimai[$i]['gatve']}}</td>
                            </tr>
                            <tr>
                                <td>Namo Numeris:</td>
                                <td>{{$manoSkelbimai[$i]['namoNr']}}</td>
                            </tr>
                            <tr>
                                <td>Patalpų Tipas:</td>
                                <td>{{$manoSkelbimai[$i]['patalpuTipas']}}</td>
                            </tr>
                            <tr>
                                <td>Plotas:</td>
                                <td>{{$manoSkelbimai[$i]['plotas']}}</td>
                            </tr>
                            <tr>
                                <td>Kaina:</td>
                                <td>{{$manoSkelbimai[$i]['kaina']}}€</td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                    <td>
                        <a class="btn btn-success right btn-block" href="{{route('layouts.skelbimoPerziura', ['id' => $manoSkelbimai[$i]['post_id']])}}">Peržiūrėti Skelbimą</a>
                        <a class="btn btn-warning right btn-block" href="{{route('layouts.rezervacijos', ['id' => $manoSkelbimai[$i]['post_id']])}}">Peržiūrėti rezervacijas</a>
                        <a class="btn btn-info right btn-block" href="{{route('layouts.apziuros', ['id' => $manoSkelbimai[$i]['post_id']])}}">Atmesti/išnuomoti</a>
                        <form action="{{ route('layouts.postIstrintiSkelbima', ['id' => $manoSkelbimai[$i]['post_id']]) }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="post_id" value="{{ $manoSkelbimai[$i]['post_id'] }}">
                            {{ csrf_field() }}
                            <button class="btn btn-danger btn-block" type="submit" >Ištrinti skelbimą</button>
                        </form>
                    </td>
                </tr>
                @endfor
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection