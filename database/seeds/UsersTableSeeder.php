<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /*
    * Run the database seeds.
       *
       * @return void
       */
    public function run()
    {
        factory(Modules\Core\Models\User::class, 500)->create()->each(function ($c) {

        });
    }
}
