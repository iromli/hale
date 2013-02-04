<?php
namespace Hale\Serializer;

use Hale\Serializer\Serializer;
use Hale\Util;

class URLSafeSerializer extends Serializer
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
