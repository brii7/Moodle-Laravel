@extends('layouts.app')


@section('content')

    <div class="row">

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>{{$curs->name}}</h1>
                    <h2>{{$uf->name}} {{$uf->description}}</h2>

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
                            {{ Form::file('file', null, array('class' => 'form-control'))}}
                            {{ Form::submit('Entregar', array('class' => 'btn btn-info')) }}
                            {{ Form::close() }}
                        @endif
                        @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                            <form class="form-horizontal" role="form" method="POST" action="corregir">
                                {!! csrf_field() !!}

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Nota (*)</label>

                                    <div class="col-md-2">
                                        <input type="number" class="form-control" name="nota" min="1" max="10" step="any">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Explicacio</label>

                                    <div class="col-md-5">
                                        <textarea class="form-control" name="explicacio"></textarea>
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
                        @endif

                        <div class="entregat">
                            @if($corregit == 0)

                                <p>La tasca no ha estat corregida encara.</p>

                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>

@endsection