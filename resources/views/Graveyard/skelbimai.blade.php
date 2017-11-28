@extends('layouts.master')

@section('content')
    @if(\Illuminate\Support\Facades\Session::has('info'))
        <div class="row">
            <div class="col-md-12">
                <p class="alert alert-info">{{\Illuminate\Support\Facades\Session::get('info')}}</p>
            </div>
        </div>
    @endif
    @for($i=0;$i<3;$i++)
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="post-title">{{$post->pavadinimas}}</h1>
                <p>{{$post->content}}</p>
                <p>{{$post->vieta}}</p>
                <p>{{$post->kaina}} Eur/Men</p>
                @foreach($files as $file)
                    @if($file->post_id == $post->id)
                        <p>{{\Illuminate\Support\Facades\Storage::url($file->path)}}</p>
                    <img HEIGHT="30%" width="30%" src="{{\Illuminate\Support\Facades\Storage::url($file->path)}}">
                    @endif
                @endforeach
                <p><a href="{{ route('layouts.skelbimasRed', ['id' => $post->id]) }}">Redaguoti</a>
                    <a href="{{ route('layouts.delete', ['id' => $post->id]) }}">Ištrinti</a> </p>
            </div>
        </div>
    @endfor
    <div class="row">
        <div class="col-md-12 text-center" >
            {{$posts->links()}}
        </div>
    </div>
@endsection