<?php

namespace App\Exceptions;

use Throwable;

class ApprovalExistsException extends \Exception implements Throwable
{
    /**
     * Report or log an exception.
     *
     * @return void
     */
    public function report()
    {
        \Log::debug('Approval already exists');
    }

}
