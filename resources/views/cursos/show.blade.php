@extends('layouts.app')


@section('content')

    <div class="row">

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>{{$curs->name}}</h1>
                    @if(Auth::user()->isAdmin())
                        <a href="{{route('cursos.newuf', [$curs->id])}}">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-plus"></i>Afegir Unitat Formativa
                            </button>
                        </a>
                    @endif
                </div>
                <div class="panel-body">

                    <h2>Descripció</h2>
                    <p>{{$curs->description}}</p>

                    @if(count($curs->UFs) > 0)

                        <h2>Tasques</h2>
                        <div class="ufs">
                            @foreach($curs->UFs as $uf)
                                <div id="{{$uf->name}}" class="uf">
                                    <ul>
                                        <h3>{{$uf->name}}</h3>
                                        <h4>{{$uf->description}}</h4>
                                        <h5>Finalitza el: {{date('d/m/y', strtotime($uf->data_finalització))}}</h5>
                                        @if(count($uf->tasks) > 0)
                                            @foreach($uf->tasks as $task)
                                                <h5>Tasques:</h5>
                                                <a href="{{route('courses.task.show')}}">{{$task->name}}</a>
                                            @endforeach
                                            @else
                                                <h5>Aquesta unitat formativa no té tasques.</h5>
                                        @endif
                                        @if(Auth::user()->isAdmin())
                                            <a href="{{route('cursos.task.add', [$curs->id, 'uf_id' => $uf->id])}}">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-btn fa-plus"></i>Afegir Tasca
                                                </button>
                                            </a>
                                        @endif
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <h2>No hi ha unitats formatives en aquest curs.</h2>
                    @endif



                </div>
            </div>
    </div>

@endsection