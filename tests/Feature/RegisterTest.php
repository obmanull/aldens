<?php

namespace Tests\Feature;

use App\Entities\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSuccess(): void
    {
        $user = factory(User::class)->make();

        $response = $this
            ->post('register', [
                'name' => $user->name,
                'email' => $user->email,
                'password' => '12345678',
                'password_confirmation' => '12345678',
            ])
            ->assertStatus(302);

        $response
            ->assertRedirect('login')
            ->assertSessionHas('success', 'Check your email and click on the link to verify.');
    }
}
