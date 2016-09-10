<?php
namespace Modules\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modules\Core\Models\User;
use Modules\Core\Models\Staff;
use Modules\Tickets\Models\Ticket;
use Illuminate\Http\Request;
use Gate;
use Datatables;
use Carbon;
use PHPZen\LaravelRbac\Traits\Rbac;
use Illuminate\Support\Facades\Input;
use Modules\Models\Relation;
use Modules\Core\Http\Requests\User\UpdateUserRequest;
use Modules\Core\Http\Requests\User\StoreUserRequest;
use Modules\Core\Services\User\UserServiceContract;
use Modules\Core\Services\Role\RoleServiceContract;
use Modules\Core\Services\Department\DepartmentServiceContract;
use Modules\Core\Services\Setting\SettingServiceContract;

class UsersController extends Controller
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
        $this->middleware('user.create', ['only' => ['create']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('users.index');
    }

    public function anyData()
    {
        $canUpdateUser = auth()->user()->can('update-user');
        $users = User::select(['id', 'name', 'email', 'work_number']);
        return Datatables::of($users)
            ->addColumn('namelink', function ($users) {
                return '<a href="users/' . $users->id . '" ">' . $users->name . '</a>';
            })
            ->add_column('edit', '
                <a href="{{ route(\'users.edit\', $id) }}" class="btn btn-success" >Edit</a>')
            ->add_column('delete', '
                <form action="{{ route(\'users.destroy\', $id) }}" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <input type="submit" name="submit" value="Delete" class="btn btn-danger" onClick="return confirm(\'Are you sure?\')"">

            {{csrf_field()}}
            </form>')
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
        return view('users.create')
            ->withRoles($this->roles->listAllRoles())
            ->withDepartments($this->departments->listAllDepartments());
    }

    /**
     * Store a newly created resource in storage.
     * @param User $user
     * @return Response
     */
    public function store(StoreUserRequest $userRequest)
    {
        $getInsertedId = $this->users->create($userRequest);
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        return view('users.show')
            ->withUser($this->users->find($id))
            ->withCompanyname($this->settings->getCompanyName());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('users.edit')
            ->withUser($this->users->find($id))
            ->withRoles($this->roles->listAllRoles())
            ->withDepartment($this->departments->listAllDepartments());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, UpdateUserRequest $request)
    {
        $this->users->update($id, $request);
        Session()->flash('flash_message', 'User successfully updated');
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
        $this->users->destroy($id);
        return redirect()->route('users.index');
    }
}
