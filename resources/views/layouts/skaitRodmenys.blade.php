@extends('layouts.master')
@section('content')
    <script>
        $( function() {
            $('#menesis').on('change', function(event){
                var menesis = event.target.value;
                var metai = document.getElementById('metai').value;
                window.location='{{ route('layouts.skaitRodmenys', ['id' => $skelbimas['id']] ) }}?metai='+metai+'&menesis='+event.target.value;
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
    <div class="container">
        <h2 class="page-header text-center ">Pasirinkite Mėnesį ir įveskite duomenis</h2>
        <div class="col-md-12">
            <form action="{{ route('layouts.skaitRodmenysPost') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="post_id" value="{{ $postId }}">
            <table class="table table-responsive">
                <tbody>
                <tr>
                    <td class="col-md-6">Metai:
                        <select name="metai" id="metai" required autofocus>
                            @for($i=0; $i<3; $i++)
                                <option value="{{$yearArray[$i]}}" {{$metaiURL == $yearArray[$i]? "selected":""}}>{{$yearArray[$i]}}</option>
                            @endfor
                        </select>
                    </td>
                    <td class="col-md-6">
                        <select name="menesis" id="menesis" required>
                            @for($i=0; $i<12; $i++)
                                <option value="{{$monthArray[$i]}}" {{$menesisURL == $monthArray[$i]? "selected":""}}>{{$monthArray[$i]}}</option>
                            @endfor
                        </select>
                    </td>
                </tr>
                @if($skelbimas['user_id'] == Auth::user()->id)
                    <tr>
                        <td>Elektros Skaitiklių Rodmenys:</td>
                        @if($saskaitas['elektra']==0)
                            <td><strong>Nepateikta Duomenų</strong></td>
                        @else
                            <td><strong>{{$saskaitas['elektra']}}</strong></td>
                        @endif
                    </tr>
                    <tr>
                        <td>Dujų Skaitiklių Rodmenys:</td>
                        @if($saskaitas['dujos']==0)
                            <td><strong>Nepateikta Duomenų</strong></td>
                        @else
                            <td><strong>{{$saskaitas['dujos']}}</strong></td>
                        @endif
                    </tr>
                    <tr>
                        <td>Šalto Vandens Skaitiklių Rodmenys:</td>
                        @if($saskaitas['karstas']==0)
                            <td><strong>Nepateikta Duomenų</strong></td>
                        @else
                            <td><strong>{{$saskaitas['karstas']}}</strong></td>
                        @endif
                    </tr>
                    <tr>
                        <td>Karšto Vandens Skaitiklių Rodmenys:</td>
                        @if($saskaitas['saltas']==0)
                            <td><strong>Nepateikta Duomenų</strong></td>
                        @else
                            <td><strong>{{$saskaitas['saltas']}}</strong></td>
                        @endif
                    </tr>
                @else
                <tr>
                    <td>Elektros Skaitiklių Rodmenys:</td>
                    <td><input id="elektra" name="elektra" type="number" required></td>
                </tr>
                <tr>
                    <td>Dujų Skaitiklių Rodmenys:</td>
                    <td><input id="dujos" name="dujos" type="number" required></td>
                </tr>
                <tr>
                    <td>Šalto Vandens Skaitiklių Rodmenys:</td>
                    <td><input id="saltas" name="saltas" type="number" required></td>
                </tr>
                <tr>
                    <td>Karšto Vandens Skaitiklių Rodmenys:</td>
                    <td><input id="karstas" name="karstas" type="number" required></td>
                </tr>
                @endif
                </tbody>
            </table>
            <div class="text-right">
                <a class="btn btn-warning" href="{{URL::previous()}}">Atgal</a>
                @if($skelbimas['user_id'] != Auth::user()->id)
                {{ csrf_field() }}
                <button class="btn btn-success text-right" type="Submit">Pateikti</button>
                @endif
            </div>
            </form>
        </div >
    </div>
@endsection