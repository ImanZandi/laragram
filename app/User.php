<?php

namespace App;

use App\Laragram\Following\Follower;
use App\Laragram\Following\Following;
use App\Laragram\Following\FollowingStatusManager;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use Notifiable, Follower, Following, Searchable;
    // use trait for categorization methods in User model

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username'
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

    protected static function boot()
    {
        // static boot() method run automatic

        parent::boot(); // run parent class boot() method

        // when user want to register generate username for him/her automatic
        static::creating(function ($user) {
            /*
            $username = bcrypt($user->email); // make hashed username with email value
            // dd($username); // "$2y$04$WFYdcwDfPqjjXQKLfygFYeTYjCtg0d/e2wJ.M2GBw3hm/Jfhvc6Da"
            // should remove / and . in $username value , for search !!!
            $username = preg_replace('/[.\/]/', str_shuffle('abcd'), $username).time();
            // replace / and . to 'abcd' and add time to end of string value
            // dd($username); // "$2y$04$Plh9Kvbr2jzdbcda8o1a1Jx8u1wyelPQ7pBzxYbBNV1C2Zfiqlqz13yq1572360979"
            $user->username = $username; // add it to username column
            */
            // or
            // $user->username = $user->generateUsername();
            // $user like $this but we can't use $this
            // or
            // maybe we want set username when create user with factory , dont generate hashed username
            if (!$user->username) {
                // if username column empty then generate hashed username
                $user->username = $user->generateUsername();
            }
        });
    }

    function generateUsername() : string // need return statement , return string value
    {
        $username = bcrypt($this->email);
        // $this->email == $user->email , $this refer to $user->generateUsername();

        $username = preg_replace('/[.\/]/', str_shuffle('abcd'), $username).time();

        /*
        // if $username exists in 'username' column in users table
        while (User::where('username', $username)->exists()) {
            $this->generateUsername(); // make another username
        } */
        // or
        // whereUsername() == where username column
        while (User::whereUsername($username)->exists()) {
            // if $username exists in 'username' column in users table
            $this->generateUsername(); // make another username
            // username must be unique
        }

        return $username; // hashed username , string
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'owner_id');
    }

    public function path()
    {
        return '/users/' . $this->id;
        // $this->id == $user->id in UserTest.php in it_know_their_path() test
        // $this refer to $user at $user->path()

    }

}
