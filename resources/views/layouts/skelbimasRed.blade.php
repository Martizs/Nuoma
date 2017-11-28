@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <p class="quote">Iveskite skelbimo duomenis</p>
        </div>
    </div>
    @if(\Illuminate\Support\Facades\Session::has('info'))
        <div class="row">
            <div class="col-md-12">
                <p class="alert alert-info">{{\Illuminate\Support\Facades\Session::get('info')}}</p>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('layouts.skelbimasUp') }}" method="post">
                <div class="form-group">
                    <label for="title">Nuomuojamos vietos pavadinimas</label>
                    <input type="text" class="form-control" id="pavadinimas" name="pavadinimas" value="{{$post->pavadinimas}}">
                </div>
                <div class="form-group">
                    <label for="content">Kaina</label>
                    <input type="number" class="form-control" id="kaina" name="kaina" value="{{$post->kaina}}">
                </div>
                <div class="form-group">
                    <label for="content">Vieta</label>
                    <input type="text" class="form-control" id="vieta" name="vieta" value="{{$post->vieta}}">
                </div>
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $postId }}">
                <button type="submit" class="btn btn-primary">Išsaugoti pakeitimus</button>
            </form>
        </div>
    </div>
@endsection