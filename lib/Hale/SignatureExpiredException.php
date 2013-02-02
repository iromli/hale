<?php
namespace Hale\Exception;

use \Hale\BadTimeSignatureException;

/**
 * Signature timestamp is older than required `maxAge`.
 */
class SignatureExpiredException extends BadTimeSignatureException {}