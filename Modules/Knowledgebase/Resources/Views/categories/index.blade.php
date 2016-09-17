@extends('knowledgebase::kblayouts.kbmaster')
@extends('knowledgebase::kblayouts.sidebar')

@section('KbCategories')
    active
@stop

@section('dashboard-bar')
    active
@stop

@section('KbCategories')
    class="active"
@stop


@section('HeadInclude')
@stop
            <!-- header -->
@section('PageHeader')
    <h1>{{Lang::get('core::lang.staff')}}</h1>

    @stop
            <!-- /header -->
    <!-- breadcrumbs -->
@section('breadcrumbs')
    <ol class="breadcrumb">

    </ol>
    @stop
            <!-- /breadcrumbs -->







  
@section('category')
    active
@stop
@section('all-category')
    class="active"
@stop
<!-- content -->
@section('content')
<div class="box box-primary">
<div class="box-header">
    <h2 class="box-title">{{Lang::get('knowledgebase::lang.category')}}</h2></div>
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



    <h2>{!! Lang::get('core::lang.staff') !!}</h2><a href="{{route('staff.create')}}"
                                                          class="btn btn-primary pull-right">{{Lang::get('core::lang.create_staffmember')}}</a></h2>

<div class="row">
    <div class="col-sm-12">
    <table class="table table-hover table-bordered table-striped" id="categories-table">
        <thead>
        <tr>
            <th>Category Name</th>
            <th>Created</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Category Name</th>
            <th>Created</th>
            <th>Actions</th>
        </tr>
        </tfoot>
    </table>

    </div>
</div>


@stop
        @push('scripts')
        <script>
            $(function () {
                $('#categories-table').DataTable({
                    processing: true,
                    serverSide: true,
                    "pageLength": 50,
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    ajax: '{!! route('kbcategories.data') !!}',
                    columns: [
                        {data: 'categorynamelink', name: 'name'},
                        {data: 'parentnamelink', name: 'email'},
                        {data: 'actions', name: 'actions', orderable: false, searchable: false},
                    ]
                });
            });
        </script>
@endpush