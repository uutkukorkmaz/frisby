<?php


namespace Frisby\Service;


class Cryption
{
	public string $lastToken;

	private static ?string $key = null;

	private static ?string $method = null;

	public function createToken(int $length = 32):string
	{
		$this->lastToken = bin2hex(openssl_random_pseudo_bytes($length,$isStrong));
		return $isStrong ? $this->lastToken : false;
	}

	public function getEncryptionKey(){
		return is_null(self::$key) ? md5('FrisbyEncryption') : self::$key;
	}

	public function setEncryptionKey($value){
		self::$key = md5($value);
	}

	public function setMethod($encryptionMethod){
		self::$method = $encryptionMethod;
	}

	public function getMethod(){
		return is_null(self::$method) ? 'AES-128-ECB' : self::$method;
	}

	public function encrypt(string $data){
		return openssl_encrypt($data,$this->getMethod(),$this->getEncryptionKey());
	}

	public function decrypt(string $data){
		return openssl_decrypt($data,$this->getMethod(),$this->getEncryptionKey());
	}



}