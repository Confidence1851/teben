<?php

namespace App;

use App\Traits\Constants;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use Constants;
    protected $guarded = [];

    public function getAttachment(){
        return $this->mediaAttachmentsFilePath.'/'.$this->attachment;
    }

    public function getCoverImage(){
        return $this->mediaCoverImagePath.'/'.$this->image;
    }

    public function subject(){
        return $this->belongsTo(Subject::class , 'subject_id');
    }

    public function klass(){
        return $this->belongsTo(Klass::class , 'klass_id');
    }


    public function getLink(){
        return route("media_collection.details" , ["id" => $this->id , "slug" => slugify($this->title)]);
    }
}
