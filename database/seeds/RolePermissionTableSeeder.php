<?php

use Illuminate\Database\Seeder;
use App\Models\PermissionRole;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * ADMIN ROLES
         *
         */
        $createUser = new PermissionRole;
        $createUser->role_id = '1';
        $createUser->permissions_id = '1';
        $createUser->timestamps = false;
        $createUser->save();

        $updateUser = new PermissionRole;
        $updateUser->role_id = '1';
        $updateUser->permissions_id = '2';
        $updateUser->timestamps = false;
        $updateUser->save();

        $deleteUser = new PermissionRole;
        $deleteUser->role_id = '1';
        $deleteUser->permissions_id = '3';
        $deleteUser->timestamps = false;
        $deleteUser->save();
        $createRelation = new PermissionRole;
        $createRelation->role_id = '1';
        $createRelation->permissions_id = '4';
        $createRelation->timestamps = false;
        $createRelation->save();
        $updateRelation = new PermissionRole;
        $updateRelation->role_id = '1';
        $updateRelation->permissions_id = '5';
        $updateRelation->timestamps = false;
        $updateRelation->save();
        $deleteRelation = new PermissionRole;
        $deleteRelation->role_id = '1';
        $deleteRelation->permissions_id = '6';
        $deleteRelation->timestamps = false;
        $deleteRelation->save();
        $createTicket = new PermissionRole;
        $createTicket->role_id = '1';
        $createTicket->permissions_id = '7';
        $createTicket->timestamps = false;
        $createTicket->save();
        $updateTicket = new PermissionRole;
        $updateTicket->role_id = '1';
        $updateTicket->permissions_id = '8';
        $updateTicket->timestamps = false;
        $updateTicket->save();
        $createLead = new PermissionRole;
        $createLead->role_id = '1';
        $createLead->permissions_id = '9';
        $createLead->timestamps = false;
        $createLead->save();

        $updateLead = new PermissionRole;
        $updateLead->role_id = '1';
        $updateLead->permissions_id = '10';
        $updateLead->timestamps = false;
        $updateLead->save();
    }
}
