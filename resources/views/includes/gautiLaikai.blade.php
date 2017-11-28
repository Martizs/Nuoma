 <form action="{{ route('layouts.rezervuoti', ['id' => $post['id']]) }}" method="post" enctype="multipart/form-data">
    <label for="laikas">Pasirinkite Laiką</label>
    <select name="laikoId" id="laikoId">
        @foreach($laikais as $laikai )
        <option value="{{$laikai['id']}}">{{$laikai['laikas']}}  </option>
        @endforeach
                    <input type="hidden" name="post_id" value="{{ $postId }}">
    </select>
     {{ csrf_field() }}
     <button class="btn btn-success pull-right">Rezervuoti</button>
 </form>