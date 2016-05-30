<?php
use App\User;
?>
@extends('layouts.app')


@section('content')

    <div class="row">

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>{{$curs->name}}</h1>
                    <h2>{{$uf->name}} {{$uf->description}}</h2>

                    <a href="{{route('cursos.task.show', array($curs->id, $uf->id, $tasca->id))}}">
                        <button type="submit" class="btn-primary">
                            <i class="fa fa-btn fa-arrow-left"></i>
                        </button>
                    </a>

                </div>
                <div class="panel-body">
                    <h2>{{$tasca->name}}</h2>

                    <h3>Descripció</h3>
                    {{$tasca->description}}

                    <table class="table table-responsive table-bordered">
                        <tr>
                            <th>Alumne</th>
                            <th>Nota</th>
                            <th>Explicació</th>
                            <th>Entregat Tard</th>
                            <th>Fitxers</th>
                            <th>Correccions</th>

                        </tr>

                        @foreach($entregables as $entregable)

                            <tr>
                                <td>
                                    {{User::find($entregable->user_id)->name}}
                                </td>

                                @if(!$entregable->corregit)
                                    <td style="color:red">No corregit</td>
                                @else
                                    <td>{{$entregable->nota}}</td>
                                @endif

                                @if(!$entregable->corregit)
                                    <td style="color:red">No corregit</td>
                                @else
                                    <td>{{$entregable->explicacio}}</td>
                                @endif

                                @if($entregable->entregat_tard)
                                    <td style="color:red">Sí.</td>
                                @else
                                    <td>No.</td>
                                @endif

                                <td>
                                    <a href="http://192.168.15.190/tasques/{{$curs->id}}/{{$uf->id}}/{{$tasca->id}}/{{$entregable->file}}"
                                       download="{{$entregable->file}}">
                                        Fitxer entregat
                                    </a>
                                </td>

                                @if(!$entregable->corregit)
                                    <td style="text-align: center;">
                                        <button class="btn-warning"
                                                type="button" data-toggle="modal"
                                                data-target="#modal{{$entregable->user_id}}">Corregir
                                        </button>
                                        <div id="modal{{$entregable->user_id}}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Correcció</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="form-horizontal" method="POST" action="">
                                                            {!! csrf_field() !!}
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Alumne: </label>
                                                                <div class="col-md-7">
                                                                    <input type="text" class="form-control"
                                                                           name="user_name" value="{{User::find($entregable->user_id)->name}}" readonly>
                                                                    <input type="hidden" class="form-control"
                                                                           name="user_id" value="{{$entregable->user_id}}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Nota: (*) </label>
                                                                <div class="col-md-7">
                                                                    <input type="number" step="any" min="1" max="10" class="form-control" name="nota" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Explicació: </label>
                                                                <div class="col-md-7">
                                                                <textarea cols="20" rows="8" class="form-control" maxlength="1000" name="explicacio"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-6 col-md-offset-4">
                                                                    <button type="submit" class="btn btn-primary">
                                                                        <i class="fa fa-btn fa-check"></i>Corregir
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                @else
                                    <td style="text-align: center;">
                                        <button class="btn-success"
                                                type="button" data-toggle="modal"
                                                data-target="#modal{{$entregable->user_id}}">Editar correcció
                                        </button>

                                    <div id="modal{{$entregable->user_id}}" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Correcció</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal" method="POST" action="">
                                                        {!! csrf_field() !!}
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Alumne: </label>
                                                            <div class="col-md-7">
                                                                <input type="text" class="form-control"
                                                                       name="user_name" value="{{User::find($entregable->user_id)->name}}" readonly>
                                                                <input type="hidden" class="form-control"
                                                                       name="user_id" value="{{$entregable->user_id}}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Nota: (*) </label>
                                                            <div class="col-md-7">
                                                                <input type="number" value="{{$entregable->nota}}" step="any" min="1" max="10" class="form-control" name="nota" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Explicació: </label>
                                                            <div class="col-md-7">
                                                                <textarea cols="20"rows="8" class="form-control" maxlength="1000" name="explicacio">{{$entregable->explicacio}}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-md-6 col-md-offset-4">
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="fa fa-btn fa-check"></i>Corregir
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </td>
                                @endif

                            </tr>

                        @endforeach

                    </table>
                </div>

            </div>
        </div>
</div>
@endsection