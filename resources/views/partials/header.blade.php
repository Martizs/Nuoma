<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10">
                <a href="{{ route('layouts.home') }}" class="navbar-left"><img class="center-block" src="{{ URL::to('logo/nnbs3.png') }}"></a>
            </div>
            @if(!Auth::check())
                <div class="col-lg-2">
                    <div class="col-lg-6">
                        <a href="{{ route('register') }}" class="btn btn-primary">Registruotis</a>
                    </div>
                    <div class="col-lg-6">
                        <a href="{{ route('login') }}" class="btn btn-info">Prisijungti</a>
                    </div>
                </div>
            @else

                <div class="col-lg-1 center-block">
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Prisijungęs: {{ Auth::user()->name }}
                            <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a class="btn pull-left" href="{{ route('layouts.paskyra', ['id' => Auth::user()->id ]) }}">
                                    Paskyra
                                </a>
                            <li><a class="btn pull-left" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Atsijungti
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form></li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
</nav>

