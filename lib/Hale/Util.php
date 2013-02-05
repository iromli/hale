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

    public static function intToBytes($num)
    {
        $output = "";
        while($num > 0) {
            $output .= chr($num & 0xff);
            $num >>= 8;
        }
        return strrev($output);
    }

    public static function bytesToInt($bytes) {
        $output = 0;
        foreach (str_split($bytes) as $byte) {
            if ($output > 0) {
                $output <<= 8;
            }
            $output += ord($byte);
        }
        return $output;
    }

    public static function urlsafeLoad($payload)
    {
        $decompress = false;
        if ($payload[0] == '.') {
            $payload = substr($payload, 1);
            $decompress = true;
        }
        $json = self::base64Decode($payload);
        if ($decompress) {
            $json = gzuncompress($json);
        }
        return $json;
    }

    public static function urlsafeDump($json)
    {
        $is_compressed = false;
        $compressed = gzcompress($json);
        if (strlen($compressed) < strlen($json) - 1) {
            $json = $compressed;
            $is_compressed = true;
        }
        $base64d = self::base64Encode($json);
        if ($is_compressed) {
            $base64d = '.' . $base64d;
        }
        return $base64d;
    }

}
