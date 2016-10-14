<?php

class ForgotPasswordTest extends TestCase
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

    public function testForgotPage()
    {
        $this->visit('/password/reset')
             ->seePageIs('/password/reset')
             ->see('重設密碼');
    }

    public function testForgotSuccess()
    {
        $user = factory(\Xenex\User::class)->create();

        $this->visit('/password/reset')
             ->type($user->email, 'email')
             ->press('寄發密碼重設信件');

        $this->seeMessageFor($user->email);
        $this->seeMessageWithSubject('Reset Password');
        $this->seeInDatabase('password_resets', [
            'email' => $user->email,
        ]);
    }

    public function testForgotFailInvalidUser()
    {
        $user = factory(\Xenex\User::class)->make();

        $this->visit('/password/reset')
             ->type($user->email, 'email')
             ->press('寄發密碼重設信件');

        $this->seePageIs('/password/reset')
             ->see(trans('validation.exists', ['attribute' => 'email']));
    }
}
