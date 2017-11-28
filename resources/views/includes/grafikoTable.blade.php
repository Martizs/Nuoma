<div class="table-responsive text-center">
    <script>
        var weekState = [];
        var toUpdate = [];

        function prepreForChange(element, diena) {
            if(!element.graphId) {
                var query = new URLSearchParams(window.location.search);
                element.graph = {
                    savaite: query.get('savaite'),
                    laikas: element.value,
                    diena: parseInt(diena),
                    create: element.classList.contains('btn-danger')
                };
                if(element.graph.create) {
                    element.classList.remove('btn-danger');
                    element.classList.add('btn-success');
                } else {
                    element.classList.add('btn-danger');
                    element.classList.remove('btn-success');
                }
                element.graphId = toUpdate.push(element.graph) - 1;
            } else {
                if(!element.graph.create) {
                    element.classList.remove('btn-danger');
                    element.classList.add('btn-success');
                } else {
                    element.classList.add('btn-danger');
                    element.classList.remove('btn-success');
                }
                toUpdate[element.graphId] = null;
                toUpdate = toUpdate.filter(function(e) { return e; }) || [];
                delete element.graph;
                delete element.graphId;
            }
        }

        function saveChanges(forAll) {
            if(forAll === undefined)
                forAll = false;

            $.post('', {
                _token: '{{ csrf_token() }}', data: toUpdate
            }, function () {
                if(forAll) {
                    $.post('http://marbar4.stud.if.ktu.lt/Nuoma2/public/grafikasAll/{{ Auth::user()->id }}', {
//                        forLokalTesting
                    {{--$.post('/grafikasAll/{{ Auth::user()->id }}', {--}}
                        _token: '{{ csrf_token() }}', savaite: '{{ $savaite }}'
                    }, function () { window.location.reload(); });
                } else {
                    window.location.reload();
                }
            });
        }
        {{--function changeTimeState(element, diena) {--}}
            {{--var query = new URLSearchParams(window.location.search);--}}
            {{--console.log([element])--}}
            {{--$.post( '', {_token: '{{ csrf_token() }}', data:[--}}
                {{--{--}}
                    {{--savaite: query.get('savaite'),--}}
                    {{--laikas: element.value,--}}
                    {{--diena: parseInt(diena),--}}
                    {{--create: !!element.classList.contains('btn-danger')--}}
                {{--}--}}
            {{--]}, function () {--}}
                {{--window.location.reload();--}}
            {{--});--}}
        {{--}--}}
    </script>
    @for($i=0; $i < 7; $i++)
        <div class="col-md-1">
            <table class="table">
                <th>
                    {{$dayArray[$i]}}
                </th>
                @for($j=0; $j < 14; $j++)
                    <tr>
                        <td class="">
                            <button
                                  {{ $state = false}}
                            @foreach($grafikas as $grafika)

                            @if($i+1==$grafika['diena'] AND
                                strcmp((string)(8+$j).':00-'.(string)(9+$j).':00', $grafika['laikas']) == 0 AND $grafika['savaitesNr'] == $savaite)
                                {{ $state = true }}
                            @endif
                            @endforeach
                                    class="btn btn-block {{ $state ? 'btn-success':'btn-danger' }}"
                                    value="{{8+$j}}:00-{{9+$j}}:00"

                                    onclick="prepreForChange(this, '{{ $i+1 }}' )">
                                {{8+$j}}:00-{{9+$j}}:00
                            </button>
                        </td>
                    </tr>
                @endfor
            </table>
        </div>
    @endfor
</div>
<div class="row">
    <input type="checkbox" id="forAll">
    <label for="forAll">Išsaugoti grafiką visoms savaitėms</label>
    <button class="btn btn-primary pull-right" onclick="saveChanges(forAll.checked)">Save</button>
</div>