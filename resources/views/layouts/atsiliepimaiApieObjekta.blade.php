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
        @if(count($atsakymas) == 0)
            <div class="row"><h2>Įvertinimų nėra</h2></div>
        @else
            <table class="table table-responsive">
                @for($i = 0; $i<count($atsakymas); $i++)
                    <tr>
                        <td>
                            <h4>Įvertinimas: {{ $atsakymas[$i]['ivertinimas'] }} </h4>
                            <div class="stars">
                                <input class="star star-5" value="5" id="star-5" type="radio" name="star" {{ $atsakymas[$i]['ivertinimas'] == 5 ? "checked":"" }} disabled/>
                                <label class="star star-5" for="star-5"></label>
                                <input class="star star-4" value="4" id="star-4" type="radio" name="star" {{ $atsakymas[$i]['ivertinimas'] == 4 ? "checked":"" }} disabled/>
                                <label class="star star-4" for="star-4"></label>
                                <input class="star star-3" value="3" id="star-3" type="radio" name="star" {{ $atsakymas[$i]['ivertinimas'] == 3 ? "checked":"" }} disabled/>
                                <label class="star star-3" for="star-3"></label>
                                <input class="star star-2" value="2" id="star-2" type="radio" name="star" {{ $atsakymas[$i]['ivertinimas'] == 2 ? "checked":"" }} disabled/>
                                <label class="star star-2" for="star-2"></label>
                                <input class="star star-1" value="1" id="star-1" type="radio" name="star" {{ $atsakymas[$i]['ivertinimas'] == 1 ? "checked":"" }} disabled/>
                                <label class="star star-1" for="star-1"></label>
                            </div>
                        </td>
                        <td>
                            <h4>Atsiliepimas: {{ $atsakymas[$i]['atsiliepimas'] }}</h4>
                        </td>
                    </tr>
                @endfor
            </table>
        @endif
    </div>
@endsection