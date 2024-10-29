<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('plans')->delete();

        \DB::table('plans')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Pro',
                'description' => 'Gain access to our pro features with the pro plan.',
                'features' => 'Unlimited Tasks, Unlimited Projects',
                'role_id' => 3,
                'default' => 0,
                'monthly_price' => '9.99',
                'yearly_price' => '99',
                'created_at' => '2018-07-03 16:30:43',
                'updated_at' => '2018-08-22 22:26:19',
            ),
        ));
    }
}
