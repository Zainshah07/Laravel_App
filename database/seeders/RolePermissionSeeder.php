<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::firstorCreate(['name' => 'updateProducts']);
        $role = Role::firstorCreate(['name' => 'editor']);
        $role->givePermissionTo('updateProducts');
        $user = User::find(1);
        $user->assignRole('editor');
    }
}
