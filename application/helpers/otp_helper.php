<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('generate_otp')) {
    /**
     * Generate kode OTP numerik.
     * @param int $length
     * @return string
     */
    function generate_otp($length = 6)
    {
        $min = (int) str_pad('1', $length, '0');
        $max = (int) str_pad('9', $length, '9');
        return (string) random_int($min, $max);
    }
}

if (!function_exists('generate_reset_token')) {
    function generate_reset_token()
    {
        return bin2hex(random_bytes(32)); // 64 char token
    }
}
