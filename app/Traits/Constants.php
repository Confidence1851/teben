<?php

namespace App\Traits;

trait Constants
{

    /**
     * User Role
     * @return int 0
     */
    public $userRole = 0;


    /**
     * Instructor Role
     * @return int 1
     */
    public $instructorRole = 1;

    /**
     * Blogger Role
     * @return int 2
     */
    public $bloggerRole = 2;

    /**
     * Sub Admin Role
     * @return int 3
     */
    public $subAdminRole = 3;


    /**
     * Blogger Role
     * @return int 5
     */
    public $adminRole = 5;



    //Http Statuses

    /**
     * Success
     * @return int 200
     */
    public $successResponse = 200;

    /**
     * Created
     * @return int 201
     */
    public $createdResponse = 201;

    /**
     * Unauthorized
     * @return int 401
     */
    public $unauthorizedResponse = 401;

    /**
     * Bad Request
     * @return int 400
     */
    public $badRequestResponse = 400;

    /**
     * Not Found
     * @return int 404
     */
    public $notFoundErrorResponse = 404;

    /**
     * Validation error
     * @return int 422
     */
    public $validationErrorResponse = 422;

    /**
     * Server error
     * @return int 500
     */
    public $serverErrorResponse = 500;



    // App Statuses

    /**
     * Pending Status
     * @return  0
     */
    public $pendingStatus = 0;

    /**
     * Active Status
     * @return  1
     */
    public $activeStatus = 1;

    /**
     * Declined Status
     * @return int 2
     */
    public $inactiveStatus = 2;

    /**
     * Disabled Status
     * @return int 3
     */
    public $disabledStatus = 3;


    /**
     * Processing Status
     * @return int 4
     */
    public $processingStatus = 4;


    /**
     * Compeleted Status
     * @return int 5
     */
    public $completedStatus = 5;

    /**
     * Cancelled Status
     * @return int 6
     */
    public $cancelledStatus = 6;


    




    /**Get status of model */
    public function getModelStatus($status){
        switch($status){
            case $this->pendingStatus:
                return 'Pending';
            case $this->activeStatus:
                return 'Active';
            case $this->inactiveStatus:
                return 'Inactive';
            case $this->disabledStatus:
                return 'Disabled';
            case $this->processingStatus:
                return 'Processing';
            case $this->completedStatus:
                return 'Completed';
            case $this->cancelledStatus:
                return 'Cancelled';
            default:
                return null;
        }
    }

    public function getStatusList($index = null){
        return [
            $this->pendingStatus ,
            $this->activeStatus ,
            $this->declinedStatus ,
            $this->disabledStatus ,
            $this->processingStatus ,
            $this->completedStatus ,
            $this->cancelledStatus ,
        ];
    }



     /**
     * User images file path
     * @return string
     */
    public $userImagePath = 'users/avatars';


     /**
     * Media Attachments  file path
     * @return string
     */
    public $mediaAttachmentsFilePath = 'media/attachments';

    /**
     * Media cover images file path
     * @return string
     */
    public $mediaCoverImagePath = 'media/cover';

    /**
     * User avatar images file path
     * @return string
     */
    public $userAvatarImagePath = 'images/avatar';

    /**
     * Receipt  images file path
     * @return string
     */
    public $receiptImagePath = 'images/receipts';

    /**
     * Course Categories images file path
     * @return string
     */
    public $courseCategoryImagePath = 'images/course/categories';

    /**
     * Course Preview images file path
     * @return string
     */
    public $coursePreviewImagePath = 'images/course/preview';

    /**
     * Course Section images file path
     * @return string
     */
    public $courseSectionImagePath = 'images/course/sections';

    /**
     * Course Section videos file path
     * @return string
     */
    public $courseSectionVideoPath = 'video/course/sections';


    /**
     * Course Section Resource images file path
     * @return string
     */
    public $courseSectionResourceImagePath = 'images/course/sections_resources';

    /**
     * Course Section Resource videos file path
     * @return string
     */
    public $courseSectionResourceVideoPath = 'videos/course/sections_resources';

    /**
     * Course Section Resource documents file path
     * @return string
     */
    public $courseSectionResourceDocPath = 'documents/course/sections_resources';

    /**
     * Order Receipts file path
     * @return string
     */
    public $orderReceiptsFilePath = 'files/orders/receipts';


     /**
     * Course Test Question file path
     * @return string
     */
    public $courseTestQuestionPath = 'files/course/tests/questions';

    /**
     * Course Test Answers file path
     * @return string
     */
    public $courseTestAnswerPath = 'files/course/tests/answers';


}

