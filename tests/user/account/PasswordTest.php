<?php


class PasswordTest extends TestCase
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

    public function testPasswordPage()
    {
        $user = factory(\Xenex\User::class)->create();
        $this->actingAs($user);

        $this->visit('/user/account/password')
             ->seePageIs('/user/account/password')
             ->see('密碼設定');
    }

    public function testPasswordSuccess()
    {
        $user = factory(\Xenex\User::class)->create([
            'password' => bcrypt($password = str_random(20)),
        ]);
        $this->actingAs($user);

        $this->visit('/user/account/password')
             ->type($password, 'current_password')
             ->type($newPass = str_random(20), 'password')
             ->type($newPass, 'password_confirmation')
             ->press('修改密碼');

        $this->seePageIs('/user/account/password')
             ->see('密碼已修改成功，下次登入時請使用新密碼');
        $this->assertTrue(Hash::check($newPass, Xenex\User::find($user->id)->password));
    }

    public function testPasswordFailErrorCurrentPassword()
    {
        $user = factory(\Xenex\User::class)->create();
        $this->actingAs($user);

        $this->visit('/user/account/password')
             ->type(str_random(20), 'current_password')
             ->type($newPass = str_random(20), 'password')
             ->type($newPass, 'password_confirmation')
             ->press('修改密碼');

        $this->seePageIs('/user/account/password')
             ->see('現在密碼錯誤，無法修改密碼');
        $this->seeInDatabase('users', ['password' => $user->password]);
    }
}
