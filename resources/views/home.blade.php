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
                                <a href="{{route('users.create')}}"><button type="button" class=" btn-primary">Afegir nou usuari</button></a>
                                <a href="{{route('cursos.new')}}"><button type="button" class=" btn-primary">Afegir un curs</button></a>
                            @endif
                            <a href=""><button type="button" class=" btn-primary">Editar el meu perfil</button></a>
                            <a href="{{route('users.notes')}}"><button type="button" class=" btn-primary">Veure les meves notes</button></a>




                                <table style="margin-top: 20px;" class="table table-responsive table-bordered">
                                <tr>
                                    <th>Nom</th>
                                    <th>E-Mail</th>
                                    <th>Rol</th>
                                </tr>
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->role}}</td>
                                </tr>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
