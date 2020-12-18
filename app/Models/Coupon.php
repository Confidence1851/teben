<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $guarded=[];

    public function agent(){
        return $this->belongsTo(User::class,'agent_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function school_account(){
        return $this->belongsTo(SchoolAccount::class);
    }
}
