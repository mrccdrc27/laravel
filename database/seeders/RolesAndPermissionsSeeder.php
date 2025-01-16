<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
    Role::create(['name' => 'admin']);
    Role::create(['name' => 'instructor']);
    Role::create(['name' => 'student']);
    
    // Create permissions
    Permission::create(['name' => 'edit articles']);
    Permission::create(['name' => 'delete articles']);
    
    // Assign permissions to roles
    $role = Role::findByName('admin');
    $role->givePermissionTo('edit articles', 'delete articles');
    
    $role = Role::findByName('student');
    $role->givePermissionTo('edit articles');
    }
}
