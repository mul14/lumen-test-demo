<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['email', 'password'];

    public static function register($email, $password)
    {
        return self::create([
            'email'    => $email,
            'password' => bcrypt($password)
        ]);
    }

}
