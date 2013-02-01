<?php
namespace Hale\Signer;

use \Hale\Exception\BadSignatureException;
use \Hale\Util;

class BaseSigner
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
                throw new \InvalidArgumentException('Unknown key derivation method');
        }
    }

    public function getSignature($value)
    {
        $key = $this->deriveKey();
        $signature = hash_hmac('sha1', $value, $key, true);
        return Util::base64Encode($signature);
    }

}
