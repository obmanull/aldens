<?php

namespace Tests\Unit;

use App\Entities\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PhoneTest extends TestCase
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
            'phone' => null,
            'phone_verified' => false,
            'phone_verify_token' => null,
            'phone_verify_token_expire' => null,
        ]);

        $this->assertFalse($user->isPhoneVerified());
    }

    public function testRequestEmptyPhone()
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

    public function testRequestPhoneVerification()
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

    public function testAlreadyRequested()
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

}
