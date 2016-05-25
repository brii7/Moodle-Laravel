@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">Nova Tasca</div>
                    <div class="panel-body">
                        <h3 style="margin-top: -5px; margin-bottom: 30px;"> {{$curs->name}} - {{$uf->name}}</h3>
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
                                            {{ Form::label('description', 'Descripció') }}(<span class='mandatory'>*</span>):
                                            {{ Form::textarea('description', null, array('class' => 'form-control'))}}

                                        </div>

                                        <div class="form-group">
                                            {{ Form::label('file', "Fitxer d'enunciat") }} (Si es vol vista prèvia, ha de ser un PDF)(Límit 25MB):
                                            {{ Form::file('file', null, array('class' => 'form-control'))}}

                                        </div>

                                        <div class="form-group">
                                            {{ Form::label('data_finalització', 'Data de finalització') }}:
                                            {{ Form::date('data_finalització', null, array('class' => 'form-control'))}}
                                        </div>

                                    </div>
                                </div>

                                <div>
                                    {{ Form::submit('Crear', array('class' => 'btn btn-info')) }}

                                </div>
                            </div>
                        </div>

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
