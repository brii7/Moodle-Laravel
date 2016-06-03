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
                    @foreach($cursosarray as $curs)
                        <h2 style="margin-top: 40px;">{{$curs->name}}</h2>
                        @foreach($curs->UFs as $uf)

                            <h3>{{$uf->name}}</h3>
                            <table style="margin-top: 10px; margin-bottom: 30px" class="table table-responsive table-bordered uf">
                                <th style="width:60%">Tasca</th>
                                <th>Entregat tard</th>
                                <th>Nota</th>
                                @foreach($uf->tasks as $tasca)
                                    <tr>
                                        <td>
                                            {{\App\Task::find($tasca->id)->name}}
                                        </td>
                                        @if(DB::table('user_task')->where('task_id',$tasca->id)->where('user_id',$user->id)->value('entregat_tard'))

                                            <td style="color:red">
                                                Sí.
                                            </td>

                                        @else

                                            <td>
                                                No.
                                            </td>

                                        @endif
                                        @if(DB::table('user_task')->where('task_id',$tasca->id)->where('user_id',$user->id)->value('corregit'))

                                            <td class="nota">
                                                {{DB::table('user_task')->where('task_id',$tasca->id)->where('user_id',$user->id)->value('nota')}}
                                            </td>

                                        @elseif(!DB::table('user_task')->where('task_id',$tasca->id)->where('user_id',$user->id)->value('corregit'))

                                            <td class="noentregat" style="color:red">No corregit.</td>

                                        @endif
                                    </tr>
                                @endforeach
                                <tr style="font-weight: bold">
                                    <td colspan="2">Nota final</td>
                                    <td  class="notafinal"></td>
                                </tr>
                            </table>
                        @endforeach

                    @endforeach
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="/js/scriptnotes.js"></script>
@endsection