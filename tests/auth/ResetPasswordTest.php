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
        $this->assertTrue(\Hash::check($password, \Xenex\User::where('email', $user->email)->first()->password));
    }
}
