<?php

use Xenex\Ntrust\Role;

class CreateTest extends TestCase
{
    use DatabaseToTest;

    public function setUp()
    {
        parent::setUp();
        $this->initDatabase();
    }

    public function tearDown()
    {
        $this->resetDatabase();
        parent::tearDown();
    }

    public function testCreatePage()
    {
        $user = factory(\Xenex\User::class)->create();
        $user->attachRole(Role::where('name', 'Administrator')->firstOrFail());
        $this->actingAs($user);

        $this->visit('/course/create')
             ->seePageIs('/course/create');
    }

    public function testCreateSuccess()
    {
        $user = factory(\Xenex\User::class)->create();
        $user->attachRole(Role::where('name', 'Administrator')->firstOrFail());
        $this->actingAs($user);

        $course = factory(\Xenex\Course\Course::class)->make();
        $this->visit('/course/create')
             ->type($course->serial, 'serial')
             ->type($course->name, 'name')
             ->type($course->start_at, 'start_at')
             ->type($course->end_at, 'end_at')
             ->press('新增課程');

        $this->seePageIs('/course')
             ->see('課程建立成功')
             ->see($course->serial)
             ->see($course->name)
             ->seeInDatabase('courses', $course->toArray());
    }
}
