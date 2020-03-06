<?php


namespace FrisbyModule\Frisby;


/**
 * Class Authorization
 * @package FrisbyModule\Frisby
 */
class Authorization
{

	private static $key = '<your-crypto-key>';
	private static $method = "AES-128-ECB";

	/**
	 * @param int $lenght
	 * @return bool|string
	 */
	public static function createToken($lenght = 64)
	{
		$token = bin2hex(openssl_random_pseudo_bytes($lenght, $strength));
		return $strength ? $token : false;
	}

	/**
	 * @param $encrypted
	 * @return false|string
	 */
	public static function decrypt($encrypted)
	{
		return openssl_decrypt($encrypted, self::$method, self::getKey());
	}

	/**
	 * @return string
	 */
	private static function getKey()
	{
		return md5(self::$key);
	}

	/**
	 * @param $password
	 * @param $hash
	 * @param string $hash_function
	 * @return bool
	 */
	public static function verifyPassword($password, $hash, $hash_function = 'self')
	{
		if ($hash_function == 'self') {
			return self::encrypt($password) == $hash;
		} else {
			return $hash_function($password) == $hash;
		}
	}

	/**
	 * @param $str
	 * @return false|string
	 */
	public static function encrypt($str)
	{
		return openssl_encrypt($str, self::$method, self::getKey());
	}

}