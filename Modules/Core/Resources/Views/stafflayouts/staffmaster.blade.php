<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" ng-app="myApp">
        <title>Faveo | HELP DESK</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta name="_token" content="{!! csrf_token() !!}"/>
        <!-- faveo favicon -->
        <link href="{{asset("lb-faveo/media/images/favicon.ico")}}" rel="shortcut icon">
        <!-- Bootstrap 3.3.2 -->
        <link href="{{asset("lb-faveo/css/bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="{{asset("lb-faveo/css/font-awesome.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="{{asset("lb-faveo/css/ionicons.min.css")}}" rel="stylesheet"  type="text/css" />
        <!-- Theme style -->
        <link href="{{asset("lb-faveo/css/AdminLTE.css")}}" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
        <link href="{{asset("lb-faveo/css/skins/_all-skins.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <link href="{{asset("lb-faveo/plugins/iCheck/flat/blue.css")}}" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <link href="{{asset("lb-faveo/css/tabby.css")}}" rel="stylesheet" type="text/css"/>
        
        <link href="{{asset("lb-faveo/css/jquerysctipttop.css")}}" rel="stylesheet" type="text/css"/>
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

        <link href="{{asset("lb-faveo/css/editor.css")}}" rel="stylesheet" type="text/css"/>

        <link href="{{asset("lb-faveo/css/jquery.ui.css")}}" rel="stylesheet" rel="stylesheet"/>
        
        <link href="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.css")}}" rel="stylesheet"  type="text/css"/>
        
        <link href="{{asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")}}" rel="stylesheet" type="text/css"/>

        <link href="{{asset("lb-faveo/css/faveo-css.css")}}" rel="stylesheet" type="text/css" />
        
        <link href="{{asset("lb-faveo/css/notification-style.css")}}" rel="stylesheet" type="text/css" >
        
        <link href="{{asset("lb-faveo/css/jquery.rating.css")}}" rel="stylesheet" type="text/css" />
        <!-- Select2 -->
        <link href="{{asset("lb-faveo/plugins/select2/select2.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- autocomplete -->
        <link href="{{asset("lb-faveo/css/autocomplete.css")}}" rel="stylesheet" type="text/css" />
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <script src="{{asset("lb-faveo/js/jquery-2.1.4.js")}}" type="text/javascript"></script>
        
        <script src="{{asset("lb-faveo/js/jquery2.1.1.min.js")}}" type="text/javascript"></script>

        @yield('HeadInclude')
    </head>















<body class="skin-yellow fixed">
<div class="wrapper">
    <header class="main-header">
        <a href="http://www.faveohelpdesk.com" class="logo"><img src="{{ asset('lb-faveo/media/images/logo.png')}}" width="100px;"></a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="collapse navbar-collapse" id="navbar-collapse">

                <ul class="tabs tabs-horizontal nav navbar-nav navbar-left">
                    <li @yield('Dashboard')><a data-target="#tabA" href="#">{!! Lang::get('core::lang.dashboard') !!}</a></li>
                    <li @yield('Users')><a data-target="#tabB" href="#">{!! Lang::get('core::lang.users') !!}</a></li>
                    <li @yield('Tickets')><a data-target="#tabC" href="#">{!! Lang::get('core::lang.tickets') !!}</a></li>
                    <li @yield('Tools')><a data-target="#tabD" href="#">{!! Lang::get('core::lang.tools') !!}</a></li>

                </ul>


                <ul class="nav navbar-nav navbar-right">
                    @if(Auth::guard('staff')->user()->role == 'admin')
                    <li><a href="{{url('admin')}}">{!! Lang::get('core::lang.admin_panel') !!}</a></li>
                    @include('themes.default1.update.notification')
                    @endif
                    <!-- User Account: style can be found in dropdown.less -->


                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                @if(Auth::guard('staff')->user())
                                <img src="{{Auth::guard('staff')->user()->profile_pic}}"class="user-image" alt="User Image"/>
                                <span class="hidden-xs">{{Auth::guard('staff')->user()->first_name." ".Auth::guard('staff')->user()->last_name}}</span>
                                @endif
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header" style="background-color:#343F44;">
                                    <img src="{{Auth::guard('staff')->user()->profile_pic}}" class="img-circle" alt="User Image" />
                                    <p>
                                        {{Auth::guard('staff')->user()->first_name." ".Auth::guard('staff')->user()->last_name}} - {{Auth::guard('staff')->user()->role}}
                                        <small></small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer" style="background-color:#1a2226;">
                                    <div class="pull-left">
                                        <a href="{{URL::route('staff.profile')}}" class="btn btn-info btn-sm"><b>{!! Lang::get('core::lang.staffprofile') !!}</b></a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{url('staff/logout')}}" class="btn btn-danger btn-sm"><b>{!! Lang::get('core::lang.sign_out') !!}</b></a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar" style="height: auto;">

