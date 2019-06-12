<?php

namespace Tests\Feature\Cabinet;

use App\Entities\User;
use App\Services\Sms\SmsSender;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PhoneVerificationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testShowButton()
    {
        $user = factory(User::class)->create([
            'phone' => '79000000000',
            'phone_verified' => false,
        ]);
        $user->markEmailAsVerified();

        $response = $this
            ->actingAs($user)
            ->get('cabinet/profile');

        $response
            ->assertStatus(200)
            ->assertSee('<button type="submit" class="btn btn-sm btn-success">Verify</button>');
    }

    public function testVerifyRequest()
    {
        $user = factory(User::class)->create([
            'phone' => '79000000000',
            'phone_verified' => false,
            'phone_verify_token' => null,
            'phone_verify_token_expire' => null,
        ]);
        $user->markEmailAsVerified();

        $response = $this
            ->actingAs($user)
            ->post('cabinet/phone/verify/request');

        $response
            ->assertStatus(302)
            ->assertRedirect('http://aldens.test/cabinet/phone/verify/form');
    }

    public function testIncorrectTokenError()
    {
        $user = factory(User::class)->create([
            'phone' => '79000000000',
            'phone_verified' => false,
            'phone_verify_token' => null,
            'phone_verify_token_expire' => null,
        ]);
        $user->markEmailAsVerified();

        $this
            ->actingAs($user)
            ->post('cabinet/phone/verify/request');

        $response = $this
            ->actingAs($user)
            ->post('cabinet/phone/verify', ['token' => '123456']);

        $response
            ->assertSessionHas('error', 'Token is incorrect.');
    }

    public function testVerify()
    {
        $user = factory(User::class)->create([
            'phone' => '79000000000',
            'phone_verified' => false,
            'phone_verify_token' => null,
            'phone_verify_token_expire' => null,
        ]);
        $user->markEmailAsVerified();

        $this
            ->actingAs($user)
            ->post('cabinet/phone/verify/request');


        // get token from message
        $text = app(SmsSender::class)->lastMessage()['text'];
        preg_match('/\d+/', $text,$matches);
        $token = $matches[0];

        $response = $this
            ->actingAs($user)
            ->post('cabinet/phone/verify', ['token' => $token]);

        $response
            ->assertRedirect('cabinet/profile')
            ->assertSessionMissing(['error', 'Token is incorrect.']);
    }
}
