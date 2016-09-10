<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('AdminTableSeeder');  /*  Creates Admin user in the Staff (and users) table */
        $this->call('UsersTableSeeder');
        $this->call('IndustriesTableSeeder');
        $this->call('DepartmentsTableSeeder');
        $this->call('SettingsTableSeeder');
        $this->call('PermissionsTableSeeder');
        $this->call('RolesTablesSeeder');
        $this->call('RolePermissionTableSeeder');
        $this->call('UserRoleTableSeeder');
        $this->call('StaffRoleTableSeeder');
        $this->call('NotificationCategoriesTableSeeder');
    }
}
