@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">Nou Curs</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="">
                            {!! csrf_field() !!}

                            <div class="form-group">
                                <label class="col-md-4 control-label">Nom</label>

                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Descripció</label>

                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="description">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Data de Finalització</label>

                                <div class="col-md-5">
                                    <input type="date" class="form-control" name="data_finalització">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-suitcase"></i>Crear
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
