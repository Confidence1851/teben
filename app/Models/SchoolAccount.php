<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolAccount extends Model
{
    protected $guarded=[];

    public function klass(){
        return $this->belongsTo(Klass::class , 'klass_id');
    }

    public function school(){
        return $this->belongsTo(School::class , 'school_id');
    }
}
