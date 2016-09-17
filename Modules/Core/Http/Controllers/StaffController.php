<?php
namespace Modules\Core\Http\Controllers;

use App\Http\Requests;



// controller
use App\Http\Controllers\Controller;
// requests
use Modules\Core\Http\Requests\Staff\UpdateStaffRequest;
use Modules\Core\Http\Requests\Staff\StoreStaffRequest;
// models
use Modules\Models\Relation;
use Modules\Core\Models\User;
use Modules\Core\Models\Staff;
use Modules\Tickets\Models\Ticket;
use Illuminate\Http\Request;
use Exception;
use Gate;
use Datatables;
use Carbon;
use PHPZen\LaravelRbac\Traits\Rbac;
use Illuminate\Support\Facades\Input;


use Modules\Core\Services\Staff\StaffServiceContract;
use Modules\Core\Services\User\UserServiceContract;
use Modules\Core\Services\Role\RoleServiceContract;
use Modules\Core\Services\Department\DepartmentServiceContract;
use Modules\Core\Services\Setting\SettingServiceContract;

class StaffController extends Controller
{
    protected $users;
    protected $staff;
    protected $roles;
    protected $departments;
    protected $settings;

    public function __construct(
        UserServiceContract $users,
        StaffServiceContract $staff,
        RoleServiceContract $roles,
        DepartmentServiceContract $departments,
        SettingServiceContract $settings
    )
    {
        $this->users = $users;
        $this->roles = $roles;
        $this->departments = $departments;
        $this->settings = $settings;
        $this->middleware('staff.create', ['only' => ['create']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('core::staff.index');
    }

    public function anyData()
    {
        //$canUpdateStaff = auth()->user()->can('update-user');
        //Auth::guard($guard)->user()->can('update-user');
        $staff = Staff::select(['id', 'name', 'email']);
        return Datatables::of($staff)

            ->addColumn('staffnamelink', function ($staff) {
                return '<a href="adminpanel/staff/' . $staff->id . '" ">' . $staff->name . '</a>';
            })
            ->addColumn('staffemaillink', function ($staff) {
                return '<a href="adminpanel/staff/' . $staff->id . '" ">' . $staff->name . '</a>';
            })

            ->addColumn('actions', function ($staff) {
                return '
                <form action="' . route('staff.destroy', [$staff->id]) .'" method="POST">
                <div class=\'btn-group\'>
                    <input type="hidden" name="_method" value="DELETE">
                    <a href="' . route('staff.edit', [$staff->id]) . '" class=\'btn btn-success btn-xs\'>Edit</a>
                    <input type="submit" name="submit" value="Delete" class="btn btn-danger btn-xs" onClick="return confirm(\'Are you sure?\')"">
                </div>
                </form>';
            })
            ->make(true);
    }

    public function ticketData($id)
    {
        $tickets = Ticket::select(
            ['id', 'ticket_number', 'ticketsubject', 'created_at', 'deadline', 'assigned_to_staff_id']
        )
            ->where('assigned_to_staff_id', $id)->where('status_id', 1);
        return Datatables::of($tickets)
            ->addColumn('titlelink', function ($tickets) {
                return '<a href="' . route('tickets.show', $tickets->id) . '">' . $tickets->title . '</a>';
            })
            ->editColumn('created_at', function ($tickets) {
                return $tickets->created_at ? with(new Carbon($tickets->created_at))
                    ->format('d/m/Y') : '';
            })
            ->editColumn('deadline', function ($tickets) {
                return $tickets->created_at ? with(new Carbon($tickets->created_at))
                    ->format('d/m/Y') : '';
            })
            ->make(true);
    }

    public function closedTicketData($id)
    {
        $tickets = Ticket::select(
            ['id', 'title', 'created_at', 'deadline', 'assigned_to_staff_id']
        )
            ->where('assigned_to_staff_id', $id)->where('status_id', 2);
        return Datatables::of($tickets)
            ->addColumn('titlelink', function ($tickets) {
                return '<a href="' . route('tickets.show', $tickets->id) . '">' . $tickets->title . '</a>';
            })
            ->editColumn('created_at', function ($tickets) {
                return $tickets->created_at ? with(new Carbon($tickets->created_at))
                    ->format('d/m/Y') : '';
            })
            ->editColumn('deadline', function ($tickets) {
                return $tickets->created_at ? with(new Carbon($tickets->created_at))
                    ->format('d/m/Y') : '';
            })
            ->make(true);
    }

    public function relationData($id)
    {
        $relations = Relation::select(['id', 'name', 'company_name', 'primary_number', 'email'])->where('fk_staff_id', $id);
        return Datatables::of($relations)
            ->addColumn('relationlink', function ($relations) {
                return '<a href="' . route('relations.show', $relations->id) . '">' . $relations->name . '</a>';
            })
            ->editColumn('created_at', function ($relations) {
                return $relations->created_at ? with(new Carbon($relations->created_at))
                    ->format('d/m/Y') : '';
            })
            ->editColumn('deadline', function ($relations) {
                return $relations->created_at ? with(new Carbon($relations->created_at))
                    ->format('d/m/Y') : '';
            })
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('staff.create')
            ->withRoles($this->roles->listAllRoles())
            ->withDepartments($this->departments->listAllDepartments());
    }

    /**
     * Store a newly created resource in storage.
     * @param Staff $user
     * @return Response
     */
    public function store(StoreStaffRequest $userRequest)
    {
        $getInsertedId = $this->staff->create($userRequest);
        return redirect()->route('staff.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
/*        return view('staff.show')
            ->withStaff($this->staff->find($id))
            ->withCompanyname($this->settings->getCompanyName());*/
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('staff.edit')
            ->withStaff($this->staff->find($id))
            ->withRoles($this->roles->listAllRoles())
            ->withDepartment($this->departments->listAllDepartments());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, UpdateStaffRequest $request)
    {
        $this->staff->update($id, $request);
        Session()->flash('flash_message', 'Staff successfully updated');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->staff->destroy($id);
        return redirect()->route('staff.index');
    }
}
