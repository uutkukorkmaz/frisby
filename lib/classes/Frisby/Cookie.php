<?php


namespace FrisbyModule\Frisby;

/**
 * Cookie Manager API
 *
 * This is a simple and light cookie manager class
 *
 * @link http://php.net/manual/en/function.setcookie.php
 *
 * @link www.overclokk,net
 * @since 1.0.0
 *
 * @version 1.0.1
 *
 * @package Overclokk\Cookie
 */


/**
 * Cookie API
 */
class Cookie implements CookieInterface
{

	/**
	 * $_COOKIE global variable
	 *
	 * @var array
	 */
	private $cookie = [];

	public $cookiePrefix = 'FRISBY__';

	/**
	 * Init class
	 *
	 * @param array $cookie $_COOKIE global variable.
	 */
	public function __construct(array $cookie = [])
	{
		$this->cookie = empty($cookie) ? $_COOKIE : $cookie;
	}

	/**
	 * @param $name
	 * @return bool
	 */
	public function exists($name)
	{
		return isset($this->cookie[$this->cookiePrefix . $name]);
	}

	/**
	 * Get the value of a cookie
	 *
	 * @param string $name The cookie name.
	 *
	 * @return null|string Return the cookie value
	 */
	public function get($name)
	{

		if (!isset($this->cookie[$this->cookiePrefix . $name])) { // Input var okay.
			return null;
		}

		return strip_tags(stripslashes($this->cookie[$this->cookiePrefix . $name])); // Input var okay.
	}

	/**
	 * Store a cookie for a long, long time.
	 *
	 * @author https://github.com/codezero-be
	 *
	 * @param string $name The cookie name.
	 * @param string $value The cookie value.
	 *
	 * @param int $expire
	 * @return bool         If output exists prior to calling this function, setcookie()
	 *                      will fail and return FALSE. If setcookie() successfully runs,
	 *                      it will return TRUE. This does not indicate whether the
	 *                      user accepted the cookie.
	 */
	public function forever($name, $value, $expire = 0)
	{

		if (0 === $expire) {
			$expire = 31536000 * 5;
		}

		return $this->set($name, $value, $expire);
	}

	/**
	 * Set cookie
	 *
	 * @param string $name The cookie name.
	 * @param string $value The cookie value.
	 * @param int $expire Expiration time in seconds.
	 * @param string $path The path on the server in which the cookie will be available on.
	 *                         If set to '/', the cookie will be available within the
	 *                         entire domain. If set to '/foo/', the cookie will only be
	 *                         available within the /foo/ directory and all sub-directories
	 *                         such as /foo/bar/ of domain. The default value is the current
	 *                         directory that the cookie is being set in.
	 * @param string $domain The (sub)domain that the cookie is available to.
	 * @param bool $secure Indicates that the cookie should only be transmitted over
	 *                         a secure HTTPS connection from the client.
	 * @param bool $httponly When TRUE the cookie will be made accessible only through
	 *                         the HTTP protocol.
	 *
	 * @return bool            If output exists prior to calling this function, setcookie()
	 *                         will fail and return FALSE. If setcookie() successfully runs,
	 *                         it will return TRUE. This does not indicate whether the
	 *                         user accepted the cookie.
	 */
	public function set($name, $value, $expire = 0, $path = '/', $domain = null, $secure = false, $httponly = false)
	{

		return setcookie(
			$this->cookiePrefix . $name,
			$value,
			$this->calculate_expiration_time($expire),
			$path,
			$domain,
			$secure,
			$httponly
		);
	}

	/**
	 * Calculate the expiration time
	 *
	 * @author https://github.com/codezero-be
	 *
	 * @param int $expire The expiration time
	 *
	 * @return int
	 */
	private function calculate_expiration_time($expire = 0)
	{
		return intval($expire > 0 ? time() + $expire : -1);
	}

	/**
	 * Delete a cookie
	 *
	 * @param string $name Cookie name.
	 *
	 * @param null $path
	 * @return bool        @see Class::set();
	 */
	public function delete($name, $path = '/')
	{
		unset($this->cookie[$this->cookiePrefix . $name]); // Input var okay.
		return $this->set($name, '', time() - 15 * 60, $path);
	}
}
