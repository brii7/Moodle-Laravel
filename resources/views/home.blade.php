@extends('layouts.app')

@section('content')

        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    @if(Session::has('success'))
                        <div class="alert-box success">
                            <h2>{{ Session::get('success') }}</h2>
                        </div>
                    @endif
                    <div class="panel panel-default">
                        <div class="panel-heading">Panell</div>

                        <div class="panel-body">
                            Benvingut al teu panell de control.
                        </div>
                        <div class="panel-body">
                            @if(Auth::user()->isAdmin())
                                <a href="{{route('users.create')}}"><button type="button" class="btn btn-primary">Afegir nou usuari</button></a>
                                <a href="{{route('cursos.new')}}"><button type="button" class="btn btn-primary">Afegir un curs</button></a>
                            @endif
                            <a href=""><button type="button" class="btn btn-primary">Canviar contrassenya</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
