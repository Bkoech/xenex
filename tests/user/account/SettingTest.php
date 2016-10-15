<?php


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

    public function testSettingPage()
    {
        $user = factory(\Xenex\User::class)->create();
        $this->actingAs($user);

        $this->visit('/user/account/setting')
             ->see('帳號設定')
             ->see($user->email)
             ->see($user->name);
    }

    public function testSettingSuccess()
    {
        $user = factory(\Xenex\User::class)->create();
        $fakerUser = factory(\Xenex\User::class)->make();
        $this->actingAs($user);

        $this->visit('/user/account/setting')
             ->type($fakerUser->email, 'email')
             ->type($fakerUser->name, 'name')
             ->press('修改帳號資料');

        $this->seeInDatabase('users', [
            'email' => $fakerUser->email,
            'name' => $fakerUser->name,
        ]);
        $this->seePageIs('/user/account/setting')
             ->see('帳號資料變更成功');
    }

    public function testSettingNoChange()
    {
        $user = factory(\Xenex\User::class)->create();
        $this->actingAs($user);

        $this->visit('/user/account/setting')
             ->type($user->email, 'email')
             ->type($user->name, 'name')
             ->press('修改帳號資料');

        $this->seeInDatabase('users', [
            'email' => $user->email,
            'name' => $user->name,
        ]);
        $this->seePageIs('/user/account/setting')
             ->see('帳號資料未變更');
    }

    public function testSettingFailEqualEmail()
    {
        $user = factory(\Xenex\User::class)->create();
        $otherUser = factory(\Xenex\User::class)->create();
        $this->actingAs($user);

        $this->visit('/user/account/setting')
             ->type($otherUser->email, 'email')
             ->type($user->name, 'name')
             ->press('修改帳號資料');

        $this->seePageIs('/user/account/setting')
             ->see(trans('validation.unique', ['attribute' => 'email']));
    }
}
