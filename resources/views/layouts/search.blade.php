@extends('layouts.nuomininkas')

@section('search')
    @if($posts != null)
        @foreach($posts as $post)
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 class="post-title">{{$post->pavadinimas}}</h1>
                    <p>{{$post->vieta}}</p>
                    <p>{{$post->kaina}} Eur/Men</p>
                </div>
            </div>
        @endforeach
        {{--<div class="row">
            <div class="col-md-12 text-center" >
                {{$posts->links()}}
            </div>
        </div>--}}
    @endif
@endsection