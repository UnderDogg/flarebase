@extends('layouts.master')
@section('heading')
<h1>All Leads</h1>
@stop

@section('content')
  <table class="table table-hover table-bordered table-striped" id="leads-table">
        <thead>
            <tr>
                
                <th>Name</th>
                <th>Created by</th>
                <th>Deadline</th>
                <th>Assigned</th>
               
            </tr>
        </thead>
    </table>
@stop

@push('scripts')
<script>
$(function() {
    $('#leads-table').DataTable({
        processing: true,
        serverSide: true,
      "pageLength": 50,
      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        ajax: '{!! route('leads.data') !!}',
        columns: [
            
            { data: 'titlelink', name: 'title' },
            { data: 'fk_staff_id_created', name: 'fk_staff_id_created'},
             {data: 'contact_date', name: 'contact_date', },
            { data: 'assigned_to_staff_id', name: 'assigned_to_staff_id' },
           
        
        ]
    });
});
</script>
@endpush