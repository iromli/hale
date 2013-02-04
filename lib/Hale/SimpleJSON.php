<?php
namespace Hale;

class SimpleJSON
{

    public function loads($input)
    {
        return json_decode($input, true);
    }

    public function dumps($input)
    {
        return json_encode($input);
    }

}
