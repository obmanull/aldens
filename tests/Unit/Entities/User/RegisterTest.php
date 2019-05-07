<?php

namespace Tests\Unit\Entities;

use App\Entities\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testRegister(): void
    {
        $user = User::register(
            $name = 'alex',
            $email = 'alex@mail.ru',
            $password = 'password',
            );

        self::assertNotEmpty($user);

        self::assertEquals($name, $user->name);
        self::assertEquals($email, $user->email);

        self::assertNotEmpty($user->password);
        self::assertNotEquals($password, $user->password);

        self::assertTrue($user->isWait());
        self::assertFalse($user->isActive());
    }
}
