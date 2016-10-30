<?php

use Illuminate\Database\Seeder;
use Xenex\Ntrust\Role;
use Xenex\Ntrust\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->clear();

        $this->createRoles();
        $this->createPermissions();

        $this->attach($this->getRole('Administrator'), $this->getPermission('create-course'));
        $this->attach($this->getRole('Administrator'), $this->getPermission('manage-course'));
    }

    protected function createRoles()
    {
        $roles = [
            'Administrator',
            'Teacher',
            'Teaching Assistant',
            'Student',
        ];

        foreach ($roles as $r) {
            $role = new Role();
            $role->name = $r;
            $role->save();
        }
    }

    protected function createPermissions()
    {
        $permissions = [
            'create-course',
            'manage-course',
        ];

        foreach ($permissions as $p) {
            $permission = new Permission();
            $permission->name = $p;
            $permission->save();
        }
    }

    protected function attach(Role $role, Permission $permission)
    {
        $role->attachPermission($permission);
    }

    private function getRole(string $name): Role
    {
        return Role::where('name', $name)->firstOrFail();
    }

    private function getPermission(string $name): Permission
    {
        return Permission::where('name', $name)->firstOrFail();
    }

    protected function clear()
    {
        DB::delete('DELETE FROM roles WHERE 1');
        DB::delete('DELETE FROM permissions WHERE 1');

        if (config('database.default') === 'mysql') {
            DB::statement('ALTER TABLE roles AUTO_INCREMENT = 1');
            DB::statement('ALTER TABLE permissions AUTO_INCREMENT = 1');
        } elseif (config('database.default') === 'sqlite') {
            DB::statement('DELETE FROM sqlite_sequence WHERE name = ?', ['roles']);
            DB::statement('DELETE FROM sqlite_sequence WHERE name = ?', ['permissions']);
        }
    }
}
