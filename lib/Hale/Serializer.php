<?php
namespace Hale;

use \ReflectionClass;
use \Hale\SimpleJSON;
use \Hale\Signer;

class Serializer
{

    protected $serializer = null;

    protected $signer = null;

    public function __construct(
        $secretKey,
        $salt = null,
        $sep = '.',
        $keyDerivation = null,
        $serializer = null,
        $signer = null
    ) {
        $this->secretKey = $secretKey;
        $this->salt = $salt;
        $this->sep = $sep;
        $this->keyDerivation = $keyDerivation;
        $this->serializer = $serializer;
        $this->signer = $signer;
    }

    public function getSerializer()
    {
        if (!$this->serializer) {
            $this->serializer = new SimpleJSON();
        }
        return $this->serializer;
    }

    public function dumpPayload($obj)
    {
        return $this->getSerializer()->dumps($obj);
    }

    public function loadPayload($payload)
    {
        return $this->getSerializer()->loads($payload);
    }

    public function getSigner()
    {
        if (!$this->signer) {
            $this->signer = new Signer(
                $this->secretKey, $this->salt, $this->sep, $this->keyDerivation
            );
        }
        return $this->signer;
    }

    public function dumps($obj)
    {
        return $this->getSigner()->sign($this->dumpPayload($obj));
    }

    public function loads($json)
    {
        return $this->loadPayload($this->getSigner()->unsign($json));
    }

}
