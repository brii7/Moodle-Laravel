@extends('layouts.app')

@section('content')

        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">Dashboard</div>

                        <div class="panel-body">
                            Welcome to your dashboard.
                        </div>
                        <div class="panel-body">
                            <a href=""><button type="button" class="btn btn-primary">Edit your profile</button></a>
                            <a href=""><button type="button" class="btn btn-primary">View your tasks</button></a>
                            <a href=""><button type="button" class="btn btn-primary">Change your password</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
