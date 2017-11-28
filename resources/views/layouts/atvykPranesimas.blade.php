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
        <h2 class="page-header text-center">
            Pranešimas apie atvykimą
        </h2>
        <form action="{{ route('layouts.atvykPranesimasPost') }}" method="post" enctype="multipart/form-data">

            <table class="table table-responsive">
                <th class="col-md-10">
                    Įveskite kada atvyksite ir trumpą pranešimą nuomininkui
                </th>
                <th class="col-md-2">
                </th>
                <tr>
                    <td class="col-md-10">
                        <textarea id="apsilankymas" name="apsilankymas" type="form-control" rows="5" style="width:500px"></textarea>
                    </td>
                    <td class="col-md-2">
                        <a href="{{ route('layouts.objektas', ['id' => $skelbimas->id]) }}"class="btn btn-warning">Atgal</a>
                        <input type="hidden" name="post_id" value="{{$skelbimas['id']}}">
                        {{ csrf_field() }}
                        <button class="btn btn-success text-right" type="Submit">Pranešti</button>
                    </td>
                </tr>
                <th class="col-md-2">
                </th>
            </table>
        </form>
    </div>
</div>
@endsection