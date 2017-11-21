<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Eloquent  implements Authenticatable,CanResetPasswordContract  
{
    use Notifiable;
    use AuthenticableTrait;
    use CanResetPassword;

     protected $connection = 'mongodb';
     protected $collection = 'users';
  /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
   //
   //  public function sendPasswordResetNotification($token)
   // {
   //     $this->notify(new ResetPasswordNotification($token));
   // }
}
