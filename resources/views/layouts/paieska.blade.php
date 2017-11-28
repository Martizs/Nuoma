@extends('layouts.master')
@section('content')
    <br>
    <br>
<div class="container">
    @if(Session::has('info'))
        <div class="row">
            <div class="col-md-12">
                <p class="alert alert-info">{{ Session::get('info') }}</p>
            </div>
        </div>
    @endif
    <form action="{{ route('layouts.paieska') }}" method="post" enctype="multipart/form-data">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-4 panel-body">
                <ul class="list-unstyled">
                    <li class="right">
                        <label for="patalpuTipas">Objekto Tipas:</label>
                        <select id="patalpuTipas" name="patalpuTipas">
                            <option value="Namas">Namas</option>
                            <option value="Butas">Butas</option>
                        </select>
                    </li>
                    <li class="right">
                        <label for="savivaldybe">Savivaldybė:</label>
                        <input type="text" id="savivaldybe" name="savivaldybe">
                    </li>

                    <li class="right">
                        <label for="gyvenviete">Gyvenvietė:</label>
                        <input type="text" id="gyvenviete" name="gyvenviete">
                    </li>
                    <li class="right">
                        <label for="mikrorajonas">Mikrorajonas:</label>
                        <input type="text" id="mikroRaj" name="mikroRaj">
                    </li>

                    <li class="right"><label for="gatve">Gatve:</label>
                        <input type="text" id="gatve" name="gatve">
                    </li>
                </ul>
            </div>
            <div class="col-md-4 panel-body">
                <div class="row text-right">
                    <label>Plotas(m2):</label>
                    <input class="inputNumber" type="number" placeholder="nuo" id="plotasNuo" name="plotasNuo">
                    <input class="inputNumber" type="number" placeholder="iki" id="plotasIki" name="plotasIki">
                </div>

                        <div class="row text-right">
                                <label>Kaina:</label>
                                <input class="inputNumber" type="number" placeholder="nuo" id="kainaNuo" name="kainaNuo">
                                <input class="inputNumber" type="number" placeholder="iki" id="kainaIki" name="kainaIki">
                        </div>

                        <div class="row text-right">
                            <label>Aukšktas:</label>
                            <input class="inputNumber" type="number" placeholder="nuo" id="aukstasNuo" name="aukstasNuo">
                            <input class="inputNumber" type="number" placeholder="iki" id="aukstasIki" name="aukstasIki">
                        </div>
                <div class="row text-right">
                    <label>Aukšktas:</label>
                    <select name="aukstoTip" id="aukstoTip">
                        <option value="1">Ne Pirmas</option>
                        <option value="99">Ne Paskutinis</option>
                        <option value="-1">Ne Pirm. ir ne Pask.</option>
                    </select>
                </div>

            </div>
            <div class="col-md-4 panel-body">
                <div class="row">
                    <div class="right">
                        <label for="pastatoTip">Pastato Tipas:</label>
                        <select name="pastatoTip" id="pastatoTip">
                            <option value="">Mūrinis</option>
                            <option value="">Blokinis</option>
                            <option value="">Medinis</option>
                        </select>
                    </div>

                </div>
                <div class="row">
                    <div class="right">
                        <label for="irengimoTip">Įrengimo Tipas:</label>
                        <select name="irengimoTip" id="irengimoTip">
                            <option value="">Pilnai Irengtas</option>
                            <option value="">Daline apdaila</option>
                            <option value="">Kosmetinis Remontas</option>
                        </select></div>
                </div>
                <div class="row">
                    <div class="right">
                        <label for="sildymoTip">Šildymo Tipas:</label>
                        <select name="sildymoTip" id="sildymoTip">
                            <option value="">Dujinis</option>
                            <option value="">Centrinis</option>
                            <option value="">Kietasis Kuras</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
        {{ csrf_field() }}
    <button class="btn btn-success" type="submit">Ieškoti!</button>
    </form>
</div>
@endsection