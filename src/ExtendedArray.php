<?php namespace Xethron;

/**
 * Extended Array Class to give arrays additional functionality
 */
class ExtendedArray implements \ArrayAccess {

	/**
	 * Array containing the data
	 *
	 * @var array
	 * @access private
	 */
	protected $array;

	/**
	 * Optionally construct the class with an array
	 *
	 * @param array $array
	 */
	public function __construct(array $array = array())
	{
		$this->array = $array;
	}

	/**
	 * Set a element on the array
	 *
	 * @param string $key
	 * @param mixed  $value
	 */
	public function set($key, $value)
	{
		if (is_null($key)) {
			$this->array[] = $value;
		} else {
			$this->array[$key] = $value;
		}
	}

	/**
	 * Check if the given key exists.
	 *
	 * @param  string|array  $key
	 * @return bool
	 */
	public function exists($key)
	{
		$keys = is_array($key) ? $key : func_get_args();

		$array = $this->array;

		foreach ($keys as $value)
		{
			if ( ! array_key_exists($value, $array)) return false;
		}

		return true;
	}

	/**
	 * Check if the given key contains a non-empty value.
	 *
	 * @param string $key
	 * @return bool
	 */
	public function has($key)
	{
		$keys = is_array($key) ? $key : func_get_args();

		foreach ($keys as $key)
		{
			if ($this->exists($key)) {
				if ($this->isEmptyString($this->array[$key]))
					return false;
				else
					continue;
			}

			$array = $this->array;

			foreach (explode('.', $key) as $segment)
			{
				if ( ! is_array($array) || ! array_key_exists($segment, $array))
				{
					return false;
				}

				$array = $array[$segment];
			}

			if ($this->isEmptyString($array)) return false;
		}

		return true;
	}

	/**
	 * Check if the given key is an empty string.
	 *
	 * @param  string  $value
	 *
	 * @return bool
	 */
	protected function isEmptyString($value)
	{
		$boolOrArray = is_bool($value) || is_array($value);

		return ! $boolOrArray && trim((string) $value) === '';
	}

	/**
	 * Get the value of a specific element if exists or return the default
	 *
	 * @param string $key
	 * @param mixed  $default
	 * @return mixed
	 */
	public function get($key, $default = null)
	{
		if (empty($key)) return $this->array;

		if ($this->exists($key)) return $this->array[$key];

		$result = $this->array;

		foreach (explode('.', $key) as $segment)
		{
			if ( ! is_array($result) || ! array_key_exists($segment, $result))
			{
				return $default;
			}

			$result = $result[$segment];
		}

		return $result;
	}

	/**
	 * Get the actual array
	 *
	 * @return array
	 */
	public function getArray()
	{
		return $this->array;
	}

	/**
	 * Forget/unset an element
	 *
	 * @param $key
	 */
	public function forget($key)
	{
		unset($this->array[$key]);
	}

	/**
	 * Check if array contains at least one of the given elements
	 *
	 * @param array|string $key
	 * @return bool
	 */
	public function hasOne($key)
	{
		$keys = is_array($key) ? $key : func_get_args();

		foreach ($keys as $key)
		{
			if ($this->has($key)) return true;
		}

		return false;
	}

	/**
	 * Add an element to an array if it doesn't exist.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 */
	function add($key, $value)
	{
		if (!$this->has($key)) $this->array[$key] = $value;
	}

	/**
	 * Divide an array into two arrays. One with keys and the other with values.
	 *
	 * @return array(keys, values)
	 */
	function divide()
	{
		return array(array_keys($this->array), array_values($this->array));
	}

	/***** Duplicate functions to access array as object *****/

	/**
	 * Get a specific element
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function __get($key) {
		return $this->get($key);
	}

	/**
	 * Set a specific element
	 *
	 * @param string $key
	 * @param mixed  $value
	 */
	public function __set($key, $value) {
		$this->set($key, $value);
	}

	/**
	 * Check if an element exists
	 *
	 * @param string $key
	 * @return boolean
	 */
	public function __isset($key) {
		return $this->exists($key);
	}

	/**
	 * Forget/unset an element
	 *
	 * @param string $key
	 */
	public function __unset($key) {
		$this->forget($key);
	}

	/***** Duplicate functions to access array as Array *****/

	/**
	 * Set a specific element
	 *
	 * @param string $key
	 * @param mixed  $value
	 * @abstracting  ArrayAccess
	 */
	public function offsetSet($key, $value) {
		$this->set($key, $value);
	}

	/**
	 * Check if an element exists
	 *
	 * @param string $key
	 * @return boolean
	 * @abstracting  ArrayAccess
	 */
	public function offsetExists($key) {
		return $this->exists($key);
	}

	/**
	 * Forget/unset an element
	 *
	 * @param string $key
	 * @abstracting  ArrayAccess
	 */
	public function offsetUnset($key) {
		$this->forget($key);
	}

	/**
	 * Get the value of a specific element if exists or return null
	 *
	 * @param string $key
	 * @return mixed
	 * @abstracting  ArrayAccess
	 */
	public function offsetGet($key) {
		return $this->get($key);
	}
}
