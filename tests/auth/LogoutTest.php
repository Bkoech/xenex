<?php


class LogoutTest extends TestCase
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

    public function testLogout()
    {
        $this->expectsEvents(\Illuminate\Auth\Events\Logout::class);

        $user = factory(\Xenex\User::class)->create();
        $this->actingAs($user);

        $this->post('/logout');
    }
}
