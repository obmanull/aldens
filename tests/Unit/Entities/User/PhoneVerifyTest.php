<?php

namespace Tests\Unit;

use App\Entities\User;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PhoneVerifyTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testDefault()
    {
        $user = factory(User::class)->create([
            'phone_verify_token' => $token = 'token',
            'phone_verify_token_expire' => Carbon::now()->addSeconds(User::PHONE_TOKEN_EXPIRED)
        ]);

        $user->verifyPhone(Carbon::now(), $token);

        $this->assertTrue($user->isPhoneVerified());
        $this->assertTrue($user->phone_verified);
        $this->assertNull($user->phone_verify_token);
        $this->assertNull($user->phone_verify_token_expire);
    }

    public function testIncorrectTokenError()
    {
        $user = factory(User::class)->create([
            'phone' => "79000000000",
            'phone_verified' => false,
            'phone_verify_token' => 'token',
            'phone_verify_token_expire' => null,
        ]);

        $this->expectExceptionMessage('Token is incorrect.');
        $user->verifyPhone(Carbon::now(), 'other_token');
    }

    public function testTokenExpiredError()
    {
        $user = factory(User::class)->create([
            'phone' => "79000000000",
            'phone_verified' => false,
            'phone_verify_token' => $token = 'token',
            'phone_verify_token_expire' => $now = Carbon::now()->addSeconds(User::PHONE_TOKEN_EXPIRED),
        ]);

        $this->expectExceptionMessage('Token is expired.');
        $user->verifyPhone($now->copy()->addSeconds(User::PHONE_TOKEN_EXPIRED + 1), $token);
    }

}
