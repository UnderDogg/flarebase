@extends('core::adminlayouts.adminmaster')
<link href="{{asset("lb-faveo/css/faveo-css.css")}}" rel="stylesheet" type="text/css"/>
@section('Settings')
    active
@stop

@section('settings-bar')
    active
@stop

@section('company')
    class="active"
    @stop

    @section('HeadInclude')
    @stop
            <!-- header -->
    @section('PageHeader')

    @stop
            <!-- /header -->
    <!-- breadcrumbs -->
@section('breadcrumbs')
    <ol class="breadcrumb">

    </ol>
    @stop
            <!-- /breadcrumbs -->
    <!-- content -->
    @section('content')

            <!-- open a form -->

    {!! Form::model($companies,['url' => 'postcompany/'.$companies->id, 'method' => 'PATCH','files'=>true]) !!}
    <!-- table  -->

    <div class="box box-primary">
        <div class="box-header">
            <h4 class="box-title">{{Lang::get('core::lang.company')}}</h4>{!! Form::submit(Lang::get('core::lang.save'),['class'=>'form-group btn btn-primary pull-right'])!!}
        </div>

        <!-- check whether success or not -->
        @if(Session::has('success'))
            <div class="alert alert-success alert-dismissable">
                <i class="fa  fa-check-circle"></i>
                <b>Success!</b>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {!!Session::get('success')!!}
            </div>
            @endif
                    <!-- failure message -->
            @if(Session::has('fails'))
                <div class="alert alert-danger alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <b>Fail!</b>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {!!Session::get('fails')!!}
                </div>
                @endif

                        <!-- Name text form Required -->
                <div class="box-body">
                    <div class="row">

                        {{-- <div class="row"> --}}
                        <div class="col-md-4">
                            <!-- comapny name -->
                            <div class="form-group">

                                {!! Form::label('company_name',Lang::get('core::lang.name')) !!}
                                {!! Form::text('company_name',$companies->company_name,['class' => 'form-control']) !!}
                            </div>
                        </div>


                        <div class="col-md-4">
                            <!-- website -->
                            <div class="form-group">
                                {!! Form::label('website',Lang::get('core::lang.website')) !!}
                                {!! Form::url('website',$companies->website,['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- phone -->
                            <div class="form-group">
                                {!! Form::label('phone',Lang::get('core::lang.phone')) !!}
                                {!! Form::text('phone',$companies->phone,['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <!-- comapny address -->
                            <div class="form-group">

                                {!! Form::label('address',Lang::get('core::lang.address')) !!}
                                {!! Form::textarea('address',$companies->address,['class' => 'form-control','size' => '30x5']) !!}

                            </div>
                        </div>

                        {{-- <div class="col-md-4"> --}}
                                <!-- landing page -->
                        {{-- <div class="form-group"> --}}

                        {{-- {!! Form::label('landing_page',Lang::get('core::lang.landing')) !!} --}}
                        {{-- {!!Form::select('landing_page', ['landing page'],null,['class' => 'form-control select']) !!} --}}

                        {{-- </div> --}}
                        {{-- </div> --}}

                        {{-- <div class="col-md-4"> --}}
                                <!-- offline page -->
                        {{-- <div class="form-group"> --}}

                        {{-- {!! Form::label('offline_page',Lang::get('core::lang.offline')) !!} --}}
                        {{-- {!!FooterIncluderm::select('offline_page', ['offline page'],null,['class' => 'form-control select']) !!} --}}

                        {{-- </div> --}}
                        {{-- </div> --}}

                        {{-- <div class="col-md-4"> --}}
                                <!-- thank page -->
                        {{-- <div class="form-group"> --}}

                        {{-- {!! Form::label('thank_page',Lang::get('core::lang.thank')) !!} --}}
                        {{-- {!! Form::select('thank_page', ['thank page'],null,['class' => 'form-control select']) !!} --}}

                        {{-- </div> --}}
                        {{-- </div> --}}

                        <div class="col-md-2">
                            <!-- logo -->

                            {!! Form::label('logo',Lang::get('core::lang.logo')) !!}
                            <div class="btn bg-olive btn-file" style="color:blue"> Upload file
                                {!! Form::file('logo') !!}
                            </div>

                        </div>
                        <div id="logo-display" style="display: block;">
                            @if($companies->logo != null)
                                <div class="col-md-2">
                                    {!! Form::checkbox('use_logo') !!} <label> Use Logo</label>
                                </div>
                            @endif

                            <?php  $company = Modules\Core\Models\Company::where('id', '=', '1')->first(); ?>

                            @if($companies->logo != null)
                                <div class="col-md-2 image" data-content="{{Lang::get('core::lang.click-delete')}}">
                                    <img src="{{asset('lb-faveo/media/company')}}{{'/'}}{{$company->logo}}"
                                         alt="User Image" id="company-logo" width="100px"
                                         style="border:1px solid #DCD1D1"/>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
    </div>
    <!-- Modal -->
    <div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="false" style="display: none; padding-right: 15px;background-color: rgba(0, 0, 0, 0.7);">
        <div class="modal-dialog" role="document">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close closemodal" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                    </div>
                    <div class="modal-body" id="custom-alert-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary pull-left yes" data-dismiss="modal"></button>
                        <button type="button" class="btn btn-default no"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $(".image").on("click", function () {
                $("#myModal").css("display", "block");
                $("#myModalLabel").html("{!! Lang::get('core::lang.delete-logo') !!}");
                $(".yes").html("{!! Lang::get('core::lang.yes') !!}");
                $(".no").html("{{Lang::get('core::lang.cancel')}}");
                $("#custom-alert-body").html("{{Lang::get('core::lang.confirm')}}");
            });
            $('.no,.closemodal').on("click", function () {
                $("#myModal").css("display", "none");
            });
            $('.yes').on('click', function () {
                var src = $('#company-logo').attr('src').split('/');
                var file = src[src.length - 1];

                var path = "lb-faveo/media/company/" + file;
                // alert(path); 
                $.ajax({
                    type: "GET",
                    url: "{{route('delete.logo')}}",
                    dataType: "html",
                    data: {data1: path},
                    success: function (data) {
                        if (data == "true") {
                            var msg = "Logo deleted succesfully."
                            $("#logo-display").css("display", "none");
                            $("#myModal").css("display", "none");
                        } else {
                            $("#myModal").css("display", "none");
                        }
                    }
                });
            });
        });
    </script>
@stop