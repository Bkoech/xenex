<?php

class ResetPasswordTest extends TestCase
{
    use DatabaseToTest;
    use \MailThief\Testing\InteractsWithMail;

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

    public function testResetSuccess()
    {
        $user = factory(\Xenex\User::class)->create();
        $this->visit('/password/reset')
             ->type($user->email, 'email')
             ->press('寄發密碼重設信件');

        $token = \DB::select('SELECT token FROM password_resets WHERE email=?', [$user->email])[0]->token;

        $this->visit("/password/reset/$token")
             ->type($user->email, 'email')
             ->type($password = str_random(20), 'password')
             ->type($password, 'password_confirmation')
             ->press('重設密碼');

        $this->seePageIs('/home');
        $this->assertTrue(Auth::check());
        $this->assertTrue(Hash::check($password, \Xenex\User::where('email', $user->email)->first()->password));
    }

    public function testResetFailInvalidUser()
    {
        $user = factory(\Xenex\User::class)->create();
        $fakerUser = factory(\Xenex\User::class)->create();
        $this->visit('/password/reset')
             ->type($user->email, 'email')
             ->press('寄發密碼重設信件');
        $token = DB::select('SELECT token FROM password_resets WHERE email=?', [$user->email])[0]->token;

        $this->visit("/password/reset/$token")
             ->type($fakerUser->email, 'email')
             ->type($password = str_random(20), 'password')
             ->type($password, 'password_confirmation')
             ->press('重設密碼');

        $this->seePageIs("/password/reset/$token")
             ->see(trans('passwords.token'));
    }

    public function testResetFailInvalidToken()
    {
        $user = factory(\Xenex\User::class)->create();

        $this->visit('/password/reset/'.$token = str_random(20))
             ->type($user->email, 'email')
             ->type($password = str_random(20), 'password')
             ->type($password, 'password_confirmation')
             ->press('重設密碼');

        $this->seePageIs("/password/reset/$token")
             ->see(trans('passwords.token'));
    }

    public function testResetFailPasswordNotMatch()
    {
        $user = factory(\Xenex\User::class)->create();
        $this->visit('/password/reset')
             ->type($user->email, 'email')
             ->press('寄發密碼重設信件');
        $token = DB::select('SELECT token FROM password_resets WHERE email=?', [$user->email])[0]->token;

        $this->visit("/password/reset/$token")
             ->type($user->email, 'email')
             ->type(str_random(20), 'password')
             ->type(str_random(19), 'password_confirmation')
             ->press('重設密碼');

        $this->seePageIs("/password/reset/$token")
             ->see(trans('validation.confirmed', ['attribute' => 'password']));
    }
}
