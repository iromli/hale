<?php
namespace Hale\Signer;

use \Hale\Signer\BaseSigner;
use \Hale\Util;

// 2011/01/01 in UTC
define('EPOCH', 1293840000);

 /**
  * Works like the regular `Hale\Signer\BaseSigner` but also records the time
  * of the signing and can be used to expire signatures.
  *
  * The unsign method can raise a `Hale\Exception\SignatureExpiredException`
  * if the unsigning failed because the signature is expired.
  * This exception is a subclass of `Hale\Exception\BadTimeSignatureException`.
  */
class TimestampSigner extends BaseSigner
{

    /**
     * Returns the current timestamp.
     *
     * This implementation returns the seconds since 1/1/2011.
     * The function must return an integer.
     *
     * @return integer
     */
    public function getTimestamp()
    {
        return time() - EPOCH;
    }

    /**
     * Used to convert the timestamp from `getTimestamp` into a DateTime object
     *
     * @param integer Unix timestamp
     * @return object DateTime object
     */
    public function timestampToDatetime($ts)
    {
        // Passing UNIX timestamp format (`@12345`) as first argument makes
        // the timezone use offset instead of its name.
        // Omitting the timezone will raise error.
        //
        // As a test, we can use `$datetime->getTimezone()->getName()`.
        // Unfortunately it will return `+00:00` instead of `UTC`.
        $datetime = new \DateTime(
            sprintf('@%s', $ts + EPOCH),
            new \DateTimeZone('UTC')
        );

        // Set new timezone as the one that created at DateTime construct
        // simply ignores the timezone name.
        $datetime->setTimezone(new \DateTimeZone('UTC'));
        return $datetime;
    }

    public function sign($value)
    {
        $timestamp = Util::base64Encode(Util::intToBytes(
            $this->getTimestamp()
        ));
        $value = $value . $this->sep . $timestamp;
        return $value . $this->sep . $this->getSignature($value);
    }

}
