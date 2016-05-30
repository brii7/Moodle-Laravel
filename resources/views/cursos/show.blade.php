@extends('layouts.app')


@section('content')

    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>{{$curs->name}}</h1>
                    <a href="{{route('cursos')}}">
                        <button type="submit" class="btn-primary">
                            <i class="fa fa-btn fa-arrow-left"></i>
                        </button>
                    </a>
                    @if(Auth::user()->isAdmin())
                        <a href="{{route('cursos.newuf', [$curs->id])}}">
                            <button type="submit" class="btn-primary">
                                <i class="fa fa-btn fa-plus"></i>Afegir UF
                            </button>
                        </a>
                        <button style="float:right" type="button" class="btn-warning" data-toggle="modal"
                                data-target="#editCurs{{$curs->id}}">
                            <i class="fa fa-pencil"></i>
                        </button>
                        <div id="editCurs{{$curs->id}}" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Editar {{$curs->name}}</h4>
                                    </div>
                                    <div class="modal-body">
                                        {{ Form::open(array('url' => route('cursos.edit', array($curs->id)))) }}

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            {{ Form::label('name', 'Nom') }} (<span class='mandatory'>*</span>):
                                                            {{ Form::text("name", $curs->name, array("class" => "form-control"))}}
                                                        </div>
                                                        <div class="form-group">
                                                            {{ Form::label('description', 'Descripció') }}:
                                                            {{ Form::textarea("description", $curs->description, array("class" => "form-control"))}}
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-4 control-label">Professor: </label>

                                                            <div class="col-md-6">
                                                                <select name="teacher_id">
                                                                    @foreach($professors as $professor)
                                                                        <option value="{{$professor->id}}">{{$professor->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
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

                    <h2>Descripció</h2>
                    <p>{{$curs->description}}</p>

                    @if(count($curs->UFs) > 0)
                        <div class="ufs">
                            @foreach($curs->UFs as $uf)
                                <div id="{{$uf->name}}" class="uf panel panel-default">

                                        <div class="panel-heading">
                                            <h1>{{$uf->name}}</h1>
                                            <h4>{{$uf->description}}</h4>
                                            <h5>Finalitza el: {{date('d/m/y', strtotime($uf->data_finalització))}}</h5>
                                            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())

                                                <form style="float:right;" action="{{route('cursos.uf.delete', array($curs->id, $uf->id))}}" method="POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit" id="delete-uf-{{ $uf->id }}" class="btn-danger">
                                                            <i class="fa fa-close"></i>
                                                        </button>
                                                </form>


                                                <button style="float:right" type="button" class="btn-warning" data-toggle="modal"
                                                        data-target="#editUF{{$uf->id}}">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                                <div id="editUF{{$uf->id}}" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">Editar {{$uf->name}}</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                {{ Form::open(array('url' => route('cursos.uf.edit', array($curs->id, $uf->id)))) }}

                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="panel panel-default">
                                                                            <div class="panel-body">
                                                                                <div class="form-group">
                                                                                    {{ Form::label('name', 'Nom') }} (<span class='mandatory'>*</span>):
                                                                                    {{ Form::text("name", $uf->name, array("class" => "form-control"))}}
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    {{ Form::label('description', 'Descripció') }}:
                                                                                    {{ Form::textarea("description", $uf->description, array("class" => "form-control"))}}
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    {{ Form::label('data_finalització', 'Data de finalització') }}:
                                                                                    {{ Form::date('data_finalització', $uf->data_finalització, array('class' => 'form-control'))}}
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


                                                <button type="button" data-toggle="modal"
                                                        data-target="#modalApunts{{$uf->id}}">Afegir Apunts
                                                </button>
                                                <div id="modalApunts{{$uf->id}}" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">Afegir apunts</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                {{ Form::open(array('files' => true)) }}

                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="panel panel-default">
                                                                            <div class="panel-body">
                                                                                <div class="form-group">
                                                                                    {{ Form::label('name', 'Nom') }} (<span class='mandatory'>*</span>):
                                                                                    {{ Form::text("name", null, array("class" => "form-control", 'placeholder' => 'Nom'))}}
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <input type="hidden" class="form-control"
                                                                                           name="uf_id" value="{{$uf->id}}">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    {{ Form::label('file', "Fitxer") }}(Límit 25MB):
                                                                                    {{ Form::file('file', null, array('class' => 'form-control'))}}
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div>
                                                                            {{ Form::submit('Afegir', array('class' => 'btn btn-info')) }}

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
                                            <ul style="margin-left: -30px">
                                                @if(count($uf->apunts) > 0)
                                                    <h3>Apunts:</h3>
                                                    @foreach($uf->apunts as $apunt)
                                                        <li style="margin: 5px; padding: 0.2em;font-size: 18px;"><i class="fa fa-file-pdf-o" style="margin-right: 5px;"></i>
                                                        <a href="http://localhost/apunts/{{$curs->id}}/{{$uf->id}}/{{$apunt->file}}">{{$apunt->name}}</a>
                                                            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                                                                <form style="float:left; margin-right: 10px;" action="{{route('cursos.apunt.delete', array($curs->id, $uf->id, $apunt->id))}}" method="POST">
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('DELETE') }}
                                                                    <button type="submit" id="delete-aupnt-{{ $apunt->id }}" class="btn-danger">
                                                                        <i class="fa fa-close"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                @else
                                                    <li><h5>Aquesta unitat formativa no té apunts.</h5></li>
                                                @endif
                                            </ul>
                                            <ul style="margin-left: -30px">
                                                @if(count($uf->tasks) > 0)
                                                    <h3>Tasques:</h3>
                                                    @foreach($uf->tasks as $task)
                                                        <li style="margin: 5px; padding: 0.2em;font-size: 18px;"><i class="fa fa-pencil-square-o " style="margin-right: 5px;"></i>
                                                            <a href="{{route('cursos.task.show', [$curs->id, $uf->id, $task->id])}}">{{$task->name}}</a>
                                                            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                                                                <form style="float:left; margin-right: 10px;" action="{{route('cursos.task.delete', array($curs->id, $uf->id, $task->id))}}" method="POST">
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('DELETE') }}
                                                                    <button type="submit" id="delete-aupnt-{{ $apunt->id }}" class="btn-danger">
                                                                        <i class="fa fa-close"></i>
                                                                    </button>
                                                                </form>
                                                                <a href="{{route('cursos.task.entregables', array($curs->id, $uf->id, $task->id))}}">
                                                                    <i class="fa fa-file-pdf-o "></i>
                                                                </a>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                    @else
                                                        <li><h5>Aquesta unitat formativa no té tasques.</h5></li>
                                                @endif
                                            </ul>
                                            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                                                <a href="{{route('cursos.task.create', [$curs->id, $uf->id])}}">
                                                    <button>
                                                        <i class="fa fa-btn fa-plus"></i>Afegir Tasca
                                                    </button>
                                                </a>
                                            @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <h2>No hi ha unitats formatives en aquest curs.</h2>
                    @endif



                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script src="/js/scriptcurs.js"></script>
@endsection