<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SettingTest extends TestCase
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

    public function testLoginPage()
    {
        $user = factory(\Xenex\User::class)->create();
        $this->actingAs($user);

        $this->visit('/user/account/setting')
             ->see('帳號設定')
             ->see($user->email)
             ->see($user->name);
    }
}
