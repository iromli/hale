<?php
namespace Hale\Signer;

use \Exception;
use \Hale\Signer\Signer;
use \Hale\Util;
use \Hale\Exception\BadSignatureException;
use \Hale\Exception\BadTimeSignatureException;
use \Hale\Exception\SignatureExpiredException;

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
class TimestampSigner extends Signer
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

    /**
     * Signs the given string and also attaches a time information.
     *
     * @param string $value Plain string
     * @return string Signed string
     */
    public function sign($value)
    {
        $timestamp = Util::base64Encode(Util::intToBytes(
            $this->getTimestamp()
        ));
        $value = $value . $this->sep . $timestamp;
        return $value . $this->sep . $this->getSignature($value);
    }

    /**
     * Works like the regular `Signer::unsign` but can also validate the time.
     * See the base docstring of the class for the general behavior.
     * If `$returnTimestamp` is set to `true` the timestamp of the signature
     * will be returned as naive `DateTime` object in UTC.
     *
     * @param string $signedValue
     * @param integer $maxAge Maximum age in second
     * @param boolean $returnTimestamp
     * @return array|string Returns array if $returnTimestamp set to true, otherwise a string
     */
    public function unsign(
        $signedValue,
        $maxAge = null,
        $returnTimestamp = False
    ) {
        try {
            $sigError = null;
            $result = parent::unsign($signedValue);
        } catch (BadSignatureException $e) {
            $sigError = $e;
            $result = $e->payload;
        }

        // If there is no timestamp in the result there is something seriously wrong.
        // In case there was a signature error, we raise that one directly,
        // otherwise we have a weird situation in which we shouldn't have come
        // except someone uses a time-based serializer on non-timestamp data, so catch that.
        if (strpos($result, $this->sep) === false) {
            if ($sigError) {
                throw $sigError;
            }
            throw new BadTimeSignatureException('Timestamp missing', $result);
        }

        $exploded = explode($this->sep, $result);
        $timestamp = array_pop($exploded);
        $value = implode($this->sep, $exploded);

        try {
            $timestamp = Util::bytesToInt(Util::base64Decode($timestamp));
        } catch (Exception $e) {
            $timestamp = null;
        }

        // Signature is *not* okay.
        // Raise a proper error now that we have split the value and the timestamp.
        if (!is_null($sigError)) {
            throw new BadTimeSignatureException($sigError, $value, $timestamp);
        }

        // Signature was okay but the timestamp is actually not there or malformed.
        // Should not happen, but well. We handle it nonetheless.
        if (!$timestamp) {
            throw new BadTimeSignatureException('Malformed timestamp', $value);
        }

        // Check `$timestamp` is not older than `$maxAge`.
        if ($maxAge) {
            $age = $this->getTimestamp() - $timestamp;
            if ($age > $maxAge) {
                throw new SignatureExpiredException(
                    sprintf('Signature age %s > %s seconds', $age, $maxAge),
                    $value,
                    $this->timestampToDatetime($timestamp)
                );
            }
        }

        if ($returnTimestamp) {
            return array($value, $this->timestampToDatetime($timestamp));
        }
        return $value;
    }

}
