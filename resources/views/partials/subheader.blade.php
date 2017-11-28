<div class="container-fluid paddingFromTop ">
    <div class="row">
        <div class="nav navbar-default panel-body">
            <div class="col-md-6">
                <div class="btn btn-primary left" >
                    <h5><a href="{{route('layouts.paieska')}}" id="paieska" class="customButton" style="text-decoration: none; color: ghostwhite">Paieška</a></h5>
                </div>
                @if(!Auth::check())
                    <div class="col-md-6">

                    </div>
                @else
                <div class="col-md-1"></div>

                <div class="btn btn-primary">
                    <h5><a href="{{ route('layouts.manoSkelbimai') }}" id="objektuPerziura" class="customButton" style="text-decoration: none; color: ghostwhite">Mano Skelbimai</a></h5>
                </div>
                @endif
            </div>
            <div class="col-md-4 right">
                @if(!Auth::check())
                    <div class="col-md-6">

                    </div>
                @else
                    <div class="col-md-5 btn btn-primary">
                        <h5><a href="{{ route('layouts.objPerziura') }}" id="objektuPerziura" class="customButton" style="text-decoration: none; color: ghostwhite">Objektų peržiūra</a></h5>
                    </div>
                    <div class="col-md-1">

                    </div>
                @endif
                <div class="col-md-6 btn btn-primary">
                    <h5><a href="{{ route('layouts.skelbimoIdejimas') }}" id="skelbimuIdejimas" class="customButton" style="
                    text-decoration: none;
                    color: ghostwhite"
                        ><strong>+</strong>Skelbimo įdėjimas</a></h5>
                </div>
            </div>
        </div>
    </div>
</div>