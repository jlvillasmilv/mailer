<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AddresseeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Addressee::factory(25)->create();
    }
}
