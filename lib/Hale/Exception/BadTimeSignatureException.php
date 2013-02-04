<?php
namespace Hale\Exception;

use \Hale\Exception\BadSignatureException;

/**
 * Raised for time based signatures that fail.
 */
class BadTimeSignatureException extends BadSignatureException
{

    public function __construct(
        $message,
        $payload = null,
        $dateSigned = null,
        $code = 0,
        \Exception $previous = null
    ) {
        parent::__construct($message, $payload, $code, $previous);

        // If the signature expired this exposes the date of when the
        // signature was created.  This can be helpful in order to
        // tell the user how long a link has been gone stale.
        $this->dateSigned = $dateSigned;
    }

}
