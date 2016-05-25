@extends('layouts.app')


@section('content')

    <div class="row">

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>{{$curs->name}}</h1>
                    <h2>{{$uf->name}} {{$uf->description}}</h2>

                    <a href="{{route('cursos.show', array($curs->id))}}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn fa-arrow-left"></i>Tornar al curs
                        </button>
                    </a>

                </div>
                <div class="panel-body">
                    <h2>{{$tasca->name}}</h2>

                    <h2>Descripció</h2>
                    <p>{{$tasca->description}}</p>

                    <object data="http://localhost/tasques/{{$curs->id}}/{{$uf->id}}/{{$tasca->file}}" type="application/pdf" width="100%" height="500px"></object>


                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2>Entrega de la tasca</h2>
                        @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())

                            <a href="{{route('cursos.task.entregables', array($curs->id, $uf->id, $tasca->id))}}">
                                ENTREGABLES
                            </a>

                        @endif
                    </div>
                    <div class="panel-body">
                        La tasca finalitza el {{date('d/m/y', strtotime($tasca->data_finalització))}}
                        <?php
                        $now = Carbon\Carbon::now();
                        $deadline = $tasca->data_finalització;
                            if($now >= $deadline){
                                echo "<p style='color:red'>La tasca està finalitzada. Si entregues tard afectarà a la nota.</p>";
                            }
                        ?>
                        @if(Auth::user()->isAdmin() || Auth::user()->isStudent())
                            {{ Form::open(array('files' => true)) }}
                                {{ Form::label('file', "Fitxer") }} (Límit 25MB):
                                {{ Form::file('file', null)}}
                                {{ Form::submit('Entregar') }}
                            {{ Form::close() }}
                        @endif

                        <div class="entregat">
                            @if(!$entregat)
                                <p>La tasca no ha estat entregada encara.</p>
                            @else
                                <a href="http://localhost/tasques/{{$curs->id}}/{{$uf->id}}/{{$entregable[0]->file}}"
                                   download="{{$entregable[0]->file}}">
                                    Fitxer entregat
                                </a>

                                @if(!$entregable[0]->corregit)

                                <p>La tasca ha sigut entregada però no corregida.</p>

                                @else

                                <h3>Informació de la correcció de l'alumne {{Auth::user()->name}}:</h3>
                                <p style="font-weight: bold; font-size: 16px">Nota: {{$entregable[0]->nota}}/10</p>
                                <h4>Feedback: </h4><p>{{$entregable[0]->explicacio}}</p>

                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection