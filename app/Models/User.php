<?php

namespace App\Models;

use App\Models\Datasets\UserRole;
use App\Models\Datasets\UserStatus;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * 
 * @property int $id
 * @property int $role_id
 * @property int $status_id
 * @property string $name
 * @property string $email
 * @property \Carbon\Carbon $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $oauth_access_tokens
 * @property \Illuminate\Database\Eloquent\Collection $oauth_auth_codes
 * @property \Illuminate\Database\Eloquent\Collection $oauth_clients
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User exclude($exclude = array())
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User statusRange($statusRange = array())
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User selectAll()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User paginateSimple($next = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 *
 * @package App\Models
 */
class User extends ModelBase implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, Notifiable;

    protected $table = 'users';
    public $timestamps = false;

	protected $casts = [
		'role_id' => 'int',
		'status_id' => 'int'
	];

	protected $dates = [
		'email_verified_at'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'role_id',
		'status_id',
		'name',
		'email',
		'email_verified_at',
		'password',
		'remember_token'
	];

    protected $attributes = [
        'role_id'   => UserRole::USER,
        'status_id' => UserStatus::ACTIVE,
    ];

    static function hasRole($role, self $model = null)
    {
        $model = $model ? $model : \Auth::user();
        if (!$model) {
            return false;
        }
        return $model->role_id == $role;
    }

    //---------------------------------------------------------

	public function oauth_access_tokens()
	{
		return $this->hasMany(\App\Models\OauthAccessToken::class);
	}

	public function oauth_auth_codes()
	{
		return $this->hasMany(\App\Models\OauthAuthCode::class);
	}

	public function oauth_clients()
	{
		return $this->hasMany(\App\Models\OauthClient::class);
	}
}
