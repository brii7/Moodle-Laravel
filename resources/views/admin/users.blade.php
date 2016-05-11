@extends('layouts.app')
@include('common.errors')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Llista d'usuaris</div>

                    <table class="table table-responsive">
                        <tr>
                            <th>Nom</th>
                            <th>E-mail</th>
                            <th>Data d'alta</th>
                            <th>Rol</th>

                        </tr>

                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->role }}</td>
                            </tr>
                        @endforeach

                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
