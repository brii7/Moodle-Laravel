<?php
use App\Curs;
use App\UnitatFormativa;
use App\Task;
?>
@extends('layouts.app')


@section('content')

    <div class="row">

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <h1>Notes de l'alumne {{$user->name}}</h1>

                    <a href="{{route('dashboard')}}">
                        <button type="submit" class="btn-primary">
                            <i class="fa fa-btn fa-arrow-left"></i>
                        </button>
                    </a>

                </div>
                <div class="panel-body">


                    <table class="table table-responsive table-bordered">
                        <tr>
                            <th>Curs</th>
                            <th>UF</th>
                            <th>Tasca</th>
                            <th>Nota</th>

                        </tr>

                        @foreach($user_notes as $row)
                            <tr>
                                <td><a href="{{route('cursos.show', $row->course_id)}}">{{Curs::find($row->course_id)->name}}</a></td>
                                <td>{{UnitatFormativa::find($row->uf_id)->name}}</td>
                                <td><a href="{{route('cursos.task.show', array($row->course_id, $row->uf_id, $row->task_id))}}">{{Task::find($row->task_id)->name}}</a></td>
                                <td style="text-align: center;font-size: 17px;">
                                    @if($row->corregit)
                                        @if($row->nota < 5)
                                            <p style="color:red; font-weight: bold">{{$row->nota}}</p>
                                        @else
                                            <p>{{$row->nota}}</p>
                                        @endif
                                    @else
                                        No corregit.
                                    @endif

                                </td>
                            </tr>

                        @endforeach
                            <tr>
                                <td style="text-align: right;font-weight: bold;"colspan="3">Nota global:</td>
                                <td></td>
                            </tr>
                    </table>

                </div>

            </div>
        </div>
    </div>
@endsection