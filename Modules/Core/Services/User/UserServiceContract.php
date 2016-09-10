<?php
namespace Modules\Core\Services\User;
interface UserServiceContract
{

    public function find($id);

    public function getAllUsers();

    public function getAllUsersWithDepartments();

    public function create($requestData);

    public function update($id, $requestData);

    public function destroy($id);
}
