<?php


class RegisterTest extends TestCase
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

    public function testRegisterPage()
    {
        $this->visit('/register')
             ->seePageIs('/register')
             ->see('註冊');
    }

    public function testRegisterSuccess()
    {
        $user = factory(\Xenex\User::class)->make([
            'password' => bcrypt($password = str_random(20)),
        ]);

        $this->visit('/register')
             ->type($user->email, 'email')
             ->type($user->name, 'name')
             ->type($password, 'password')
             ->type($password, 'password_confirmation')
             ->press('註冊');

        $this->seeInDatabase('users', [
            'email' => $user->email,
            'name' => $user->name,
        ]);

        $this->assertTrue(\Hash::check($password, \Xenex\User::where('email', $user->email)->first()->password));
    }
}
