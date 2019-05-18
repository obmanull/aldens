<?php

namespace Tests\Unit\Entities\User;

use App\Entities\User;
use App\Exceptions\InvalidRoleException;
use App\Exceptions\RoleAlreadyException;
use http\Exception\InvalidArgumentException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testChange(): void
    {
        $user = factory(User::class)->create(['role' => User::ROLE_USER]);

        self::assertFalse($user->isAdmin());


        $user->changeRole(User::ROLE_ADMIN);

        self::assertTrue($user->isAdmin());
    }

    public function testInvalid(): void
    {
        $user = factory(User::class)->create(['role' => User::ROLE_USER]);

        $role = 1234;
        $this->expectException(InvalidRoleException::class);
        $user->changeRole($role);
    }

    public function testAlready(): void
    {
        $user = factory(User::class)->create(['role' => User::ROLE_USER]);

        $user->changeRole(User::ROLE_ADMIN);
        $this->expectException(RoleAlreadyException::class);
        $user->changeRole(User::ROLE_ADMIN);
    }
}
