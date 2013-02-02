<?php
namespace Hale;

use \Exception;

/**
 * This error is raised if a signature does not match.
 */
class BadSignatureException extends Exception
{

    public function __construct(
        $message,
        $payload = null,
        $code = 0,
        \Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        // The payload that failed the signature test.
        // In some situations you might still want to inspect this, even if
        // you know it was tampered with.
        $this->payload = $payload;
    }

}
