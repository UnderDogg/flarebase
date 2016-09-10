<?php
namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modules\Core\Models\Role;
use Modules\Core\Requests\Role\StoreRoleRequest;
use Modules\Core\Services\Role\RoleServiceContract;

class TemplatesController extends Controller
{

    protected $roles;

    public function __construct(RoleServiceContract $roles)
    {
        $this->roles = $roles;
        $this->middleware('user.is.admin', ['only' => ['index', 'create', 'destroy']]);
    }

    public function index()
    {
        return view('roles.index')
            ->withRoles($this->roles->allRoles());
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(StoreRoleRequest $request)
    {
        $this->roles->create($request);
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
