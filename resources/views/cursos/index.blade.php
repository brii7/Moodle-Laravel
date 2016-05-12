@extends('layouts.app')

@section('content')


<!-- Current Tasks -->
@if (count($mycursos) > 0)
    <div class="panel panel-default">
        <div class="panel-heading">
            Els meus cursos
        </div>

        <div class="panel-body">
            <table class="table table-striped task-table">

                <!-- Table Headings -->
                <thead>
                <th>Nom</th>
                <th>Professor</th>
                </thead>

                <!-- Table Body -->
                <tbody>
                @foreach ($mycursos as $curs)
                    <tr>
                        <!-- Task Name -->
                        <td class="table-text">
                            <div>{{ $curs->name }}</div>
                        </td>
                        <td class="table-text">
                            <div>{{ $curs->teacher() }}</div>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection