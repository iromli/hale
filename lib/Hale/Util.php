<?php
namespace Hale;

/**
 * Helper class.
 *
 */
class Util
{

    /**
     * Encodes a string to make it a URL-safe string.
     *
     * @param string Plain string
     * @return string Encoded string
     */
    public static function base64Encode($str)
    {
        return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
    }

    /**
     * Decodes a URL-safe string.
     *
     * @param string Decoded string
     * @return string Plain string
     */
    public static function base64Decode($str)
    {
        return base64_decode(str_pad(
            strtr($str, '-_', '+/'),
            strlen($str) % 4,
            '=',
            STR_PAD_RIGHT
        ));
    }

}
