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
                                {{ Form::file('file', null)}}
                                {{ Form::submit('Entregar') }}
                            {{ Form::close() }}
                        @endif

                        <div class="entregat">
                            @if(!$entregable[0]->corregit)

                                <p>La tasca no ha estat corregida encara.</p>

                            @else

                                <h2>Informació de la correcció:</h2>

                                <h3>Nota: </h3><p>$entregable[0]->nota</p>
                                <h3>Correcció: </h3><p>$entregable[0]->explicacio</p>
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        </div>

@endsection