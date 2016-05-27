@extends('layouts.app')

@section('content')
<table class="table table-bordered" id="users-table">
    <thead>
    <tr>
        <th>Id</th>
        <th>Nom</th>
        <th>Email</th>
        <th>Data d'alta</th>
    </tr>
    </thead>
</table>
@stop

@push('scripts')
<script>
    $(function() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('datatables.data') !!}',
            columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'created_at', name: 'created_at' }
        ]
    });
    });
</script>
@endpush