<?php
namespace Modules\Core\Services\Staff;
interface StaffServiceContract
{

    public function find($id);

    public function getAllStaff();

    public function getAllStaffWithDepartments();

    public function create($requestData);

    public function update($id, $requestData);

    public function destroy($id);
}
