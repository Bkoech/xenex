<?php

use Illuminate\Database\Seeder;
use Xenex\Ntrust\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
}
