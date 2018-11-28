<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Dirape\Token\Token;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Declare table
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 'nick_name', 'gender', 'password', 'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    // CONST
    const TOKEN_TIME_VALID = 7;
    const TOKEN_LENGTH = 60;
    const NICK_NAME_MIN_LENGTH = 6;
    const NICK_NAME_MAX_LENGTH = 16;
    const MAX_GENDER = 1;
    const DEFAULT_AVATAR = 'default.jpg';
    const PATH_AVATAR = '/test/public/avatar';
    const AVATAR_LENGTH = 60;

    /**
     * Find user login by user_name and password.
     *
     * @param Request $request Request
     *
     * @return User
     */
    public function findUserLogin($request)
    {
        return $this->where([
                'user_name' => $request->input('user_name'),
                'password' => md5($request->input('password'))
            ])
            ->first();
    }

    /**
     * Find user login by user_name and password.
     *
     * @param String $token Token
     *
     * @return User
     */
    public function findUserByToken($token)
    {
        return $this->where('api_token', $token)-> first();
    }

    /**
     * Generator new token.
     *
     * @return string
     */
    public function generatorNewToken()
    {
        return (new Token())->Unique('users', 'api_token', User::TOKEN_LENGTH);
    }

    /**
     * Get url avtar.
     *
     * @param String $avatar Avatar
     *
     * @return string
     */
    public function getUrlAvatar($avatar)
    {
        return $this::PATH_AVATAR.'/'.$avatar;
    }

    /**
     * Validation nick_name.
     *
     * @param String $nick_name nick_name
     *
     * @return bool
     */
    public function validationNickName($nick_name)
    {
        $length = strlen($nick_name);
        if ($length < $this::NICK_NAME_MIN_LENGTH || $length > $this::NICK_NAME_MAX_LENGTH)
        {
            return false;
        }
        return true;
    }

    /**
     * Validation gender.
     *
     * @param Integer $gender gender
     *
     * @return bool
     */
    public function validationGender($gender)
    {
        if ($gender > $this::MAX_GENDER)
        {
            return false;
        }
        return true;
    }
}
