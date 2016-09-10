

<div class="col-lg-8">
  <div class="col-lg-6">
          <!-- Info Boxes Style 2 -->
          <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="ion ion-ios-book-outline"></i></span>

            <div class="info-box-content">
        <span class="info-box-text">All Tickets</span>
        <span class="info-box-number">{{$allCompletedTickets}} / {{$alltickets}}</span>

              <div class="progress">
          <div class="progress-bar" style="width: {{$totalPercentageTickets}}%"></div>
              </div>
                  <span class="progress-description">
                    {{number_format($totalPercentageTickets, 0)}}% Completed
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
 </div>
          <div class="col-lg-6">
          <!-- /.info-box -->
          <div class="info-box bg-red">
            <span class="info-box-icon"><i class="ion ion-stats-bars"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">All Leads</span>
              <span class="info-box-number">{{$allCompletedLeads}} / {{$allleads}}</span>

              <div class="progress">
                <div class="progress-bar" style="width: {{$totalPercentageLeads}}%"></div>
              </div>
                  <span class="progress-description">
                    {{number_format($totalPercentageLeads, 0)}}% Completed
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>

  </div>
</div>

<div class="col-lg-4">	
<h4>All Users</h4>
  &nbsp;
</div>

	<div class="row">


<button id="collapse-init" class="btn btn-primary">
    Disable accordion behavior
</button>
<br/><br/>
<div class="col-sm-6">

    <div class="box box-primary">
        <div class="box-header with-border">
             <h4 class="box-title"
              >
          Tickets created each Month
             </h4>
             <div class="box-tools pull-right">
                <button type="button" id="collapse1" class="btn btn-box-tool"    data-toggle="collapse"
                 data-target="#collapseOne"><i id="toggler1" class="fa fa-minus"></i>
                </button>
              </div>
        </div>
        <div id="collapseOne" class="panel-collapse">
            <div class="box-body">
              <div >
            <graphline class="chart" :labels="{{json_encode($createdTicketEachMonths)}}"
                       :values="{{json_encode($ticketCreated)}}"
                       :valuesextra="{{json_encode($ticketCompleted)}}"></graphline>
              </div>
            </div>
        </div>
    </div>
     <div class="box box-primary">
        <div class="box-header with-border">
             <h4 class="box-title"
>
                 Created leads each month
             </h4>
             <div class="box-tools pull-right">
                <button type="button" id="collapse2" class="btn btn-box-tool" data-toggle="collapse"
                 data-target="#collapseTwo"><i id="toggler2" class="fa fa-minus"></i>
                </button>
              </div>
        </div>
        <div id="collapseTwo" class="panel-collapse">
            <div class="box-body">
              <div >
            <graphline class="chart" :labels="{{json_encode($createdLeadEachMonths)}}"
                       :values="{{json_encode($leadCreated)}}"></graphline>
              </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-6">
        <div class="box box-primary">
        <div class="box-header with-border">
             <h4 class="box-title"
                 >
          Tickets completed each month
             </h4>
             <div class="box-tools pull-right">
                <button type="button" id="collapse3" class="btn btn-box-tool" data-toggle="collapse"
                 data-target="#collapseThree"><i id="toggler3" class="fa fa-minus"></i>
                </button>
              </div>
        </div>
        <div id="collapseThree" class="panel-collapse">
            <div class="box-body">
              <div >
            <graphline class="chart" :labels="{{json_encode($completedTicketEachMonths)}}"
                       :values="{{json_encode($ticketCompleted)}}"></graphline>
              </div>
            </div>
        </div>
    </div>


    <div class="box box-primary">
        <div class="box-header with-border">
             <h4 class="box-title"
>
                 Leads completed each month
             </h4>
             <div class="box-tools pull-right">
                <button type="button" id="collapse4" class="btn btn-box-tool"                  data-toggle="collapse"
                 data-target="#collapseFour"><i id="toggler4" class="fa fa-minus"></i>
                </button>
              </div>
        </div>
        <div id="collapseFour" class="panel-collapse">
            <div class="box-body">
              <div >
            <graphline class="chart" :labels="{{json_encode($completedLeadEachMonths)}}"
                       :values="{{json_encode($leadsCompleted)}}"></graphline>
              </div>
            </div>
        </div>
    </div>
 
</div>
      </div>  


         <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-book-outline"></i></span>

            <div class="info-box-content">
        <span class="info-box-text">Tickets completed today</span>
        <span class="info-box-number">{{$completedTicketsToday}}
          <small></small></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="ion ion-ios-book-outline"></i></span>

            <div class="info-box-content">
        <span class="info-box-text">Tickets created today</span>
        <span class="info-box-number">{{$createdTicketsToday}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-stats-bars"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Leads Completed today</span>
              <span class="info-box-number">{{$completedLeadsToday}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-stats-bars"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Leads created today</span>
              <span class="info-box-number">{{$createdLeadsToday}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
    
    