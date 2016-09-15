<?php
namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modules\Core\Models\Role;
use Modules\Core\Requests\Role\StoreRoleRequest;
use Modules\Core\Requests\Role\UpdateRoleRequest;
use Gate;
use Datatables;
use Carbon;
use PHPZen\LaravelRbac\Traits\Rbac;
use Illuminate\Support\Facades\Input;
use Modules\Models\Relation;
use Modules\Core\Services\Role\RoleServiceContract;
use Modules\Core\Services\Department\DepartmentServiceContract;

class RolesController extends Controller
{

    protected $roles;

    public function __construct(RoleServiceContract $roles)
    {
        $this->roles = $roles;
        $this->middleware('user.is.admin', ['only' => ['index', 'create', 'destroy']]);
    }

    public function index()
    {
        return view('core::roles.index')
            ->withRoles($this->roles->allRoles());
    }

    public function manage()
    {
        return view('core::roles.index');
    }

    public function anyData()
    {
        //$canUpdateStaff = auth()->user()->can('update-user');
        //Auth::guard($guard)->user()->can('update-user');
        $roles = Role::select(['id', 'display_name', 'name']);
        return Datatables::of($roles)

            ->addColumn('roleslink', function ($role) {
                return '<a href="adminpanel/roles/' . $role->id . '" ">' . $role->display_name . '</a>';
            })
            ->addColumn('rolesdepartmentlink', function ($role) {
                return '<a href="adminpanel/roles/' . $role->id . '" ">' . $role->name . '</a>';
            })

            ->addColumn('actions', function ($role) {
                return '
                <form action="' . route('roles.destroy', [$role->id]) .'" method="POST">
                <div class=\'btn-group\'>
                    <input type="hidden" name="_method" value="DELETE">
                    <a href="' . route('roles.edit', [$role->id]) . '" class=\'btn btn-success btn-xs\'>Edit</a>
                    <input type="submit" name="submit" value="Delete" class="btn btn-danger btn-xs" onClick="return confirm(\'Are you sure?\')"">
                </div>
                </form>';
            })
            ->make(true);
    }
    public function create()
    {
        return view('core::roles.create');
    }

    public function show()
    {
        //return view('roles.show');
    }


    public function store(StoreRoleRequest $request)
    {
        $this->roles->create($request);
        Session()->flash('flash_message', 'Role created');
        return redirect()->back();
    }

    public function edit()
    {
        return view('core::roles.edit');
    }

    public function update(UpdateRoleRequest $request, Role $id)
    {
        $this->roles->update($request);
        Session()->flash('flash_message', 'Role created');
        return redirect()->back();
    }


    public function destroy($id)
    {
        $this->roles->destroy($id);
        Session()->flash('flash_message', 'Role deleted');
        return redirect()->route('roles.index');
    }
}
