<?php

namespace App\Entities;

use App\Exceptions\InvalidRoleException;
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
 * @mixin \Eloquent
 * @property int $role
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereRole($value)
 */
class User extends Authenticatable  implements MustVerifyEmail
{
    use Notifiable;

    const ROLE_USER = 1;
    const ROLE_ADMIN = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'email', 'password', 'role'
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
    ];

    static public function rolesList(): array
    {
        return [
            self::ROLE_USER => 'User',
            self::ROLE_ADMIN => 'Admin',
        ];
    }

    public function getRoleNameAttribute()
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
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function changeRole(int $role)
    {
        if (!array_key_exists($role, self::rolesList())) {
            throw new InvalidRoleException('Undefined role "' . $role . '"');
        }
        if ($role === $this->role) {
            throw new RoleAlreadyException('Role is already assigned.');
        }

        $this->update(['role' => $role]);
    }
}
