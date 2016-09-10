<?php

use Illuminate\Database\Seeder;

class LeadsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        
        
        \DB::table('leads')->insert(array (
            0 =>
            array (
                'id' => 1,
                'title' => 'Sell Item',
                'note' => 'Try and sell this new Item',
                'status_id' => 1,
                'assigned_to_staff_id' => 1,
                'fk_relation_id' => 9,
                'fk_staff_id_created' => 1,
                'contact_date' => '2016-06-18 12:00:00',
                'created_at' => '2016-06-04 13:51:10',
                'updated_at' => '2016-06-04 13:51:10',
            ),
            1 =>
            array (
                'id' => 2,
                'title' => 'Contact Relation about new offer',
                'note' => 'Give them a call about the new items',
                'status_id' => 1,
                'assigned_to_staff_id' => 1,
                'fk_relation_id' => 10,
                'fk_staff_id_created' => 1,
                'contact_date' => '2016-06-18 13:00:00',
                'created_at' => '2016-06-04 13:56:27',
                'updated_at' => '2016-06-04 13:56:27',
            ),
            2 =>
            array (
                'id' => 3,
                'title' => 'Relation wants to know more about item',
                'note' => 'Give the relation a call, about the item',
                'status_id' => 2,
                'assigned_to_staff_id' => 1,
                'fk_relation_id' => 10,
                'fk_staff_id_created' => 1,
                'contact_date' => '2016-06-14 12:00:00',
                'created_at' => '2016-06-04 13:57:07',
                'updated_at' => '2016-06-04 13:57:07',
            ),
        ));
    }
}
