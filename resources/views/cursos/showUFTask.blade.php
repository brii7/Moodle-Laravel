@extends('layouts.app')


@section('content')

    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>{{$curs->name}}</h1>
                    <h2>{{$uf->name}} {{$uf->description}}</h2>

                    <a href="{{route('cursos.show', array($curs->id))}}">
                        <button class="btn-primary">
                            <i class="fa fa-btn fa-arrow-left"></i>
                        </button>
                    </a>
                    @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                        <button style="float:right" type="button" class="btn-warning" data-toggle="modal"
                                data-target="#editarTasca">
                            <i class="fa fa-pencil"></i>
                        </button>
                        <div id="editarTasca" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Editar tasca</h4>
                                    </div>
                                    <div class="modal-body">
                                        {{ Form::open(array('files' => true, 'url' => route('cursos.task.edit', array($curs->id, $uf->id, $tasca->id)))) }}

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            {{ Form::label('name', 'Nom') }} (<span class='mandatory'>*</span>):
                                                            {{ Form::text("name", $tasca->name, array("class" => "form-control"))}}
                                                        </div>
                                                        <div class="form-group">
                                                            {{ Form::label('description', 'Descripció') }}:
                                                            {{ Form::textarea("description", $tasca->description, array("class" => "form-control"))}}
                                                        </div>
                                                        <div class="form-group">
                                                            {{ Form::label('data_finalització', 'Data de Finalització') }}:
                                                            {{ Form::date("data_finalització", null, array("class" => "form-control"))}}
                                                        </div>
                                                        <div class="form-group">
                                                            {{ Form::label('file', "Fitxer") }}(Límit 25MB):
                                                            {{ Form::file('file',null , array('class' => 'form-control'))}}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div>
                                                    {{ Form::submit('Editar', array('class' => 'btn btn-info')) }}
                                                </div>
                                            </div>
                                        </div>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
                <div class="panel-body">
                    <h2>{{$tasca->name}}</h2>

                    <h2>Descripció</h2>
                    <p>{{$tasca->description}}</p>
                    @if($tasca->file != "")
                        <object data="http://localhost/tasques/{{$curs->id}}/{{$uf->id}}/{{$tasca->file}}" type="application/pdf" width="100%" height="500px"></object>
                    @endif


                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2>Entrega de la tasca</h2>
                        @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())

                            <a style="text-align: right" href="{{route('cursos.task.entregables', array($curs->id, $uf->id, $tasca->id))}}">
                                <i style="font-size: 50px;" class="fa fa-file-pdf-o"></i>
                            </a>

                        @endif
                    </div>
                    <div class="panel-body">
                        <table class="table-responsive table table-bordered">
                            <tr>
                            <td>La tasca finalitza el {{date('d/m/y', strtotime($tasca->data_finalització))}}</td>
                            <?php
                            $now = Carbon\Carbon::now();
                            $deadline = $tasca->data_finalització;
                                if($now >= $deadline){
                                    echo "<td style='color:red'>La tasca està finalitzada. Si entregues tard afectarà a la nota.</td>";
                                }
                            ?>
                            </tr>
                            <tr>

                                    {{ Form::open(array('files' => true)) }}
                                <td>
                                        {{ Form::label('file', "Fitxer") }} (Límit 25MB):
                                </td>
                                <td>
                                        {{ Form::file('file', null)}}
                                        {{ Form::submit('Entregar') }}
                                    {{ Form::close() }}
                                </td>
                            </tr>


                                @if(!$entregat)
                                    <tr>
                                        <td>La tasca no ha estat entregada encara.</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>
                                            <a href="http://localhost/tasques/{{$curs->id}}/{{$uf->id}}/{{$entregable[0]->file}}"
                                               download="{{$entregable[0]->file}}">
                                                Fitxer entregat
                                            </a>
                                        </td>
                                    </tr>
                                    @if(!$entregable[0]->corregit)
                                    <tr>
                                        <td>La tasca ha sigut entregada però no corregida.</td>
                                    </tr>
                        </table>
                                @else
                                <div class="correccio">


                                    <table class="table table-responsive table-bordered">
                                        <th>
                                            <td>
                                                <h3 style="text-align: center">Correcció</h3>
                                            </td>
                                        </th>
                                        <tr>
                                            <td>Qualificació</td>
                                            <td>{{$entregable[0]->nota}}/10</td>
                                        </tr>
                                        <tr>
                                            <td>Comentaris</td>
                                            <td>{{$entregable[0]->explicacio}}</td>
                                        </tr>
                                    </table>
                                </div>
                                @endif
                            @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection