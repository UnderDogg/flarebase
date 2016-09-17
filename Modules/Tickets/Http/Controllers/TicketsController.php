<?php
namespace Modules\Tickets\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modules\Tickets\Models\Ticket;
use Modules\Core\Models\Staff;
use Modules\Core\Models\User;
use Modules\Relations\Models\Relation;
use Illuminate\Http\Request;
use Gate;
use Modules\Tickets\Models\TicketTime;
use Datatables;
use Carbon;
use App\Dinero;
use App\Billy;
use Modules\Tickets\Requests\Ticket\StoreTicketRequest;
use Modules\Tickets\Requests\Ticket\UpdateTimeTicketRequest;
use Modules\Tickets\Services\Ticket\TicketServiceContract;
use Modules\Core\Services\User\UserServiceContract;
use Modules\Core\Services\Staff\StaffServiceContract;
use Modules\Relations\Services\Relation\RelationServiceContract;
use Modules\Core\Services\Setting\SettingServiceContract;
use Modules\Invoices\Services\Invoice\InvoiceServiceContract;

class TicketsController extends Controller
{

    protected $request;
    protected $tickets;
    protected $relations;
    protected $settings;
    protected $users;
    protected $staff;
    protected $invoices;

    public function __construct(
        TicketServiceContract $tickets,
        UserServiceContract $users,
        StaffServiceContract $staff,
        RelationServiceContract $relations,
        InvoiceServiceContract $invoices,
        SettingServiceContract $settings
    )
    {
        $this->tickets = $tickets;
        $this->users = $users;
        $this->relations = $relations;
        $this->invoices = $invoices;
        $this->settings = $settings;
        //$this->middleware('ticket.create', ['only' => ['create']]);
        //$this->middleware('ticket.update.status', ['only' => ['updateStatus']]);
        //$this->middleware('ticket.assigned', ['only' => ['updateAssign', 'updateTime']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('tickets::tickets.index');
    }

