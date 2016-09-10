@extends('layouts.master')
@section('heading')
  <script>$('#pagination a').on('click', function (e) {
      e.preventDefault();
      var url = $('#search').attr('action') + '?page=' + page;
      $.post(url, $('#search').serialize(), function (data) {
        $('#posts').html(data);
      });
    });</script>
  @stop

  @section('content')
  @include('partials.userheader')
    <!-- *********************************************************************
     *                 Header end and top ticket start
     *********************************************************************-->
  <div class="row">
    <div class="col-lg-6 currentticket">


      <table class="table table-hover table-bordered table-striped" id="openticket-table">
        <h3>Open Tickets</h3>
        <thead>
        <tr>

          <th>Name</th>
          <th>Created at</th>
          <th>Deadline</th>

        </tr>
        </thead>
      </table>


    </div>
    <!-- *********************************************************************
       *                     Open ticket end, Closed ticket start
       *********************************************************************-->
    <div class="col-lg-6 currentticket">


      <table class="table table-hover table-bordered table-striped" id="closedticket-table">
        <h3>Closed Tickets</h3>
        <thead>
        <tr>

          <th>Name</th>
          <th>Created at</th>
          <th>Deadline</th>

        </tr>
        </thead>
      </table>

    </div>
    <!-- *********************************************************************
       *               Closed ticket end assigned relations start
       *********************************************************************-->


    <div class="col-lg-8 currentticket">


      <table class="table table-hover table-bordered table-striped" id="relations-table">
        <h3>Assigned Relations</h3>
        <thead>
        <tr>

          <th>Name</th>
          <th>Company</th>
          <th>Number</th>


        </tr>
        </thead>
      </table>
    </div>
    <!-- *********************************************************************
  *               assigned relations end, Last 10 created ticket start
  *********************************************************************-->

    <div class="col-lg-4 currentticket">

      <table class="table table-hover table-bordered table-striped">
        <h3>Last 10 created tickets</h3>
        <thead>
        <thead>
        <tr>
          <th>Title</th>
          <th>Created at</th>
          <th>Deadline</th>
        </tr>
        </thead>
        <tbody>

        @foreach($user->ticketsCreated as $ticket)

          <tr>
            <td>
              <a href="{{ route('tickets.show', $ticket->id)}}">
                {{ $ticket->title }}
              </a></td>
            <td>{{date('d, M Y', strTotime($ticket->created_at))}} </td>
            <td>{{date('d, M Y', strTotime($ticket->deadline))}}</td>
          </tr>
        @endforeach
        </tbody>
      </table>

    </div>


    @stop
    @push('scripts')
    <script>
      $(function () {
        $('#openticket-table').DataTable({
          processing: true,
          serverSide: true,
          "pageLength": 50,
          "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
          ajax: '{!! route('users.ticketdata', ['id' => $user->id]) !!}',
          columns: [
            {data: 'titlelink', name: 'title'},
            {data: 'created_at', name: 'created_at'},
            {data: 'deadline', name: 'deadline'},
          ]
        });
      });
    </script>

    <script>
      $(function () {
        $('#relations-table').DataTable({
          processing: true,
          serverSide: true,
          "pageLength": 50,
          "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
          ajax: '{!! route('users.relationdata', ['id' => $user->id]) !!}',
          columns: [
            {data: 'relationlink', name: 'name'},
            {data: 'company_name', name: 'company_name'},
            {data: 'primary_number', name: 'primary_number'},

          ]
        });
      });
    </script>
    <script>
      $(function () {
        $('#closedticket-table').DataTable({
          processing: true,
          serverSide: true,
          "pageLength": 50,
          "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
          ajax: '{!! route('users.closedticketdata', ['id' => $user->id]) !!}',
          columns: [
            {data: 'titlelink', name: 'title'},
            {data: 'created_at', name: 'created_at'},
            {data: 'deadline', name: 'deadline'},
          ]
        });
      });
    </script>
  @endpush
