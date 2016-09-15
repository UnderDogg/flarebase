@extends('core::adminlayouts.adminmaster')

@section('content')

  <div class="col-lg-12 departments">

    <table class="table table-hover table-bordered table-striped">
      <h3>Allos Departmentos</h3>
      <thead>
      <thead>
      <tr>
        <th>Title</th>
        <th>Description</th>
        @if(Entrust::hasRole('administrator'))
          <th>Action</th>
        @endif
      </tr>
      </thead>
      <tbody>

      @foreach($department as $dep)

        <tr>
          <td>{{$dep->name}}</td>
          <td>{{Str_limit($dep->description, 50)}}</td>
          @if(Entrust::hasRole('administrator'))
            <td>   {!! Form::open([
              'method' => 'DELETE',
              'route' => ['departments.destroy', $dep->id]
            ]) !!}

              {!! Form::submit('Delete', ['class' => 'btn btn-danger', 'onclick' => 'return confirm("Are you sure?")']) !!}

              {!! Form::close() !!}</td></td>
          @endif
        </tr>
      @endforeach

      </tbody>
    </table>

  </div>

@stop