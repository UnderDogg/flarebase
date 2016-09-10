<?php
namespace Modules\Core\Services\Department;
interface DepartmentServiceContract
{

    public function getAllDepartments();

    public function listAllDepartments();

    public function create($requestData);

    public function destroy($id);
}
