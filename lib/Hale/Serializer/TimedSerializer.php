<?php
namespace Hale\Serializer;

use \Hale\Serializer\Serializer;
use \Hale\Signer\TimestampSigner;

class TimedSerializer extends Serializer
{

    public function loads($json, $maxAge = null, $returnTimestamp = false)
    {
        list($base64d, $timestamp) = $this->getSigner()->unsign($json, $maxAge, $returnTimestamp);
        $payload = $this->loadPayload($base64d);
        if ($returnTimestamp) {
            return array($payload, $timestamp);
        }
        return $payload;
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



