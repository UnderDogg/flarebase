@extends('themes.default1.agent.layout.agent')

@section('Users')
class="active"
@stop

@section('user-bar')
active
@stop

@section('organizations')
class="active"
@stop

<!-- content -->
@section('content')

<div class="box box-primary">
    <div class="box-header">
        <h2 class="box-title">{{Lang::get('lang.organization')}}</h2><a href="{{route('organizations.create')}}" class="btn btn-primary pull-right">{{Lang::get('lang.create_organization')}}</a></div>
    <div class="box-body">
        <!-- check whether success or not -->
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"></i>
            <b>Success</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>Fail!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif

        <table id="users-table" class="table table-condensed">
          <thead>
          <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Website</th>
            <th>Phone</th>
            <th>Action</th>
          </tr>
          </thead>
        </table>
    </div>
</div>

<script>
  $('#users-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route('org.list') }}',
    columns: [
      {data: 'id', name: 'id'},
      {data: 'name', name: 'name'},
      {data: 'email', name: 'email'},
      {data: 'created_at.date', name: 'created_at'},
      {data: 'updated_at.date', name: 'updated_at'}
    ]
  });
</script>



@endsection



<!-- /content -->
