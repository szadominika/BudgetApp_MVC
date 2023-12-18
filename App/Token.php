<?php

namespace App;

/**
 * Unique random tokens
 */
class Token {

    /**
     * the token value
     * @var array
     */
    protected $token;

    /**
     * class constructor. create a new random token.
     * 
     * @param string $value (optional) a token value
     * @return void
     */
    public function __construct($token_value = null){

        if ($token_value) {
            $this->token = $token_value;
        } else {

             $this->token = bin2hex(random_bytes(16)); //16bytes = 128bits = 32hex characters
        }
    }

    /**
     * get the token value
     * @return string
     */
    public function getValue() {

        return $this->token;
    }

    /**
     * get the hashed token
     * 
     * @return string The hashed value
     */
    public function getHash() {

        return hash_hmac('sha256', $this->token, \App\Config::SECRET_KEY); //sha256 = 64 chars
    }



}