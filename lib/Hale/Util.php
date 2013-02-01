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

    /**
     * Compares two strings.
     *
     * This method implements a constant-time algorithm to compare
     * strings to avoid (remote) timing attacks.
     *
     * @param string value1 The first string
     * @param string value2 The second string
     *
     * @return boolean True if 2 values are the same, otherwise false
     */
    public static function constantTimeCompare($value1, $value2)
    {
        if (strlen($value1) !== strlen($value2)) {
            return false;
        }

        $result = 0;
        for ($i = 0; $i < strlen($value1); $i++) {
            $result |= ord($value1[$i]) ^ ord($value2[$i]);
        }
        return $result === 0;
    }

}
