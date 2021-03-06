<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    
    
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'f_name','l_name', 'email', 'password','phone','user_role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function getAuthPassword()
    {
        return $this->password;
    }
    
    public function logoorders() {
      return $this->hasMany('\App\LogoOrder');
    }
    
    public function usercoupon() {
        return $this->hasMany('\App\UserusecCoupon','id');
   }
}
