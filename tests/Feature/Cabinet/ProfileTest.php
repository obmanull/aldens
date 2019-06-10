<?php

namespace Tests\Feature;

use App\Entities\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPage()
    {
        $user = factory(User::class)->create();
        $user->markEmailAsVerified();

        $response = $this
            ->actingAs($user)
            ->get('cabinet/profile');

        $response
            ->assertStatus(200)
            ->assertSee('Dashboard');
    }

    public function testUpdateErrors()
    {
        $user = factory(User::class)->create();
        $user->markEmailAsVerified();

        $response = $this
            ->actingAs($user)
            ->post('cabinet/profile/update/' . $user->id, [
                'last_name' => '',
                'name' => '',
            ]);
        $response
            ->assertStatus(302)
            ->assertSessionHasErrors(['last_name', 'name']);
    }


    public function testUpdate()
    {
        $user = factory(User::class)->create();
        $user->markEmailAsVerified();

        $newUser = factory(User::class)->make(['phone' => '79000000000']);
        $response = $this
            ->actingAs($user)
            ->post('cabinet/profile/update/' . $user->id, [
                'last_name' => $newUser->last_name,
                'name' => $newUser->name,
                'phone' => $newUser->phone,
            ]);


        $response
            ->assertSessionHasNoErrors()
            ->assertSessionHas('status', 'Profile update successful');
    }
}
