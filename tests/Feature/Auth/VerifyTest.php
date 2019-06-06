<?php

namespace Tests\Feature\Auth;

use App\Entities\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VerifyTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testBase()
    {
        $user = factory(User::class)->create();

        $response = $this
            ->actingAs($user)
            ->get('cabinet/dashboard');

        $response
            ->assertRedirect('email/verify');

        $user->markEmailAsVerified();

        $response = $this
            ->actingAs($user)
            ->get('cabinet/dashboard');
        $response
            ->assertStatus(200)
            ->assertSee('Dashboard');
    }
}
