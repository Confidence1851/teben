<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $guarded=[];

    public function accounts(){
        return $this->hasMany(SchoolAccount::class , 'school_id');
    }
}
