<?php


namespace App\Helpers;


class AppConstants
{
    const SERVER_ERR_CODE = 500;
    const BAD_REQ_ERR_CODE = 400;
    const AUTH_ERR_CODE = 401;
    const VALIDATION_ERR_CODE = 406;
    const GOOD_REQ_CODE = 200;


    const UNDEFINED_USER_TYPE = "UNDEFINED"; // represents "Undefined"
    const DEFAULT_USER_TYPE = "User"; // represents "Student"
    const ADMIN_USER_TYPE = "Admin";// represents "Admin"
    const TEACHER_USER_TYPE = "Teacher";// represents "Teacher"
    const PARENT_USER_TYPE = "Parent";// represents "Parent"

    const AUTH_TOKEN_EXP = 60; // auth otp token expiry in minutes
    const OTP_DEFAULT_LENGTH = 7;
    const MAX_PROFILE_PIC_SIZE = 2048;

    const MALE = 'Male';
    const FEMALE = 'Female';
    const OTHERS = 'Others';

    const PAGINATION_VAL = 20;

    const GG_PROVIDER = 'google';
    const FB_PROVIDER = 'facebook';

    const PAGINATION_SIZE_WEB = 50;


    const DEBIT_TRANSACTION = 0;
    const CREDIT_TRANSACTION = 1;

    const PENDING_TRANSACTION = 0;
    const COMPLETED_TRANSACTION = 1;
    const FAILED_TRANSACTION = 2;
    const CANCELLED_TRANSACTION = 3;

    const COUPON_TRANSACTION = 1;
    const WITHDRAW_TRANSACTION = 2;
    const ACTIVATE_REF_ACCOUNT_TRANSACTION = 3;
    const MEDIA_DOWNLOAD = 4;

    const DIRECT_REFERRAL_BONUS = 10;
    const INDIRECT_REFERRAL_BONUS = 10;
    const REFERRAL_ACTIVATION_FEE = 200;

    const DEFAULT_VIDEO_PRICE = 0;


    const PENDING_STATUS = 0;
    const ACTIVE_STATUS = 1;
    const INACTIVE_STATUS = 2;


    public static function ignoreApiKeysLog()
    {
        return ['token', '_token', 'password', 'auth_token', 'verified', 'registered'];
    }
}
