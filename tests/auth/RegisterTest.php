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

    public function testRegisterFailInvalidEmail()
    {
        $user = factory(\Xenex\User::class)->make([
            'email' => str_random(20),
        ]);

        $this->visit('/register')
             ->type($user->email, 'email')
             ->type($user->name, 'name')
             ->type($user->password, 'password')
             ->type($user->password, 'password_confirmation')
             ->press('註冊');

        $this->seePageIs('/register')
             ->see(trans('validation.email', ['attribute' => 'email']));
    }

    public function testRegisterFailEqualEmail()
    {
        $user = factory(\Xenex\User::class)->create();
        $user = factory(\Xenex\User::class)->make([
            'email' => $user->email,
        ]);

        $this->visit('/register')
             ->type($user->email, 'email')
             ->type($user->name, 'name')
             ->type($user->password, 'password')
             ->type($user->password, 'password_confirmation')
             ->press('註冊');

        $this->seePageIs('/register')
             ->see(trans('validation.unique', ['attribute' => 'email']));
    }

    public function testRegisterFailPasswordTooShort()
    {
        $user = factory(\Xenex\User::class)->make([
            'password' => bcrypt($password = str_random(random_int(1, 5))),
        ]);

        $this->visit('/register')
             ->type($user->email, 'email')
             ->type($user->name, 'name')
             ->type($password, 'password')
             ->type($password, 'password_confirmation')
             ->press('註冊');

        $this->seePageIs('/register')
             ->see(trans('validation.min.string'), ['attribute' => 'password']);
    }

    public function testRegisterFailPasswordNotMatch()
    {
        $user = factory(\Xenex\User::class)->make([
            'password' => bcrypt($password = str_random(20)),
        ]);

        $this->visit('/register')
             ->type($user->email, 'email')
             ->type($user->name, 'name')
             ->type($password, 'password')
             ->type(str_random(19), 'password_confirmation')
             ->press('註冊');

        $this->seePageIs('/register')
             ->see(trans('validation.confirmed', ['attribute' => 'password']));
    }

    public function testRegisterFailNameTooLong()
    {
        $user = factory(\Xenex\User::class)->make([
            'name' => str_random(256),
        ]);

        $this->visit('/register')
             ->type($user->email, 'email')
             ->type($user->name, 'name')
             ->type($user->password, 'password')
             ->type($user->password, 'password_confirmation')
             ->press('註冊');

        $this->seePageIs('/register')
             ->see(trans('validation.max.string', ['attribute' => 'name', 'max' => '255']));
    }
}
