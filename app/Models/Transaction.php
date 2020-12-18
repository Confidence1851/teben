<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded=[];


    public function user(){
      return  $this->belongsTo(User::class);
    }

    public function account(){
        return  $this->belongsTo(SchoolAccount::class);
      }

    public function comments(){
      return $this->hasMany(Comment::class);
    }
}
