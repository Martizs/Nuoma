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
    <div class="row text-center page-header">
        <h1>Objektų Peržiūra<a class="btn btn-default right" href="{{ route('layouts.nuomosIstorija') }}">Nuomos Istorija</a></h1>
    </div>
    <div class="panel panel-default col-md-12">
        <div class="panel-body col-md-6">
            <table class="table table-responsive">
                <div class="text-center">
                    <h2>Išsinuomoti Objektai</h2>
                </div>
                <tbody>
                @if(count($manoIssinuomoti)==0)
                    <tr>
                        <td>
                            <div class="text-center">
                                <h2>Išsinuomotų objektų nėra</h2>
                            </div>
                        </td>
                    </tr>
                @else
                @for($i = 0; $i < count($manoIssinuomoti); $i++)
                        <tr>
                            <td>
                                <div>
                                    <a href="{{ route('layouts.objektas', ['id' => $manoIssinuomoti[$i]['post_id']]) }}"><img class="img-thumbnail imageHeight"  src="{{ $photoIssinuomoti[$i] }}"></a>
                                </div>
                            </td>
                            <td>
                                <ul class="list-unstyled">
                                    <li>Nuomotojas: {{$manoIssinuomoti[$i]['name']}}</li>
                                    <li>Tipas: {{$manoIssinuomoti[$i]['patalpuTipas']}}</li>
                                    <li>Gyvenviete: {{$manoIssinuomoti[$i]['gyvenviete']}}</li>
                                    <li>Mikrorajonas: {{$manoIssinuomoti[$i]['mikroRaj']}}</li>
                                    <li>Gatvė: {{$manoIssinuomoti[$i]['gatve']}}</li>
                                </ul>
                                <a class="btn btn-success pull-right" href="{{route('layouts.objektas', ['id' => $manoIssinuomoti[$i]['post_id']]) }}" class="">Peržiūrėti Objektą</a>
                            </td>
                        </tr>
                @endfor
                @endif
                </tbody>
            </table>
        </div>
        <div class="panel-body col-md-6">
            <table class="table table-responsive">
                <div class="text-center">
                    <h2>Išnuomoti Objektai</h2>
                </div>
                <tbody>
                @if((count($manoIsnuomoti)==0))
                    <tr>
                        <td>
                            <div class="text-center">
                                <h2>Išnuomotų objektų nėra</h2>
                            </div>
                        </td>
                    </tr>
                @else
                @for($i = 0; $i < count($manoIsnuomoti); $i++)

                        <tr>
                            <td>
                                <div>
                                    <a href="{{ route('layouts.objektas', ['id' => $manoIsnuomoti[$i]['post_id']]) }}"><img class="img-thumbnail imageHeight"  src="{{ $photoIsnuomoti[$i] }}"></a>
                                </div>
                            </td>
                            <td>
                                <ul class="list-unstyled">
                                    <ul class="list-unstyled">
                                        <li>Nuomininkas: {{$manoIsnuomoti[$i]['name']}}</li>
                                        <li>Tipas: {{$manoIsnuomoti[$i]['patalpuTipas']}}</li>
                                        <li>Gyvenviete: {{$manoIsnuomoti[$i]['gyvenviete']}}</li>
                                        <li>Mikrorajonas: {{$manoIsnuomoti[$i]['mikroRaj']}}</li>
                                        <li>Gatvė: {{$manoIsnuomoti[$i]['gatve']}}</li>
                                    </ul>
                                </ul>
                                <a class="btn btn-success pull-right" href="{{route('layouts.objektas', ['id' => $manoIsnuomoti[$i]['post_id']])}}" class="">Peržiūrėti Objektą</a>
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