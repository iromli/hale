<?php
namespace Hale\Exception;

use \Hale\Exception\BadTimeSignatureException;

/**
 * Signature timestamp is older than required `maxAge`.
 */
class SignatureExpiredException extends BadTimeSignatureException {}
