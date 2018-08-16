<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use DB;
use function App\__construct;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    /**
     * @var string
     */
    protected $table = 'users';
    protected $connection = 'organiser';



    protected $fillable = [
        'name',
        'email',
        'password',
        'remember_token',
        'user_role',
    ];

}
