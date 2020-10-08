<?php
namespace Pa\Core\Exceptions;

use Exception;

/**
 * Class notFoundException
 * @package Pa\Core\Exceptions
 */
class notFoundException extends Exception {
	public function __construct($message, $code = 0) {
		parent::__construct($message, $code);
	}
}