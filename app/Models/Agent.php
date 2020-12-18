<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
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
}
