<?php

namespace App\Enums;

class Messages
{
    const LOGIN_SUCCESS = 'Login successful';
    const LOGOUT_SUCCESS = 'Successfully logged out';
    const FAILED_LOGIN = 'invalid email or password';
    const REQ_APPROVED = 'Request has been successfully approved';
    const REQ_DECLINED = 'Request has been successfully declined';

    const ADMIN_ACCESS_REQUIRED= 'You must be and administrator to perform this request';
    const DENY_MESSAGE= 'You must be an administrator and not be the initiator of this request to perform this action';

}
