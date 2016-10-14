<?php

class LoginTest extends TestCase
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
        $this->visit('/login')
             ->seePageIs('/login')
             ->see('登入');
    }

    public function testLoginSuccess()
    {
        $user = factory(\Xenex\User::class)->create([
            'password' => bcrypt($password = str_random(20)),
        ]);

        $this->visit('/login')
             ->type($user->email, 'email')
             ->type($password, 'password')
             ->press('登入');

        $this->seePageIs('/home');
    }

    public function testLoginFailUserNotMatch()
    {
        $user = factory(\Xenex\User::class)->make([
            'password' => bcrypt($password = str_random(20)),
        ]);

        $this->visit('/login')
             ->type($user->email, 'email')
             ->type($password, 'password')
             ->press('登入');

        $this->seePageIs('/login')
             ->see(trans('auth.failed'));
    }

    public function testLoginFailTooManyRequests()
    {
        $user = factory(\Xenex\User::class)->create([
            'password' => bcrypt($password = str_random(20)),
        ]);
        $throttleCount = 10;

        while($throttleCount--) {
            $this->visit('/login')
                 ->type($user->email, 'email')
                 ->type(str_random(19), 'password')
                 ->press('登入');
        }

        $this->visit('/login')
             ->type($user->email, 'email')
             ->type($password, 'password')
             ->press('登入');

        $this->seePageIs('/login')
             ->see(trans('auth.throttle'));
    }
}
