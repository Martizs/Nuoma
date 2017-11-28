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
                    <div class="text-center"><h2>Paieškos rezultatai</h2></div>
                    <tbody>
                    @if(!$rezultatai)
                        <tr>
                            <td>
                                <div class="text-center">
                                    <h2>Paieška nieko negražino</h2>
                                </div>
                            </td>
                        </tr>
                    @else
                        @for($i = 0; $i < count($rezultatai); $i++)
                            <tr>
                                <td>
                                    <div>
                                        <a href="{{ route('layouts.skelbimoPerziura', ['id' => $rezultatai[$i]['post_id']]) }}"><img class="img-thumbnail imageHeight"  src="{{ $nuotrauka[$i] }}"></a>
                                    </div>
                                </td>
                                <td>
                                    <table class="table table-responsive">
                                        <tbody>

                                        <tr>
                                            <td>Savivaldybė:</td>
                                            <td>{{$rezultatai[$i]['savivaldybe']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Gyvenvietė:</td>
                                            <td>{{$rezultatai[$i]['gyvenviete']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Mikrorajonas:</td>
                                            <td>{{$rezultatai[$i]['mikroRaj']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Gatvė:</td>
                                            <td>{{$rezultatai[$i]['gatve']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Patalpų Tipas:</td>
                                            <td>{{$rezultatai[$i]['patalpuTipas']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Plotas:</td>
                                            <td>{{$rezultatai[$i]['plotas']}}</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </td>
                                <td>
                                    <a class="btn btn-success right"href="{{ route('layouts.skelbimoPerziura', ['id' => $rezultatai[$i]['post_id']]) }}" class="">Peržiūrėti Skelbimą</a>
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