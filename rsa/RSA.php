<?php
if (get_included_files()[0] == __FILE__) {
    $content = 'hello world!';
    $pub_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC3//sR2tXw0wrC2DySx8vNGlqt
3Y7ldU9+LBLI6e1KS5lfc5jlTGF7KBTSkCHBM3ouEHWqp1ZJ85iJe59aF5gIB2kl
Bd6h4wrbbHA2XE1sq21ykja/Gqx7/IRia3zQfxGv/qEkyGOx+XALVoOlZqDwh76o
2n1vP1D+tD3amHsK7QIDAQAB
-----END PUBLIC KEY-----';
    $pri_key = '-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQC3//sR2tXw0wrC2DySx8vNGlqt3Y7ldU9+LBLI6e1KS5lfc5jl
TGF7KBTSkCHBM3ouEHWqp1ZJ85iJe59aF5gIB2klBd6h4wrbbHA2XE1sq21ykja/
Gqx7/IRia3zQfxGv/qEkyGOx+XALVoOlZqDwh76o2n1vP1D+tD3amHsK7QIDAQAB
AoGBAKH14bMitESqD4PYwODWmy7rrrvyFPEnJJTECLjvKB7IkrVxVDkp1XiJnGKH
2h5syHQ5qslPSGYJ1M/XkDnGINwaLVHVD3BoKKgKg1bZn7ao5pXT+herqxaVwWs6
ga63yVSIC8jcODxiuvxJnUMQRLaqoF6aUb/2VWc2T5MDmxLhAkEA3pwGpvXgLiWL
3h7QLYZLrLrbFRuRN4CYl4UYaAKokkAvZly04Glle8ycgOc2DzL4eiL4l/+x/gaq
deJU/cHLRQJBANOZY0mEoVkwhU4bScSdnfM6usQowYBEwHYYh/OTv1a3SqcCE1f+
qbAclCqeNiHajCcDmgYJ53LfIgyv0wCS54kCQAXaPkaHclRkQlAdqUV5IWYyJ25f
oiq+Y8SgCCs73qixrU1YpJy9yKA/meG9smsl4Oh9IOIGI+zUygh9YdSmEq0CQQC2
4G3IP2G3lNDRdZIm5NZ7PfnmyRabxk/UgVUWdk47IwTZHFkdhxKfC8QepUhBsAHL
QjifGXY4eJKUBm3FpDGJAkAFwUxYssiJjvrHwnHFbg0rFkvvY63OSmnRxiL4X6EY
yI9lblCsyfpl25l7l5zmJrAHn45zAiOoBrWqpM5edu7c
-----END RSA PRIVATE KEY-----';
    $rsa = new RSA($pub_key, $pri_key);
    $enc = $rsa->publicEncrypt($content);
    $dec = $rsa->privateDecrypt($enc);
    echo "加密后的内容：{$enc}\n";
    echo "解密后的内容：{$dec}\n";
}

class RSA {
    private $_pubKey;   // 公钥
    private $_priKey;   // 私钥

    public function __construct($pub_key, $pri_key) {
        $this->_pubKey = $pub_key;
        $this->_priKey = $pri_key;
    }

    /**
     * 公钥加密
     * @param $data
     * @return bool|string
     */
    public function publicEncrypt($data) {
        if (openssl_public_encrypt($data, $encrypted, $this->_pubKey)) {
            return base64_encode($encrypted);
        }
        return false;
    }

    /**
     * 私钥解密
     * @param $data
     * @return bool
     */
    public function privateDecrypt($data) {
        if (openssl_private_decrypt(base64_decode($data), $decrypted, $this->_priKey)) {
            return $decrypted;
        }
        return false;
    }

    /**
     * 私钥加密
     * @param $data
     * @return bool|string
     */
    public function privateEncrypt($data) {
        if (openssl_private_encrypt ($data, $encrypted, $this->_priKey)) {
            return base64_encode($encrypted);
        }
        return false;
    }
}
