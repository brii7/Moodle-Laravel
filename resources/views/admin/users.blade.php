@extends('layouts.app')
@include('common.errors')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Llista d'usuaris

                        <a style="float:right" href="{{route('users.create')}}">
                            <button type="button" class="btn-success"><i class="fa fa-plus"></i></button>
                        </a>


                    </div>

                    <table class="table table-responsive">
                        <tr>
                            <th>Nom</th>
                            <th>E-mail</th>
                            <th>Data d'alta</th>
                            <th>Rol</th>
                            <th></th>

                        </tr>

                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->role }}</td>
                                <td style="text-align: center">
                                    @if($user->id != 1)
                                        <form style="" action="{{route('users.delete', array($user->id))}}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" id="delete-user-{{ $user->id }}" class="btn-danger">
                                                <i class="fa fa-close"></i>
                                            </button>
                                        </form>
                                    @endif

                                </td>
                            </tr>
                        @endforeach

                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
