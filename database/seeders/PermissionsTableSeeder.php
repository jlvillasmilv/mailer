<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Permission list
        Permission::create(['name' => 'clients.index']);
        Permission::create(['name' => 'clients.edit']);
        Permission::create(['name' => 'clients.show']);
        Permission::create(['name' => 'clients.create']);
        Permission::create(['name' => 'clients.destroy']);

        Permission::create(['name' => 'mails.index']);
        Permission::create(['name' => 'mails.edit']);
        Permission::create(['name' => 'mails.show']);
        Permission::create(['name' => 'mails.create']);
        Permission::create(['name' => 'mails.destroy']);

        Permission::create(['name' => 'users.index']);
        Permission::create(['name' => 'users.edit']);
        Permission::create(['name' => 'users.show']);
        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.destroy']);

        // Cretae role
        //Admin
        $admin = Role::create(['name' => 'super_admin']);

        //Client
        $guest = Role::create(['name' => 'client']);

         //Operator
        $ope = Role::create(['name' => 'operator']);

        //assignament permission to role
        $guest->givePermissionTo([
            'mails.index',
            'mails.edit',
            'mails.show',
            'mails.create',
            'mails.destroy',
        ]);

         //User Admin
         $user = User::find(1); 
         $user->assignRole('super_admin');
 
         //User Client
         $client = User::find(2); 
         $client->assignRole('Client');
    }
}
