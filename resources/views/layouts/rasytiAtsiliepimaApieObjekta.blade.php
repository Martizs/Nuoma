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
        <form action="{{ route('layouts.rasytiAtsiliepimaApieObjektaPost') }}" method="post" enctype="multipart/form-data">
            <div class="panel panel-default col-md-12">
                <input type="hidden" name="rev_id" value="{{ $post->id }}">
                <input type="hidden" name="statusas" value="skelbimas">
                <div class="row page-header text-center">
                    <div class="stars">
                        <form action="">
                            <input class="star star-5 font-awesome" value="5" id="star-5" type="radio" name="ivertinimas"/>
                            <label class="star star-5" for="star-5"></label>
                            <input class="star star-4" value="4" id="star-4" type="radio" name="ivertinimas"/>
                            <label class="star star-4" for="star-4"></label>
                            <input class="star star-3" value="3" id="star-3" type="radio" name="ivertinimas"/>
                            <label class="star star-3" for="star-3"></label>
                            <input class="star star-2" value="2" id="star-2" type="radio" name="ivertinimas"/>
                            <label class="star star-2" for="star-2"></label>
                            <input class="star star-1" value="1" id="star-1" type="radio" name="ivertinimas"/>
                            <label class="star star-1" for="star-1"></label>
                        </form>
                    </div>
                </div>
                <div class="panel-body col-md-offset-4 col-md-4">
                    <h4>Komentaras:</h4>
                    <textarea name="atsiliepimas" id="" cols="45" rows="5"></textarea>
                    <div class="row">
                        <div class="col-md-4 right">
                            {{ csrf_field() }}
                            <button class="btn btn-success right" type="submit">Atsiliepti</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection