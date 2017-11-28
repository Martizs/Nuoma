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
        <div class="row">
            <div class="page-header text-center col-md-12">
                <h1>Skelbimo Įdėjimas</h1>
            </div>
        </div>
        <form action="{{ route('layouts.skelbimoIdejimas') }}" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default col-xs-2">
                    <div class="panel-body col-xs-12">
                        <div class="text-center">
                            <h4>Skelbimo Tipas</h4>
                        </div>
                        <hr>
                        <div class="row form-group">
                            <select id="patalpuTipas" name="patalpuTipas" required>
                                <option value="Namas">Namas</option>
                                <option value="Butas" selected>Butas</option>
                            </select>
                        </div>
                    </div>
                    <div class="panel-body col-xs-12">
                        <label for="pic" class="btn btn-primary">Nuotrauka</label>
                        <input type="file" id="pic" name="pic" style="visibility: hidden">
                    </div>
                </div>
                <div class="panel panel-default col-xs-10">
                    <div class="panel-body">
                        <div class="text-center">
                            <h4>Informacija apie objektą</h4>
                        </div>
                        <hr>
                        <div class="col-md-3">
                            <div class="row">
                                <label for="savivaldybe">Savivaldybė:</label>
                                <input type="text" id="savivaldybe" name="savivaldybe" required>
                            </div>

                            <div class="row">
                                <label for="gyvenviete">Gyvenvietė:</label>
                                <input type="text" id="gyvenviete" name="gyvenviete" required>
                            </div>

                            <div class="row">
                                <label for="mikrorajonas">Mikrorajonas:</label>
                                <input type="text" id="mikrorajonas" name="mikrorajonas" required>
                            </div>

                            <div class="row">
                                <label for="gatve">Gatvės Pavadinimas:</label>
                                <input type="text" id="gatve" name="gatve" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <label class="pull-left">Kaina&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                <input type="text" id="kaina" name="kaina" required>
                            </div>
                            <div class="row">
                                <label>Plotas&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                <input type="text" id="plotas" name="plotas" required>
                            </div>
                            <div class="row">
                                <label>Statybos Baigimo Metai:</label>
                                <input type="text" id="metai" name="metai" required>
                            </div>
                            <div class="row">
                                <label>Namo Nr.:</label>
                                <input type="text" id="namoNr" name="namoNr" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <label>Pastato Tipas:</label><input type="text" id="pastatoTip" name="pastatoTip" required>
                            </div>
                            <div class="row">
                                <label>Įrengimo Tipas:</label><input type="text" id="irengimoTip" name="irengimoTip" required>
                            </div>
                            <div class="row">
                                <label>Šildymo Tipas:</label><input type="text" id="sildymoTip" name="sildymoTip" required>
                            </div>
                            <div class="row">
                                <label>Namo Tipas:</label><input type="text" id="namoTip" name="namoTip" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <label for="komentaras">Komentaras:</label>
                                <textarea id="komentaras" name="komentaras" type="form-control" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-xs-9">

                        </div>
                        <div class="col-xs-3">
                            <a class="btn btn-warning"href="{{URL::previous()}}">Atgal</a>
                            {{ csrf_field() }}
                            <button class="btn btn-success text-right" type="Submit">Įdėti</button>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
        </form>

    </div>



@endsection