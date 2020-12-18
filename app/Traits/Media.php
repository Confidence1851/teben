<?php

namespace App\Traits;

use App\Helpers\AppConstants;
use App\Models\Media as AppMedia;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Media
{
    use Constants;

    public function store(array $data)
    {
        if(!empty($image = $data["image"] ?? null)){
            $data['image'] = $this->saveCoverImage($image);
        }

        if(!empty($attachment = $data["attachment"] ?? null)){
            $attachment = $this->saveAttachment($attachment);
            $size = bytesToHuman(File::size($attachment['attachment']));
            $attachType = getFileType($attachment['type']);
            $data['attachment'] = $attachment['filename'];
            $data['attachment_type'] = $attachType;
            $data['size'] = $size;
        }
        
       return AppMedia::updateOrCreate(
           ["id" => $data["id"]] ,
           $data
        );
    }

   
    public function saveAttachment($attachment = null){
        $type = $attachment->getClientOriginalExtension();
        $filename = putFileInPrivateStorage($attachment , $this->mediaAttachmentsFilePath);

        return [
            'attachment' => $attachment,
            'type' => $type,
            'filename' => $filename,
        ];
    }


    public function saveCoverImage($cover_image = null){
        return resizeImageandSave($cover_image , $this->mediaCoverImagePath , 'local' , 1080 , 780 );
    }


}