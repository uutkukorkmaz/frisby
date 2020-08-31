<?php
declare(strict_types=1);


namespace FrisbyModule\Frisby;


/**
 * Frisby Framework
 * Authorization Class
 *
 * This class helps the authorize last user without extra code
 *
 * @author Utku Korkmaz
 * @package FrisbyModule\Frisby
 */
class Authorization
{
	/**
	 * Contains the encryption key
	 * @var string
	*/
	private static $key = '<your-crypto-key>';

	/**
	 * Contains encryption method
	 * @var string
	*/
	private static $method = "AES-128-ECB";

	/**
	 * Creates a random pseudo bytes and converts it to string
	 * @param int $lenght
	 * @return bool|string
	 */
	public static function createToken($lenght = 64)
	{
		$token = bin2hex(openssl_random_pseudo_bytes($lenght, $strength));
		return $strength ? $token : false;
	}

	/**
	 * Decrypts the hashed string
	 * @param $encrypted
	 * @return false|string
	 */
	public static function decrypt($encrypted)
	{
		return openssl_decrypt($encrypted, self::$method, self::getKey());
	}

	/**
	 * Getter method for encryption key
	 * @return string
	 */
	private static function getKey()
	{
		return md5(self::$key);
	}

	/**
	 * Verifies the plain string with given hashed string
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
	 * Encrypts the plain string
	 * @param $str
	 * @return false|string
	 */
	public static function encrypt($str)
	{
		return openssl_encrypt($str, self::$method, self::getKey());
	}

}