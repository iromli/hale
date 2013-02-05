<?php
namespace Hale\Serializer;

use \Hale\Serializer\Serializer;
use \Hale\Signer\TimestampSigner;

class TimedSerializer extends Serializer
{

    public function loads($json, $maxAge = null, $returnTimestamp = false)
    {
        if ($returnTimestamp) {
            list($base64d, $timestamp) = $this->getSigner()->unsign(
                $json, $maxAge, $returnTimestamp
            );
            return array($this->loadPayload($base64d), $timestamp);
        }
        $base64d = $this->getSigner()->unsign($json, $maxAge);
        return $this->loadPayload($base64d);
    }

    public function getSigner()
    {
        if (!$this->signer) {
            $this->signer = new TimestampSigner(
                $this->secretKey, $this->salt, $this->sep, $this->keyDerivation
            );
        }
        return $this->signer;
    }

}
