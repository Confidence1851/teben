<?php

namespace App\Models;

use App\Helpers\AppConstants;
use App\Traits\Constants;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use Constants;
    protected $guarded = [];

    public function getStatus(){
        return $this->status == AppConstants::ACTIVE_STATUS ? "Active" : "Inactive";
    }

    public function getPrice(){
        if ($price = $this->price > 0){
            return "NGN $price";
        }
        return "Free";
    }

    public function getAttachment($getPath = true)
    {
        $path = $this->mediaAttachmentsFilePath . '/' . $this->attachment;
        if ($getPath) {
            return $path;
        }
        return readFileUrl("encrypt" , $path);
    }

    public function getCoverImage()
    {
        return $this->mediaCoverImagePath . '/' . $this->image;
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function klass()
    {
        return $this->belongsTo(Klass::class, 'klass_id');
    }

    public function getDetailLink()
    {
        return route("media_collection.details", ["id" => $this->id, "slug" => slugify($this->title)]);
    }

    public function getCoverImageUrl()
    {
        return getFileFromStorage($this->mediaCoverImagePath . '/' . $this->image, "storage");
    }

    public function getEditLink()
    {
        return route("media_collection.factory", ["id" => $this->id]);
    }

    public function isVIdeo()
    {
        return $this->attachment_type == "Video";
    }

    public function author()
    {
        return  $this->belongsTo(User::class, 'author_id');
    }

    public function likes()
    {
        return  $this->hasMany(MediaLike::class, 'media_id');
    }

    public function comments()
    {
        return  $this->hasMany(MediaComment::class, 'media_id');
    }
}