<ul id="side-bar" class="sidebar-menu">
                @yield('sidebar')
                <li class="header">{!! Lang::get('tickets::lang.tickets') !!}</li>
                <?php


                /*      if (Auth::guard('staff')->user()->role == 'admin') {
                        //$inbox = Modules\Core\Models\Ticket\Tickets::all();
                        $myticket = Modules\Core\Models\Ticket\Tickets::where('assigned_to', Auth::guard('staff')->user()->id)->where('status', '1')->get();
                        $unassigned = Modules\Core\Models\Ticket\Tickets::where('assigned_to', '=', null)->where('status', '=', '1')->get();
                        $tickets = Modules\Core\Models\Ticket\Tickets::where('status', '1')->get();
                        $deleted = Modules\Core\Models\Ticket\Tickets::where('status', '5')->get();
                      } elseif (Auth::guard('staff')->user()->role == 'agent') {
                        //$inbox = Modules\Core\Models\Ticket\Tickets::where('dept_id','',Auth::guard('staff')->user()->primary_dpt)->get();
                        $myticket = Modules\Core\Models\Ticket\Tickets::where('assigned_to', Auth::guard('staff')->user()->id)->where('status', '1')->get();
                        $unassigned = Modules\Core\Models\Ticket\Tickets::where('assigned_to', '=', null)->where('status', '=', '1')->where('dept_id', '=', Auth::guard('staff')->user()->primary_dpt)->get();
                        $tickets = Modules\Core\Models\Ticket\Tickets::where('status', '1')->where('dept_id', '=', Auth::guard('staff')->user()->primary_dpt)->get();
                        $deleted = Modules\Core\Models\Ticket\Tickets::where('status', '5')->where('dept_id', '=', Auth::guard('staff')->user())->get();
                      }
                      if (Auth::guard('staff')->user()->role == 'agent') {
                        $dept = Modules\Core\Models\Department::where('id', '=', Auth::guard('staff')->user()->primary_dpt)->first();
                        $overdues = Modules\Core\Models\Ticket\Tickets::where('status', '=', 1)->where('isanswered', '=', 0)->where('dept_id', '=', $dept->id)->orderBy('id', 'DESC')->get();
                      } else {
                        $overdues = Modules\Core\Models\Ticket\Tickets::where('status', '=', 1)->where('isanswered', '=', 0)->orderBy('id', 'DESC')->get();
                      }*/



                /*      $i = count($overdues);
                      if ($i == 0) {
                        $overdue_ticket = 0;
                      } else {
                        $j = 0;
                        foreach ($overdues as $overdue) {
                          $sla_plan = Modules\Tickets\Models\SlaPlan::where('id', '=', $overdue->sla)->first();
                          $ovadate = $overdue->created_at;
                          $new_date = date_add($ovadate, date_interval_create_from_date_string($sla_plan->grace_period)) . '<br/><br/>';
                          if (date('Y-m-d H:i:s') > $new_date) {
                            $j++;
                            //$value[] = $overdue;
                          }
                        }
                        // dd(count($value));
                        if ($j > 0) {
                          $overdue_ticket = $j;
                        } else {
                          $overdue_ticket = 0;
                        }
                      }*/


                ?>
                <li @yield('inbox')>
                    <a href="/ticketspanel/inbox" id="load-inbox">
                        <i class="fa fa-envelope"></i> <span>{!! Lang::get('tickets::lang.inbox') !!}</span>
                        <small class="label pull-right bg-green">count($tickets)</small>
                    </a>
                </li>
                <li @yield('myticket')>
                    <a href="/ticketspanel/mytickets" id="load-myticket">
                        <i class="fa fa-user"></i> <span>{!! Lang::get('tickets::lang.my_tickets') !!} </span>
                        <small class="label pull-right bg-green">count($myticket)</small>
                    </a>
                </li>
                <li @yield('unassigned')>
                    <a href="/ticketspanel/unassigned/" id="load-unassigned">
                        <i class="fa fa-th"></i> <span>{!! Lang::get('tickets::lang.unassigned') !!}</span>
                        <small class="label pull-right bg-green">count($unassigned)</small>
                    </a>
                </li>
                <li @yield('overdue')>
                    <a href="/ticketspanel/overdue/" id="load-unassigned">
                        <i class="fa fa-calendar-times-o"></i> <span>{!! Lang::get('tickets::lang.overdue') !!}</span>
                        <small class="label pull-right bg-green">$overdue_ticket</small>
                    </a>
                </li>
                <li @yield('trash')>
                    <a href="/ticketspanel/trash/">
                        <i class="fa fa-trash-o"></i> <span>{!! Lang::get('tickets::lang.trash') !!}</span>
                        <small class="label pull-right bg-green">count($deleted)</small>
                    </a>
                </li>
                <li class="header">{!! Lang::get('core::lang.departments') !!}</li>
                <?php
                /*      $depts = Modules\Core\Models\Department::all();
                      foreach ($depts as $dept) {
                      $open = Modules\Core\Models\Ticket\Tickets::where('status', '=', '1')->where('isanswered', '=', 0)->where('dept_id', '=', $dept->id)->get();
                      $open = count($open);
                      $underprocess = Modules\Core\Models\Ticket\Tickets::where('status', '=', '1')->where('assigned_to', '>', 0)->where('dept_id', '=', $dept->id)->get();
                      $underprocess = count($underprocess);
                      $closed = Modules\Core\Models\Ticket\Tickets::where('status', '=', '2')->where('dept_id', '=', $dept->id)->get();
                      $closed = count($closed);
                      // $underprocess = 0;
                      // foreach ($inbox as $ticket4) {
                      //  if ($ticket4->assigned_to == null) {
                      //  } else {
                      //      $underprocess++;
                      //  }
                      // }
                      if (Auth::guard('staff')->user()->role == 'admin') {*/
                ?>


                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-folder-open"></i> <span>$dept->name</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{!! url::route('dept.open.ticket','Support') !!}"><i
                                        class="fa fa-circle-o"></i>{!! Lang::get('tickets::lang.open') !!}
                                <small class="label pull-right bg-green">$open</small>
                            </a></li>
                        <li><a href="{!! url::route('dept.inprogress.ticket','Support') !!}"><i
                                        class="fa fa-circle-o"></i>{!! Lang::get('tickets::lang.inprogress') !!}
                                <small class="label pull-right bg-green">$underprocess</small>
                            </a></li>
                        <li><a href="{!! url::route('dept.closed.ticket','Support') !!}"><i
                                        class="fa fa-circle-o"></i>{!! Lang::get('tickets::lang.closed') !!}
                                <small class="label pull-right bg-green">$closed</small>
                            </a></li>
                    </ul>
                </li>

            </ul>

        </section><!-- /.sidebar -->

    </aside>

    <!-- Right side column. Contains the navbar and content of the page -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="tab-content" style="background-color: white;padding: 0 20px 0 20px">
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <div class="tabs-content">

                    <div class="tabs-pane @yield('dashboard-bar')"  id="tabA">
                        <ul class="nav navbar-nav">
                        </ul>
                    </div>
                    <div class="tabs-pane @yield('user-bar')" id="tabB">
                        <ul class="nav navbar-nav">
                            <li id="bar" @yield('user')><a href="{{ url('user')}}" >{!! Lang::get('core::lang.user_directory') !!}</a></li></a></li>
                            <li id="bar" @yield('organizations')><a href="{{ url('organizations')}}" >{!! Lang::get('relations::lang.organizations') !!}</a></li></a></li>
                        </ul>
                    </div>
                    <div class="tabs-pane @yield('ticket-bar')" id="tabC">
                        <ul class="nav navbar-nav">
                            <li id="bar" @yield('open')><a href="{{ url('/ticketspanel/open')}}" id="load-open">{!! Lang::get('tickets::lang.open') !!}</a></li>
                            <li id="bar" @yield('answered')><a href="{{ url('/ticketspanel/answered')}}" id="load-answered">{!! Lang::get('tickets::lang.answered') !!}</a></li>
                            <li id="bar" @yield('myticket')><a href="{{ url('/ticketspanel/mytickets')}}" >{!! Lang::get('lang.my_tickets') !!}</a></li>
                            {{-- < li id = "bar" @yield('ticket') > < a href = "{{ url('ticket') }}" >Ticket</a></li> --}}
                            {{-- < li id = "bar" @yield('overdue') > < a href = "{{ url('/ticket/overdue') }}" >Overdue</a></li> --}}
                            <li id="bar" @yield('assigned')><a href="{{ url('/ticketspanel/assigned')}}" id="load-assigned" >{!! Lang::get('tickets::lang.assigned') !!}</a></li>
                            <li id="bar" @yield('closed')><a href="{{ url('/ticketspanel/closed')}}" >{!! Lang::get('lang.closed') !!}</a></li>
                        </ul>
                    </div>
                    <div class="tabs-pane @yield('tools-bar')" id="tabD">
                        <ul class="nav navbar-nav">
                            <li id="bar" @yield('tools')><a href="{{ url('/ticketspanel/cannedresponses/list')}}" >{!! Lang::get('tickets::lang.canned_response') !!}</a></li>
                            @if(Auth::guard('staff')->user()->role == 'admin')
                            <li id="bar" @yield('kb')><a href="{{ url('/kbpanel/comment')}}" >{!! Lang::get('knowledgebase::lang.knowledge_base') !!}</a></li>
                            @endif
                        </ul>
                    </div>

                        <?php \Event::fire('service.desk.agent.topsubbar', array()); ?>
                </div>
            </div>
        </div>
        <section class="content-header">
            <!--<div class="row">-->
            <!--<div class="col-md-6">-->
            @yield('PageHeader')
            <!--</div>-->
            <!--<div class="pull-right">-->
            {{-- B  R E A D@yield('breadcrumbs') C R U M BBB S --}}
            <!--</div>-->
            <!--</div>-->
        </section>
        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section><!-- /.content -->
    </div>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> {!! Config::get('core::app.version') !!}
        </div>
        <strong>{!! Lang::get('core::lang.copyright') !!} &copy; {!! date('Y') !!}  <a href="#" target="_blank">CompanyName</a>.</strong> {!! Lang::get('core::lang.all_rights_reserved') !!}. {!! Lang::get('core::lang.powered_by') !!} <a href="http://www.faveohelpdesk.com/" target="_blank">Faveo</a>
    </footer>
