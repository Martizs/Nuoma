@extends('layouts.master')

@section('content')
    @if(Session::has('info'))
        <div class="row">
            <div class="col-md-12">
                <p class="alert alert-info">{{ Session::get('info') }}</p>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <p class="quote">Iveskite skelbimo duomenis</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('layouts.skelbimas') }}" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Nuomuojamos vietos pavadinimas</label>
                    <input type="text" class="form-control" id="pavadinimas" name="pavadinimas">
                </div>
                <div class="form-group">
                    <label for="content">Kaina</label>
                    <input type="number" class="form-control" id="kaina" name="kaina">
                </div>
                <div class="form-group">
                    <label for="content">Vieta</label>
                    <input type="text" class="form-control" id="vieta" name="vieta">
                </div>
                <div class="form-group">
                    <label for="content">Nuotrauka</label>
                    <input type="file" class="form-control" id="nuotrauka" name="nuotrauka">
                </div>
                {{ csrf_field() }}
                <button type="submit" class="btn btn-primary">Išsaugoti</button>
            </form>
        </div>
    </div>
@endsection