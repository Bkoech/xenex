<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManageTest extends TestCase
{
    use DatabaseTransactions;

    public function testManagePageIfUserIsAdmin()
    {
        $user = factory(\Xenex\User::class)->create();
        $user->attachRole(\Xenex\Ntrust\Role::where('name', 'Administrator')->firstOrFail());
        $this->actingAs($user);

        $this->visit('/course')
             ->seePageIs('/course');
    }

    public function testManagePageIfUserIsNotAdmin()
    {
        $user = factory(\Xenex\User::class)->create();
        $this->actingAs($user);

        $this->get('/course')
             ->assertResponseStatus(403);
    }

    public function testCreateButtonIfUserIsAdmin()
    {
        $user = factory(\Xenex\User::class)->create();
        $user->attachRole(\Xenex\Ntrust\Role::where('name', 'Administrator')->firstOrFail());
        $this->actingAs($user);

        $this->visit('/course')
             ->click('新增課程')
             ->seePageIs('/course/create');
    }

    public function testCreateButtonIfUserIsNotAdmin()
    {
        $user = factory(\Xenex\User::class)->create();
        $this->actingAs($user);

        $this->get('/course')
             ->assertResponseStatus(403);
    }
}
