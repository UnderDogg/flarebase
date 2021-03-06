@extends('tickets.ticketlayouts.ticketmaster')
@extends('themes.default1.agent.layout.sidebar')    
@section('pages')
    active
@stop
@section('all-pages')
    class="active"
@stop
@section('content')
<div class="box box-primary">
<div class="box-header">
    <h2 class="box-title">{{Lang::get('knowledgebase::lang.pages')}}</h2></div>
<div class="box-body ">
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
<div class="row">
<div class="col-sm-12">
        {!! Datatable::table()
            ->addColumn(Lang::get('knowledgebase::lang.name'),
                        Lang::get('knowledgebase::lang.created'),
                        Lang::get('knowledgebase::lang.action'))       // these are the column headings to be shown
            ->setUrl(route('api.page'))   // this is the route where data will be retrieved
            ->render() !!}
    </div>
    </div>
    </div>
    </div>

@stop