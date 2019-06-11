<?php

namespace Tests\Unit;

use App\Entities\User;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RequestPhoneVerificationTest extends TestCase
{
    use DatabaseTransactions;

    public function testDefault()
    {
        $user = factory(User::class)->create([
            'phone' => "79000000000",
            'phone_verified' => false,
            'phone_verify_token' => null,
            'phone_verify_token_expire' => null,
        ]);

        $this->assertEquals($user->requestPhoneVerification(Carbon::now()), $user->phone_verify_token);
        $this->assertFalse($user->isPhoneVerified());
        $this->assertNotEmpty($user->phone_verify_token);
        $this->assertNotEmpty($user->phone_verify_token_expire);
    }

    public function testEmptyPhoneError()
    {
        $user = factory(User::class)->create([
            'phone' => null,
            'phone_verified' => false,
            'phone_verify_token' => null,
            'phone_verify_token_expire' => null,
        ]);

        $this->expectExceptionMessage('Phone number is empty.');
        $user->requestPhoneVerification(Carbon::now());
    }

    public function testAlreadyRequestedError()
    {
        $user = factory(User::class)->create([
            'phone' => "79000000000",
            'phone_verified' => false,
            'phone_verify_token' => null,
            'phone_verify_token_expire' => null,
        ]);

        $this->expectExceptionMessage('Token is already requested.');
        $user->requestPhoneVerification(Carbon::now());
        $user->requestPhoneVerification(Carbon::now());
    }

    public function testRequestWithOldPhone(): void
    {
        $user = factory(User::class)->create([
            'phone' => '79000000000',
            'phone_verified' => true,
            'phone_verify_token' => null,
        ]);

        self::assertTrue($user->isPhoneVerified());

        $user->requestPhoneVerification(Carbon::now());

        self::assertFalse($user->isPhoneVerified());
        self::assertNotEmpty($user->phone_verify_token);
    }

    public function testRequestAlreadySentTimeout(): void
    {
        $user = factory(User::class)->create([
            'phone' => '79000000000',
            'phone_verified' => true,
            'phone_verify_token' => null,
        ]);

        $user->requestPhoneVerification($now = Carbon::now());
        $user->requestPhoneVerification($now->copy()->addSeconds(500));

        self::assertFalse($user->isPhoneVerified());
    }
}
