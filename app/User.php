<?php

namespace App;

use App\Traits\Constants;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable //implements MustVerifyEmail
{
    use Notifiable , Constants;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'uuid','role', 'username',
        'avatar' ,'phone', 'gender','marital_status','state',
        'address','country','wallet','status','role', 'lga', 'town',
        'dob','id_card','id_type',
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

    public function teacher(){
        return $this->hasOne(Teacher::class);
    }

    public function downlines(){
        return $this->hasMany(Referral::class , "referrer_id");
    }

    public function referral(){
        return $this->hasOne(Referral::class , "user_id");
    }

    public function agent(){
        return $this->hasOne(Agent::class);
    }

    public function bank(){
        return $this->hasOne(Bank::class);
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function getStatusAttribute($status){
        return[
            '0' => 'Disabled',
            '1' => 'Active',
        ][$status];
    }

    public function getAvatar(){
        if(!empty($this->avatar)){
           return route('read_file' , encrypt($this->avatarPath()));
        }
        return my_asset('user.png');
    }

    public function avatarPath(){
        return $this->userAvatarImagePath.'/'.$this->avatar;
    }

    public function getUUID(){
        return $this->uuid.'.png';
    }
}
