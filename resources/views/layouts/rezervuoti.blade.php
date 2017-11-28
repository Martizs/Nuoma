@extends('layouts.master')
@section('content')
<div class="container">
    <script>
        $( function() {
            $('#diena').on('change', function(event){
                var diena = event.target.value;
                var savaite = document.getElementById('savaite').value;
                    window.location='{{ route('layouts.rezervuoti', ['id' => $post['id']] ) }}?savaite='+savaite+'&diena='+event.target.value;
                })
            });
    </script>
    @if(Session::has('info'))
        <div class="row">
            <div class="col-md-12">
                <p class="alert alert-info">{{ Session::get('info') }}</p>
            </div>
        </div>
    @endif
    <table class="table table-responsive">
        <thead>
        <th>
            <label for="savaite">Pasirinkite Savaitę:</label>
            <select id="savaite" name="savaite">
                <option value="1" selected="selected">1</option>
                @for($i=2; $i <= 52; $i++)
                    <option id="{{$i}}" value="{{$i}}" {{$savaite == $i? "selected":""}}>{{$i}}</option>
                @endfor
            </select>
        </th>
        <th>
            <label for="diena">Pasirinkite savaitės dieną</label>
            <select name="diena" id="diena">
                @for($i=1; $i <= 7; $i++)
                    <option value="{{$i}}" {{$diena == $i? "selected":""}}>{{$dayArray[$i]}}
                    </option>
                @endfor
            </select>
        </th>
        <th>
            @if(isset($diena))
                @include('includes.gautiLaikai')
            @endif
        </th>
        </thead>
    </table>
    <a class="btn btn-warning pull-right" href="{{ route('layouts.skelbimoPerziura', ['id' => $post['id']]) }}">Atgal</a>
</div>
@endsection