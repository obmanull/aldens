<?php


namespace Feature\Cabinet;


use App\Entities\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use DatabaseTransactions;

    public function testPage()
    {
        $user = factory(User::class)->create();
        $user->markEmailAsVerified();

        $response = $this
            ->actingAs($user)
            ->get('cabinet/dashboard');

        $response
            ->assertStatus(200)
            ->assertSee('Dashboard');
    }
}