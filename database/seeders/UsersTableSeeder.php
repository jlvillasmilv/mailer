<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'      => 'Admin',
            'email'     => 'admin@admin.com',
            'identification' => 0,
            'cell_phone'     => '7868378447',
            'birth_date'     => date('Y-m-d'),
            'city_code'      => 5201,
            'email_verified_at' => now(),
            'password'  => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $client = User::create([
            'name'      => 'Cliente',
            'email'     => 'client@client.com',
            'identification' => '6543217890',
            'cell_phone'     => '7328978447',
            'birth_date'     => date('Y-m-d'),
            'city_code'      => 5201,
            'email_verified_at' => now(),
            'password'  => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
    }
}
