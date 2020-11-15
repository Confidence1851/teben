<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    public function upline(){
        return $this->belongsTo(User::class , "referrer_id");
    }


    public function user(){
        return $this->belongsTo(User::class , "user_id");
    }

}
