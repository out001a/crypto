package main

import (
	"bytes"
	"crypto/aes"
	"crypto/cipher"
	"encoding/base64"
	"log"
)

func main() {
	key := []byte("d959caadac9b13dcb3e609440135cf54")
	iv := []byte("1234567812345678")

	content := "hello world!"

	c, _ := Encrypt([]byte(content), key, iv)
	b, _ := Decrypt(c, key, iv)
	p := string(b)

	log.Println("加密后的内容：", c)
	log.Println("解密后的内容：", p)
}

func Encrypt(plainText, key, iv []byte) (string, error) {
	block, err := aes.NewCipher(key)
	//log.Println("blockSize == ", block.BlockSize())
	if err != nil {
		return "", err
	}
	plainText = PKCS7Padding(plainText, block.BlockSize())
	cipherText := make([]byte, len(plainText))
	cipher.NewCBCEncrypter(block, iv).CryptBlocks(cipherText, plainText)
	return base64.StdEncoding.EncodeToString(cipherText), nil
}

func Decrypt(cipherText string, key, iv []byte) ([]byte, error) {
	block, err := aes.NewCipher(key)
	if err != nil {
		return nil, err
	}
	cipherBytes, _ := base64.StdEncoding.DecodeString(cipherText)
	plainText := make([]byte, len(cipherBytes))
	cipher.NewCBCDecrypter(block, iv).CryptBlocks(plainText, cipherBytes)
	plainText = PKCS7Unpadding(plainText, block.BlockSize())
	return plainText, nil
}

func PKCS7Padding(text []byte, blockSize int) []byte {
	padding := blockSize - len(text)%blockSize
	padText := bytes.Repeat([]byte{byte(padding)}, padding)
	return append(text, padText...)
}

func PKCS7Unpadding(text []byte, blockSize int) []byte {
	length := len(text)
	unpadding := int(text[length-1])
	return text[:(length - unpadding)]
}
