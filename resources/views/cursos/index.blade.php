@extends('layouts.app')

@section('content')

<div class="row">
@if (count($cursos) > 0)

    <div class="col-lg-8 col-md-offset-2">
        <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Cursos</h2>
            @if(Auth::user()->isAdmin())
                <a href="{{route('cursos.new')}}">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-btn fa-plus"></i>Afegir curs
                </button>
                </a>
            @endif
        </div>
        <div class="panel-body">
            <table class="table">

                <thead>
                    <th>Nom</th>
                    <th>Professor</th>
                    <th>Número d'alumnes</th>
                    <th>Nota mitjana global</th>
                </thead>

                <tbody>
                @foreach ($cursos as $curs)
                    <tr>
                        <!-- Task Name -->
                        <td class="table-text">
                            <div><a href="{{ url('cursos/'.$curs->id).'/show'}}">{{ $curs->name }}</a></div>
                        </td>
                        <td class="table-text">
                            <div>{{ $curs->teacher() }}</div>
                        </td>
                        <td>
                            TODO
                        </td>
                        <td>
                            TODO
                        </td>
                        <td>
                            @if(Auth::user()->isAdmin())
                                <form action="{{ url('cursos/delete/'.$curs->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" id="delete-curs-{{ $curs->id }}" class="btn btn-danger">
                                        <i class="fa fa-btn fa-trash"></i>Esborrar
                                    </button>
                                </form>
                            @elseif($curs->members->contains(Auth::user()->id))
                                <form action="{{ url('cursos/'.$curs->id).'/esborrar'}}" method="POST">
                                    {{ csrf_field() }}
                                    <button type="submit" id="inscriure-curs-{{ $curs->id }}" class="btn btn-warning">
                                        <i class="fa fa-btn fa-plus"></i>Anular inscripció
                                    </button>
                                </form>
                            @else
                                <form action="{{ url('cursos/'.$curs->id).'/inscriure'}}" method="POST">
                                    {{ csrf_field() }}
                                    <button type="submit" id="inscriure-curs-{{ $curs->id }}" class="btn btn-primary">
                                        <i class="fa fa-btn fa-plus"></i>Inscriure's
                                    </button>
                                </form>
                            @endif

                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>

@else

    <h1>No hi ha cursos disponibles.</h1>

@endif
</div>
@endsection