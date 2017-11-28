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
    <div class="panel panel-default col-md-12">
        <div class="panel-body col-md-6">

            <table class="table table-responsive">
                <h3>Informacija Apie Objektą</h3>
                <tbody>
                <tr>
                    <td>Savivaldybė:</td>
                    <td>{{$post['savivaldybe']}}</td>
                </tr>
                <tr>
                    <td>Gyvenvietė:</td>
                    <td>{{$post['gyvenviete']}}</td>
                </tr>
                <tr>
                    <td>Mikrorajonas:</td>
                    <td>{{$post['mikroRaj']}}</td>
                </tr>
                <tr>
                    <td>Gatvė:</td>
                    <td>{{$post['gatve']}}</td>
                </tr>
                <tr>
                    <td>Patalpų Tipas:</td>
                    <td>{{$post['patalpuTipas']}}</td>
                </tr>
                <tr>
                    <td>Plotas:</td>
                    <td>{{$post['plotas']}}</td>
                </tr>
                <tr>
                    @if($post['nuomin_id'] == Auth::user()->id)
                    <td>Artimiausias apsilankymas ir žinutė:</td>
                    @if(strlen($post['apsilankymas']) > 0)
                        <td>{{$post['apsilankymas']}}</td>
                        @else
                        <td>Informacijos nėra</td>
                    @endif
                    @endif
                </tr>
                <tr>
                    @if($post['user_id']==Auth::user()->id)
                    <td class="col-md-6">
                        <form action="{{ route('layouts.nutrauktiNuoma') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="post_id" value="{{ $post['id'] }}">
                            <input type="hidden" name="statusas" value="atmesta">
                            {{ csrf_field() }}
                            <button class="btn btn-danger btn-block" type="submit">Nutraukti Nuomą</button>
                        </form>
                    </td>
                        @else
                        <td class="col-md-6">

                        </td>
                    @endif
                    <td class="col-md-6"></td>
                </tr>
                </tbody>
            </table>

        </div>
        <div class="panel-body col-md-6">
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <div class="row">
                    <a href="{{ route('layouts.dokIkelimas', $post['id']) }}" id="dokumentai" class="btn btn-primary btn-block "><p class="glyphicon glyphicon-file"></p>Objekto Dokumentai</a>
                    <br>
                </div>
                <div class="row">
                    <a href="{{route('layouts.nuotraukuIkelimas', $post['id']) }}" id="nuotraukos" class="btn btn-primary btn-block"><p class="glyphicon glyphicon-picture"></p>Objekto Nuotraukos</a>
                    <br>
                </div>
                @if($post['nuomin_id'] == Auth::user()->id)
                <div class="row">
                    <a href="{{route('layouts.skaitRodmenys', $post['id']) }}" id="skaitikliai" class="btn btn-primary btn-block"><p class="glyphicon glyphicon-calendar"></p>Pateikti skaitiklių duomenys</a>
                    <br>
                </div>
                @else
                    <div class="row">
                        <a href="{{route('layouts.skaitRodmenys', $post['id']) }}" id="skaitikliai" class="btn btn-primary btn-block"><p class="glyphicon glyphicon-calendar"></p>Peržiūrėti skaitiklių duomenys</a>
                        <br>
                    </div>
                @endif
                <div class="row">
                    <a href="{{route ('layouts.sask', $post['id']) }}" id="saskaita" class="btn btn-primary btn-block"><p class="glyphicon glyphicon-envelope"></p>Sąskaitos</a>
                    <br>
                </div>
                @if($post['user_id'] == Auth::user()->id)
                <div class="row">
                    <a href="{{route('layouts.atvykPranesimas', $post['id'])}}" id="atvykimas" class="btn btn-primary btn-block"><p class="glyphicon glyphicon-envelope"></p>Pranešti apie atvykimą</a>
                    <br>
                </div>
                @endif

            </div>


        </div>
    </div>

</div>

@endsection