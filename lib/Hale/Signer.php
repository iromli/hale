<?php
namespace Hale;

use \InvalidArgumentException;
use \Hale\BadSignatureException;
use \Hale\Util;

class Signer
{

    public function __construct(
        $secretKey,
        $salt = null,
        $sep = '.',
        $keyDerivation = null
    ) {
        $this->secretKey = $secretKey;
        $this->salt = $salt ?: 'Hale.Signer';
        $this->sep = $sep;
        $this->keyDerivation = $keyDerivation ?: 'default';
    }

    public function sign($value)
    {
        return $value . $this->sep . $this->getSignature($value);
    }

    /**
     * Unsigns the given string.
     *
     * @param string $signedValue
     * @return string
     */
    public function unsign($signedValue)
    {
        if (strpos($signedValue, $this->sep) === false) {
            throw new BadSignatureException(
                sprintf('No "%s" found in value', $this->sep)
            );
        }

        list($value, $sig) = explode($this->sep, $signedValue);

        if (Util::constantTimeCompare($sig, $this->getSignature($value))) {
            return $value;
        }

        throw new BadSignatureException(
            sprintf('Signature "%s" does not match', $sig)
        );
    }

    /**
     * This method is called to derive the key.
     * If you're unhappy with the default key derivation choices you can override them here.
     * Keep in mind that the key derivation in itsdangerous is not intended to be used
     * as a security method to make a complex key out of a short password.
     * Instead you should use large random secret keys.
     */
    public function deriveKey()
    {
        switch ($this->keyDerivation) {
            case 'default':
                return sha1($this->salt . 'signer' . $this->secretKey, true);
            case 'concat':
                return sha1($this->salt . $this->secretKey, true);
            case 'hmac':
                return hash_hmac('sha1', $this->salt, $this->secretKey, true);
            default:
                throw new InvalidArgumentException('Unknown key derivation method');
        }
    }

    /**
     * Returns the signature for the given value.
     *
     * @param string $value
     * @return string Base64-encoded string
     */
    public function getSignature($value)
    {
        $key = $this->deriveKey();
        $signature = hash_hmac('sha1', $value, $key, true);
        return Util::base64Encode($signature);
    }

    /**
     * Just validates the given signed value.
     *
     * @param string $signedValue
     * @return boolean Returns `true` if the signature exists and is valid, `false` otherwise.
     */
    public function validate($signedValue)
    {
        try {
            $this->unsign($signedValue);
            return true;
        } catch (BadSignatureException $e) {
            return false;
        }
    }

}
