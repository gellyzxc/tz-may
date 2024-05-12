<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = ['user.store', 'user.update', 'user.destroy', 'user.index', 'user.show', 'post.store', 'post.update', 'post.destroy', 'post.index', 'post.show', 'post.my'];
        $roles = [
            'admin' => ['user.store', 'user.update', 'user.destroy', 'user.index', 'user.show', 'post.store', 'post.update', 'post.destroy', 'post.index', 'post.show', 'post.my'],
            'writer' => ['post.store', 'post.update', 'post.destroy', 'post.index', 'post.show', 'post.my'],
            'user' => ['post.index', 'post.show']
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'api']);
        }

        foreach ($roles as $role => $permissions) {
            $role = Role::create(['name' => $role, 'guard_name' => 'api']);

            $role->givePermissionTo($permissions);
        }
    }
}
