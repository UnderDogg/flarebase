@extends('layouts.master')
@section('heading')
    <h1>All tickets</h1>
@stop

@section('content')
    <table class="table table-hover table-bordered table-striped" id="tickets-table">
        <thead>
        <tr>

            <th>Ticket NR</th>
            <th>Subject</th>
            <th>fk_relation_id</th>
            <th>priority_id</th>
            <th>Created at</th>
            <th>DEdline</th>
            <th>Assigned</th>

        </tr>
        </thead>


        <tfoot>
        <tr>

            <th>Ticket NR</th>
            <th>Subject</th>
            <th>fk_relation_id</th>
            <th>priority_id</th>
            <th>Created at</th>
            <th>DEdline</th>
            <th>Assigned</th>


        </tr>
        </tfoot>
    </table>
@stop

@push('scripts')
<script>
    $(function () {
        $('#tickets-table').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 50,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            ajax: '{!! route('tickets.data') !!}',
            columns: [
                {data: 'ticketnumber', name: 'ticket_number'},
                {data: 'ticketsubjectlink', name: 'subject'},
                {data: 'fk_relation_id', name: 'fk_relation_id'},
                {data: 'priority_id', name: 'priority_id'},
                {data: 'created_at', name: 'created_at'},
                {data: 'deadline', name: 'deadline'},
                {data: 'assigned_to_staff_id', name: 'assigned_to_staff_id'},
            ]
        });
    });
</script>
@endpush