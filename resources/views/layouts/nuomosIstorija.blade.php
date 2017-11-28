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
        <div class="panel panel-default col-md-12">
            <div class="panel-body col-md-12">
                <table class="table table-responsive">
                    <div class="text-center"><h2>Mano patalpų nuomos istorija</h2></div>
                    <tbody>
                    @if(count($nuomosIstorija)==0)
                        <tr>
                            <td>
                                <div class="text-center">
                                    <h2>Jūs neturite pasibaigusių skelbimų</h2>
                                </div>
                            </td>
                        </tr>
                    @else
                        @for($i = 0; $i < count($nuomosIstorija); $i++)
                            <tr>
                                <td class="col-md-4">
                                        <div>
                                            <img class="img-thumbnail" src="{{ $nuomosIstorija[$i]['nuot_path'] }}">
                                        </div>
                                </td>
                                <td class="col-md-5">
                                    <table class="table table-responsive">
                                        <tbody>
                                        <tr>
                                            <td>Savivaldybė:</td>
                                            <td>{{$nuomosIstorija[$i]['savivaldybe']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Gyvenvietė:</td>
                                            <td>{{$nuomosIstorija[$i]['gyvenviete']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Mikrorajonas:</td>
                                            <td>{{$nuomosIstorija[$i]['mikroRaj']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Gatvė:</td>
                                            <td>{{$nuomosIstorija[$i]['gatve']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Patalpų Tipas:</td>
                                            <td>{{$nuomosIstorija[$i]['patalpuTipas']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Plotas:</td>
                                            <td>{{$nuomosIstorija[$i]['plotas']}}</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </td>
                                <td class="col-md-3">
                                    <h4>Atsiliepimai apie:</h4>
                                    @if($nuomosIstorija[$i]['user_id'] == Auth::user()->id)
                                    <a class="btn btn-success btn-block"href="{{ route('layouts.rasytiAtsiliepimaApieVart', ['id' => $nuomosIstorija[$i]['nuomin_id']]) }}" >Nuomininką</a>
                                    @else
                                    <a class="btn btn-success btn-block"href="{{ route('layouts.rasytiAtsiliepimaApieVart', ['id' => $nuomosIstorija[$i]['user_id']]) }}" >Nuomotoja</a>
                                    <a class="btn btn-success btn-block"href="{{ route('layouts.rasytiAtsiliepimaApieObjekta', ['id' => $nuomosIstorija[$i]['id']]) }}" >Objektą</a>
                                    @endif

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