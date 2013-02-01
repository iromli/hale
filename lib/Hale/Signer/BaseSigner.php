<?php
namespace Hale\Signer;

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
        return \Hale\Util::base64Encode($signature);
    }

}
