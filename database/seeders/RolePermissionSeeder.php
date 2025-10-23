<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create Permissions
        $permissions = [
            'create loan',
            'approve loan',
            'view loan',
            'update loan',
            'delete loan',
            'manage users'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $client = Role::firstOrCreate(['name' => 'client']);
        $agent = Role::firstOrCreate(['name' => 'agent']);

        // Give Permissions
        $admin->givePermissionTo($permissions);

        $agent->givePermissionTo([
            'approve loan',
            'view loan',
        ]);

        $client->givePermissionTo([
            'view loan'
        ]);

    }
}
