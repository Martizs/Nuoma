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
        <table class="table table-bordered">
            <thead>
            <th><h3>Nuotrauka</h3></th>
            <th><h3>Statusas</h3></th>
            </thead>
            <tbody>

            @if(count($nuotraukos)>0)
                @for($i=0;$i<count($nuotraukos);$i++)
                    @if($nuotraukos[$i]['statusas']!='pagrindine' && $nuotraukos[$i]['statusas']!='paprasta')
                    <tr>
                        <td class="col-md-4"><a href="{{ $nuotraukos[$i]['path']}}"><img class="img-responsive"src="{{ $nuotraukos[$i]['path']}}"></a>
                            <form action="{{ route('layouts.nuotraukosTrinimas', $nuotraukos[$i] ) }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="post_id" value="{{ $photoId }}">
                                @if($skelbimas['user_id'] == Auth::user()->id)
                                @else
                                <button class="btn btn-danger glyphicon glyphicon-remove-circle" name="id" value="{{ $nuotraukos[$i]['id'] }}">Ištrinti</button>
                                    @endif
                            </form>
                        </td>

                        @if($skelbimas['user_id'] == Auth::user()->id)
                        <td class="col-md-6 text-center">
                            @if($nuotraukos[$i]['statusas']=='nepatvirtinta')
                            <form action="{{ route('layouts.nuotraukuStatusoKeitimas') }}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="photoId" value="{{ $nuotraukos[$i]['id'] }}">
                                <input type="hidden" name="statusas" value="patvirtinta">
                                {{ csrf_field() }}
                                <button class="btn btn-success btn-block" type="submit">Patvirtinti</button>
                            </form>
                            <form action="{{ route('layouts.nuotraukuStatusoKeitimas') }}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="photoId" value="{{ $nuotraukos[$i]['id'] }}">
                                <input type="hidden" name="statusas" value="atmesta">
                                {{ csrf_field() }}
                                <button class="btn btn-danger btn-block" type="submit">Atmesti</button>
                            </form>
                            @else
                                <h3>{{$nuotraukos[$i]['statusas']}}</h3>
                            @endif
                        </td>
                        @else
                        <td class="col-md-6 text-center">
                            @if($nuotraukos[$i]['statusas']=='nepatvirtinta')
                            <p class="glyphicon glyphicon-refresh" ></p>Laukiama Patvirtinimo
                            @else
                                <h3>{{$nuotraukos[$i]['statusas']}}</h3>
                            @endif
                        </td>
                        @endif

                    </tr>
                    @endif
                @endfor
            @endif

            </tbody>
        </table>
        @if($skelbimas['user_id'] == Auth::user()->id)
        <div></div>
            @else
            <form action="{{ route('layouts.nuotraukuIkelimasPost') }}" method="post" enctype="multipart/form-data">
                <label for="nuotrauka" class="btn btn-primary">Pasirinkti Nuotrauką</label>
                <input type="file" id="nuotrauka" name="nuotrauka" style="visibility: hidden">
                <input type="hidden" name="post_id" value="{{ $photoId }}">
                {{ csrf_field() }}
                <button class="btn btn-success" type="submit">Įkelti</button>
            </form>
        @endif
    </div>
@endsection