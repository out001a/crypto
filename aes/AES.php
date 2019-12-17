<?php
if (get_included_files()[0] == __FILE__) {
    $content = 'hello world!';
    $aes = new AES('d959caadac9b13dcb3e609440135cf54', '1234567812345678');
    $enc = $aes->encrypt($content);
    $dec = $aes->decrypt($enc);
    echo "加密后的内容：{$enc}\n";
    echo "解密后的内容：{$dec}\n";
}

class AES {
    private $_sc;    // 密钥
    private $_iv;    // 初始向量
    private $_method  = 'aes-256-cbc';
    private $_options = OPENSSL_RAW_DATA;

    public function __construct($sc, $iv) {
        $iv = $iv ? $iv : '0000000000000000';
        $this->_sc = $sc;
        $this->_iv = $iv;
    }

    public function encrypt($plain) {
        return base64_encode(openssl_encrypt($plain, $this->_method, $this->_sc, $this->_options, $this->_iv));
    }

    public function decrypt($cipher) {
        return openssl_decrypt(base64_decode($cipher), $this->_method, $this->_sc, $this->_options, $this->_iv);
    }
}