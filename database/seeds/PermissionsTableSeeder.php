<?php

use Illuminate\Database\Seeder;
use App\Models\Permissions;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * User Permissions
         */
        $createUser = new Permissions;
        $createUser->display_name = 'Create user';
        $createUser->name = 'user-create';
        $createUser->description = 'Permission to create user';
        $createUser->save();

        $updateUser = new Permissions;
        $updateUser->display_name = 'Update user';
        $updateUser->name = 'user-update';
        $updateUser->description = 'Permission to update user';
        $updateUser->save();

        $deleteUser = new Permissions;
        $deleteUser->display_name = 'Delete user';
        $deleteUser->name = 'user-delete';
        $deleteUser->description = 'Permission to update delete';
        $deleteUser->save();

        /**
         * Relation Permissions
         */
        $createRelation = new Permissions;
        $createRelation->display_name = 'Create relation';
        $createRelation->name = 'relation-create';
        $createRelation->description = 'Permission to create relation';
        $createRelation->save();
        $updateRelation = new Permissions;
        $updateRelation->display_name = 'Update relation';
        $updateRelation->name = 'relation-update';
        $updateRelation->description = 'Permission to update relation';
        $updateRelation->save();
        $deleteRelation = new Permissions;
        $deleteRelation->display_name = 'Delete relation';
        $deleteRelation->name = 'relation-delete';
        $deleteRelation->description = 'Permission to delete relation';
        $deleteRelation->save();
        /**
         * Tickets Permissions
         */
        $createTicket = new Permissions;
        $createTicket->display_name = 'Create ticket';
        $createTicket->name = 'ticket-create';
        $createTicket->description = 'Permission to create ticket';
        $createTicket->save();
        $updateTicket = new Permissions;
        $updateTicket->display_name = 'Update ticket';
        $updateTicket->name = 'ticket-update';
        $updateTicket->description = 'Permission to update ticket';
        $updateTicket->save();

        /**
         * Leads Permissions
         */
        $createLead = new Permissions;
        $createLead->display_name = 'Create lead';
        $createLead->name = 'lead-create';
        $createLead->description = 'Permission to create lead';
        $createLead->save();

        $updateLead = new Permissions;
        $updateLead->display_name = 'Update lead';
        $updateLead->name = 'lead-update';
        $updateLead->description = 'Permission to update lead';
        $updateLead->save();
    }
}
