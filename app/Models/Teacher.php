<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $guarded=[];

    public function getStatusAttribute($status){
      return [
        '0' => 'Awaiting Approval',
        '1' => 'Approved',
        '2' => 'Suspended',
      ][$status];
    }

    public function user(){
      return  $this->belongsTo(User::class);
    }

    public function getUUID(){
        return $this->uuid.'.png';
    }
}
