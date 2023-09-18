<?php

namespace App\Controllers;

use App\Controllers\BaseController;


class SimpleEncryption
{
    private $key;
    private $cipher;

    public function __construct($key, $cipher = 'aes-256-cbc')
    {
        // Ensure the key is of the correct size
        $this->key = hash('sha256', $key, true);
        $this->cipher = $cipher;
    }

    public function encrypt($plaintext)
    {
        $ivlen = openssl_cipher_iv_length($this->cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);

        $ciphertext_raw = openssl_encrypt($plaintext, $this->cipher, $this->key, $options=OPENSSL_RAW_DATA, $iv);

        $hmac = hash_hmac('sha256', $ciphertext_raw, $this->key, $as_binary=true);

        return base64_encode($iv.$hmac.$ciphertext_raw);
    }

    public function decrypt($ciphertext)
    {
        $c = base64_decode($ciphertext);

        $ivlen = openssl_cipher_iv_length($this->cipher);
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len=32);
        $ciphertext_raw = substr($c, $ivlen+$sha2len);

        $plaintext = openssl_decrypt($ciphertext_raw, $this->cipher, $this->key, $options=OPENSSL_RAW_DATA, $iv);

        $calcmac = hash_hmac('sha256', $ciphertext_raw, $this->key, $as_binary=true);

        if (hash_equals($hmac, $calcmac)) {
            return $plaintext;
        }

        return null; // HMAC verification failed
    }
}

