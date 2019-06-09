<?php

namespace App\Entities;

use App\Exceptions\IncorrectTokenException;
use App\Exceptions\InvalidRoleException;
use App\Exceptions\PhoneIsEmptyException;
use App\Exceptions\PhoneTokenExpiredException;
use App\Exceptions\PhoneVerificationAlreadyException;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Boolean;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\RoleAlreadyException;


/**
 * App\Entities\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereUpdatedAt($value)
 * @method saveOrFail(array $options = [])
 * @mixin \Eloquent
 * @property int $role
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereRole($value)
 * @property string|null $last_name
 * @property string|null $phone
 * @property int $phone_verified
 * @property string|null $phone_verify_token
 * @property Carbon $phone_verify_token_expire
 * @property-read mixed $role_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User wherePhoneVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User wherePhoneVerifyToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User wherePhoneVerifyTokenExpire($value)
 */
class User extends Authenticatable  implements MustVerifyEmail
{
    use Notifiable;

    const ROLE_USER = 1;
    const ROLE_ADMIN = 2;

    const PHONE_TOKEN_EXPIRED = 300;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'email', 'password', 'role', 'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verify_token_expire' => 'datetime',
        'phone_verified' => 'boolean',
    ];

    static public function rolesList(): array
    {
        return [
            self::ROLE_USER => 'User',
            self::ROLE_ADMIN => 'Admin',
        ];
    }

    public function getRoleNameAttribute(): string
    {
        if (!array_key_exists($this->role, self::rolesList())) {
            throw new InvalidRoleException('Undefined role "' . $this->role . '"');
        }

        return self::rolesList()[$this->role];
    }

    /**
     * @param $name
     * @param $email
     * @param $password
     * @param int $role
     * @return User
     */
    public static function register($name, $email, $password, $role = User::ROLE_USER): self
    {
        return self::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $role,
        ]);
    }

    /**
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->email_verified_at !== null;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function changeRole(int $role): void
    {
        if (!array_key_exists($role, self::rolesList())) {
            throw new InvalidRoleException('Undefined role "' . $role . '"');
        }
        if ($role === $this->role) {
            throw new RoleAlreadyException('Role is already assigned.');
        }

        $this->update(['role' => $role]);
    }

    public function isPhoneVerified(): bool
    {
        return $this->phone_verified;
    }

    public function requestPhoneVerification(Carbon $now): string
    {
        if (empty($this->phone)) {
            throw new PhoneIsEmptyException('Phone number is empty.');
        }

        if (!empty($this->phone_verify_token) && $this->phone_verify_token_expire && $this->phone_verify_token_expire->gt($now)) {
            throw new PhoneVerificationAlreadyException('Token is already requested.');
        }

        $this->phone_verified = false;
        $this->phone_verify_token = (string) random_int(10000, 99999);
        $this->phone_verify_token_expire = $now->copy()->addSeconds(self::PHONE_TOKEN_EXPIRED);
        $this->saveOrFail();

        return $this->phone_verify_token;
    }

    public function verifyPhone(Carbon $now, $token): void
    {
        if ($token !== $this->phone_verify_token) {
            throw new IncorrectTokenException('Token is incorrect.');
        }

        if (!empty($this->phone_verify_token) && $this->phone_verify_token_expire && $this->phone_verify_token_expire->lt($now)) {
            throw new PhoneTokenExpiredException('Token is expired.');
        }

        $this->phone_verified = true;
        $this->phone_verify_token = null;
        $this->phone_verify_token_expire = null;
        $this->saveOrFail();
    }

    public function unverifyPhone()
    {
        $this->phone_verified = false;
        $this->phone_verify_token = null;
        $this->phone_verify_token_expire = null;
        $this->saveOrFail();
    }
}