    public function anyData()
    {

/*
`id`,
`ticket_number`,
`subject`,
`relation_id`,
`assigned_to`,
`mailbox_id`,
`dept_id`,
`team_id`,
`ticketstatus_id`,
`priority_id`,
`slaplan_id`,
`tickettype_id`,
`helptopic_id`,
`ticketsource_id`,
`hasflags`,
`flagtype`,
`hashtml`,
`escalationrule_id`,
`autocloserule_id`,
`is_overdue`,
`duedate`,
`is_transferred`,
`transferred_at`,
`isreopened`,
`reopened_at`,
`is_answered`,
`is_deleted`,
`is_closed`,
`closed_at`,
`last_message_at`,
`last_response_at`,
`lastreplier_id`,
`created_at`,
`updated_at`
 **/

        $tickets = Ticket::select([
            'id', 'ticket_number', 'subject', 'priority_id', 'relation_id', 'assigned_to', 'transferred_at', 'created_at', 'reopened_at', 'deadline_at'
        ])->orderBy('deadline_at', 'desc');
        return Datatables::of($tickets)
            ->addColumn('ticketnumber', function ($tickets) {
                return '<a href="/tickets/ticket/' . $tickets->id . '" ">' . $tickets->ticket_number . '</a>';
            })
            ->addColumn('ticketsubjectlink', function ($tickets) {
                return '<a href="/tickets/ticket/' . $tickets->id . '" ">' . $tickets->subject . '</a>';
            })
            ->addColumn('relation_id', function ($tickets) {
                return '<a href="/relations/relation/' . $tickets->fk_relation_id . '" ">' . $tickets->relationAssignee->company_name . '</a>';
            })
            ->addColumn('priority_id', function ($tickets) {
                return '<a href="/tickets/priority/' . $tickets->priority_id . '" ">' . $tickets->priority_id . '</a>';
            })
            ->editColumn('created_at', function ($tickets) {
                return $tickets->created_at ? with(new Carbon($tickets->created_at))
                    ->format('d/m/Y') : '';
            })
            ->editColumn('deadline', function ($tickets) {
                return $tickets->created_at ? with(new Carbon($tickets->deadline_at))
                    ->format('d/m/Y') : '';
            })
            ->editColumn('assigned_to', function ($tickets) {
                return $tickets->assignee->name;
            })->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('tickets.create')
            ->withUsers($this->users->getAllUsersWithDepartments())
            ->withRelations($this->relations->listAllRelations());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(StoreTicketRequest $request) // uses __contrust request
    {
        $getInsertedId = $this->tickets->create($request);
        return redirect()->route("tickets.show", $getInsertedId);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $integrationCheck = Integration::first();
        if ($integrationCheck) {
            $api = Integration::getApi('billing');
            $apiConnected = true;
            $invoiceContacts = $api->getContacts();
        } else {
            $apiConnected = false;
            $invoiceContacts = array();
        }
        return view('tickets.show')
            ->withTickets($this->tickets->find($id))
            ->withUsers($this->users->getAllUsersWithDepartments())
            ->withContacts($invoiceContacts)
            ->withTickettimes($this->tickets->getTicketTime($id))
            ->withCompanyname($this->settings->getCompanyName())
            ->withApiconnected($apiConnected);
    }


    /**
     * Sees if the Settings from backend allows all to complete taks
     * or only assigned user. if only assigned user:
     * @param  [Auth]  $id Checks Logged in users id
     * @param  [Model] $ticket->assigned_to_staff_id Checks the id of the user assigned to the ticket
     * If Auth and fk_staff_id allow complete else redirect back if all allowed excute
     * else stmt*/
    public function updateStatus($id, Request $request)
    {
        $this->tickets->updateStatus($id, $request);
        Session()->flash('flash_message', 'Ticket is completed');
        return redirect()->back();
    }


    public function updateAssign($id, Request $request)
    {
        $relationId = $this->tickets->getAssignedRelation($id)->id;
        $this->tickets->updateAssign($id, $request);
        Session()->flash('flash_message', 'New user is assigned');
        return redirect()->back();
    }

    public function updateTime($id, Request $request)
    {
        $this->tickets->updateTime($id, $request);
        Session()->flash('flash_message', 'Time has been updated');
        return redirect()->back();
    }

    public function invoice($id, Request $request)
    {
        $ticket = Ticket::findOrFail($id);
        $relationId = $ticket->relationAssignee()->first()->id;
        $timeTicketId = $ticket->allTime()->get();
        $integrationCheck = Integration::first();
        if ($integrationCheck) {
            $this->tickets->invoice($id, $request);
        }
        $this->invoices->create($relationId, $timeTicketId, $request->all());
        Session()->flash('flash_message', 'Invoice created');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function marked()
    {
        Notifynder::readAll(\Auth::id());
        return redirect()->back();
    }

    public function openticketsperdepartment($department = null)
    {
    }

    public function inprogressticketsperdepartment($department = null)
    {
    }

    public function closedticketsperdepartment($department = null)
    {
    }

    /**
     * select_all.
     *
     * @return type
     */
    public function select_all()
    {
        /*    if (Input::has('select_all')) {
              $selectall = Input::get('select_all');
              $value = Input::get('submit');
              foreach ($selectall as $delete) {
                $ticket = Ticket::whereId($delete)->first();
                if ($value == 'Delete') {
                  /*$ticket->status_id = 5;
                    $ticket->save();* /
                } elseif ($value == 'Close') {
                  $ticket->status_id = 2;
                  $ticket->closed = 1;
                  $ticket->closed_at = date('Y-m-d H:i:s');
                  $ticket->save();
                } elseif ($value == 'Open') {
                  $ticket->status_id = 1;
                  $ticket->reopened = 1;
                  $ticket->reopened_at = date('Y-m-d H:i:s');
                  $ticket->closed = 0;
                  $ticket->closed_at = null;
                  $ticket->save();
                } elseif ($value == 'Clean up') {
                  $thread = Ticket_Thread::where('ticket_id', '=', $ticket->id)->get();
                  foreach ($thread as $th_id) {
                    // echo $th_id->id." ";
                    $attachment = Ticket_attachments::where('thread_id', '=', $th_id->id)->get();
                    if (count($attachment)) {
                      foreach ($attachment as $a_id) {
                        echo $a_id->id.' ';
                        $attachment = Ticket_attachments::find($a_id->id);
                        $attachment->delete();
                      }
                      // echo "<br>";
                    }
                    $thread = Ticket_Thread::find($th_id->id);
                    //                        dd($thread);
                    $thread->delete();
                  }
                  $collaborators = Ticket_Collaborator::where('ticket_id', '=', $ticket->id)->get();
                  if (count($collaborators)) {
                    foreach ($collaborators as $collab_id) {
                      echo $collab_id->id;
                      $collab = Ticket_Collaborator::find($collab_id->id);
                      $collab->delete();
                    }
                  }
                  $tickets = Ticket::find($ticket->id);
                  $tickets->delete();
                }
              }
              if ($value == 'Delete') {
                return redirect()->back()->with('success', 'Moved to trash');
              } elseif ($value == 'Close') {
                return redirect()->back()->with('success', 'Tickets has been Closed');
              } elseif ($value == 'Open') {
                return redirect()->back()->with('success', 'Ticket has been Opened');
              } else {
                return redirect()->back()->with('success', Lang::get('helpdesk::tickets.hard-delete-success-message'));
              }
            }
            return redirect()->back()->with('fails', 'None Selected!');*/
    }


}
