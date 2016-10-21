<?php

class ManageTest extends TestCase
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

    public function testManagePage()
    {
        $user = factory(\Xenex\User::class)->create();
        $this->actingAs($user);

        $this->visit('/course')
             ->seePageIs('/course');
    }

    public function testCreateButton()
    {
        $user = factory(\Xenex\User::class)->create();
        $this->actingAs($user);

        $this->visit('/course')
             ->click('新增課程')
             ->seePageIs('/course/create');
    }
}
