<?php
namespace Hale\Hash;

class SHA1
{

    public $name = 'sha1';

    public function digest($str)
    {
        return sha1($str, true);
    }

}
