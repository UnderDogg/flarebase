<?php
namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modules\Core\Models\Department;
use Session;
use Modules\Core\Requests\Department\StoreDepartmentRequest;
use Modules\Core\Services\Department\DepartmentServiceContract;

class DepartmentsController extends Controller
{

    protected $departments;

    public function __construct(DepartmentServiceContract $departments)
    {
        $this->departments = $departments;
        //$this->middleware('staff');
        $this->middleware('user.is.admin', ['only' => ['create', 'destroy']]);
    }

    public function index()
    {
        return view('departments.index')
            ->withDepartment($this->departments->getAllDepartments());
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(StoreDepartmentRequest $request)
    {
        $this->departments->create($request);
        Session::flash('flash_message', 'Successfully created New Department');
        return redirect()->route('departments.index');
    }

    public function destroy($id)
    {
        $this->departments->destroy($id);
        return redirect()->route('departments.index');
    }
}
