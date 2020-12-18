<?php

namespace App\Traits;

use App\Helpers\AppConstants;
use App\Media as AppMedia;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Media
{
    use Constants;
    
    public function store(array $data)
    {

        $cover_filename = $this->saveCoverImage($data["image"] ?? null);

        $attachment = $this->saveAttachment($data["attachment"] ?? null);

        $size = bytesToHuman(File::size($attachment['attachment']));
        $attachType = getFileType($attachment['type']);

       $data['image'] = $cover_filename;
       $data['attachment'] = $attachment['filename'];
       $data['attachment_type'] = $attachType;
       $data['size'] = $size;
       return AppMedia::create($data);

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
        return resizeImageandSave($cover_image , $this->mediaCoverImagePath);
    }


}