</div><!-- ./wrapper -->


<script src="{{asset("lb-faveo/js/ajax-jquery.min.js")}}" type="text/javascript"></script>

<script src="{{asset("lb-faveo/js/bootstrap-datetimepicker4.7.14.min.js")}}" type="text/javascript"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{asset("lb-faveo/js/bootstrap.min.js")}}" type="text/javascript"></script>
<!-- Slimscroll -->
<script src="{{asset("lb-faveo/plugins/slimScroll/jquery.slimscroll.min.js")}}" type="text/javascript"></script>
<!-- FastClick -->
<script src="{{asset("lb-faveo/plugins/fastclick/fastclick.min.js")}}"  type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="{{asset("lb-faveo/js/app.min.js")}}" type="text/javascript"></script>
<!-- iCheck -->
<script src="{{asset("lb-faveo/plugins/iCheck/icheck.min.js")}}" type="text/javascript"></script>
<!-- jquery ui -->
<script src="{{asset("lb-faveo/js/jquery.ui.js")}}" type="text/javascript"></script>

<script src="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>

<script src="{{asset("lb-faveo/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
<!-- Page Script -->
<script src="{{asset("lb-faveo/js/jquery.dataTables1.10.10.min.js")}}" type="text/javascript" ></script>

<script type="text/javascript" src="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.js")}}"  type="text/javascript"></script>

