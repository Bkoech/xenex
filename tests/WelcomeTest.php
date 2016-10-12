<?php


class ExampleTest extends TestCase
{
    /**
     * Test welcome page.
     *
     * @return void
     */
    public function testWelcomePage()
    {
        $this->visit('/')
             ->see(config('app.name'));
    }

    public function testLoginButton()
    {
        $this->visit('/')
             ->click('登入')
             ->seePageIs('/login');
    }

    public function testRegisterButton()
    {
        $this->visit('/')
             ->click('註冊')
             ->seePageIs('/register');
    }
}
