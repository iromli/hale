<?php
namespace Hale\Serializer;

use Hale\Serializer\TimedSerializer;
use Hale\Util;

class URLSafeTimedSerializer extends TimedSerializer
{

    public function loadPayload($payload)
    {
        return parent::loadPayload(Util::urlsafeLoad($payload));
    }

    public function dumpPayload($obj)
    {
        return Util::urlsafeDump(parent::dumpPayload($obj));
    }

}
