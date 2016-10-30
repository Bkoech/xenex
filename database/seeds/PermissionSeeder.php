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
}
