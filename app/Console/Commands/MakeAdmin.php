<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class MakeAdmin extends Command
{




    protected $signature = "make:admin {userId}";


    protected $description = 'Make a user admin and give them all permissions';


    public function handle()
    {
        $userId = $this->argument('userId');
        $user= User::find($userId);
         if (!$user) {
            $this->error("User with ID {$userId} not found.");
            return;
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $adminRole->syncPermissions(Permission::all());

        $user->assignRole($adminRole);

        $this->info("✅ User {$user->name} (ID: {$userId}) is now an admin with all permissions.");
    }




}
