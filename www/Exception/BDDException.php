<?php
namespace Pa\Exception;

use Exception;

class BDDException extends Exception
{
    /**
     * BDDException constructor.
     * @param $message
     * @param int $code
     */
    public function __construct($message, $code=0)
    {
        parent::__construct($message, $code);
    }
}