<script src="{{asset("lb-faveo/js/jquery.rating.pack.js")}}" type="text/javascript"></script>

<script src="{{asset("lb-faveo/plugins/select2/select2.full.min.js")}}" type="text/javascript"></script>

<script src="{{asset("lb-faveo/plugins/moment/moment.js")}}" type="text/javascript"></script>

<script>
$(function() {
// Enable check and uncheck all functionality
$(".checkbox-toggle").click(function() {
var clicks = $(this).data('clicks');
        if (clicks) {
//Uncheck all checkboxes
$("input[type='checkbox']", ".mailbox-messages").iCheck("uncheck");
} else {
//Check all checkboxes
$("input[type='checkbox']", ".mailbox-messages").iCheck("check");
}
$(this).data("clicks", !clicks);
});
        //Handle starring for glyphicon and font awesome
        $(".mailbox-star").click(function(e) {
e.preventDefault();
        //detect type
        var $this = $(this).find("a > i");
        var glyph = $this.hasClass("glyphicon");
        var fa = $this.hasClass("fa");
        //Switch states
        if (glyph) {
$this.toggleClass("glyphicon-star");
        $this.toggleClass("glyphicon-star-empty");
}
if (fa) {
$this.toggleClass("fa-star");
        $this.toggleClass("fa-star-o");
}
});
});
</script>

<script src="{{asset("lb-faveo/js/tabby.js")}}" type="text/javascript"></script>

<script src="{{asset("lb-faveo/plugins/filebrowser/plugin.js")}}" type="text/javascript"></script>

<script src="{{asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}" type="text/javascript"></script>

<script type="text/javascript">
            $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
            });
</script>
<script type="text/javascript">
    function clickDashboard() {
        window.location = "{{URL::route('dashboard')}}";
    }
</script>
@yield('FooterInclude')
</body>
</html>