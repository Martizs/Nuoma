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
            <th><h3>Dokumentas</h3></th>
            {{--<th><h3>Įkėlęs asmuo</h3></th>--}}
            <th><h3>Statusas</h3></th>
            </thead>
            <tbody>

            @if(count($failai)>0)
                @for($i=0;$i<count($failai);$i++)
                    <tr>
                        <td class="col-md-6"><a href="{{$failai[$i]['path']}}">{{$failai[$i]['name']}}</a>
                            <form action="{{ route('layouts.dokTrinimas', $failai[$i] ) }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="post_id" value="{{ $docId }}">
                                @if($failai[$i]['user_id'] == Auth::user()->id && $failai[$i]['statusas'] != 'patvirtinta' )
                                    <button class="btn btn-danger glyphicon glyphicon-remove-circle" name="id" value="{{ $failai[$i]['id'] }}">Ištrinti</button>
                                @endif
                            </form>
                        </td>
                        {{--<td class="col-md-4 text-center">{{$savininkas['name']}}</td>--}}

                        @if($failai[$i]['user_id'] != Auth::user()->id)
                            <td class="col-md-6 text-center">
                                @if($failai[$i]['statusas']=='nepatvirtinta')
                                    <form action="{{ route('layouts.dokumentuStatusoKeitimas') }}" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="dokumentoId" value="{{ $failai[$i]['id'] }}">
                                        <input type="hidden" name="statusas" value="patvirtinta">
                                        {{ csrf_field() }}
                                        <button class="btn btn-success btn-block" type="submit">Patvirtinti</button>
                                    </form>
                                    <form action="{{ route('layouts.dokumentuStatusoKeitimas') }}" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="dokumentoId" value="{{ $failai[$i]['id'] }}">
                                        <input type="hidden" name="statusas" value="atmesta">
                                        {{ csrf_field() }}
                                        <button class="btn btn-danger btn-block" type="submit">Atmesti</button>
                                    </form>
                                @else
                                    <h3>{{$failai[$i]['statusas']}}</h3>
                                @endif
                            </td>
                        @else
                            <td class="col-md-4 text-center">
                                @if($failai[$i]['statusas']=='nepatvirtinta')
                                    <p class="glyphicon glyphicon-refresh" ></p>Laukiama Patvirtinimo
                                @else
                                    <h3>{{$failai[$i]['statusas']}}</h3>
                                @endif
                            </td>
                        @endif

                    </tr>
                @endfor
            @endif

            </tbody>
        </table>
            <form action="{{ route('layouts.dokIkelimasPost') }}" method="post" enctype="multipart/form-data">
                <label for="doc" class="btn btn-primary">Pasirinkti failą</label>
                <input type="file" id="doc" name="dokumentas" style="visibility: hidden">
                <input type="text" name="name" placeholder="Įveskite failo pav." value="" required>
                <input type="hidden" name="post_id" value="{{ $docId }}">
                {{ csrf_field() }}
                <button class="btn btn-success" type="submit">Įkelti</button>
            </form>
    </div>
@endsection
