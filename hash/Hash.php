<?php
class Hash {
    private $_key;  // 密钥

    public function __construct($key) {
        $this->_key = $key;
    }

    public function hmac($str, $algo = 'sha256') {
        return hash_hmac($algo, $str, $this->_key);
    }
}
