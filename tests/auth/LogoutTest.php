<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class LogoutTest extends TestCase
{
    use DatabaseTransactions;

    public function testLogout()
    {
        $user = factory(\Xenex\User::class)->create();
        $this->actingAs($user);

        $this->post('/logout');

        $this->assertFalse(Auth::check());
    }
}
