<?php namespace Xethron;

use Mockery;
use PHPUnit_Framework_TestCase;

class ExtendedArrayTest extends PHPUnit_Framework_TestCase {

	protected function setUp()
	{
		$this->array = new ExtendedArray(array(
				'foo' => array(
					'one' => 1,
					'string' => 'Hello World',
					'empty' => '',
					'null' => null,
					'emptyArray' => array(),
					'array' => array(1,2,3),
				),
				'bar' => 'foo',
				'empty' => '',
				'null' => null,
			));
	}

	/**
	 * @test
	 */
	public function has_single_key()
	{
		$this->assertEquals($this->array->has('foo'), true);
		$this->assertEquals($this->array->has('bar'), true);
		$this->assertEquals($this->array->has('null'), false);
		$this->assertEquals($this->array->has('empty'), false);
		$this->assertEquals($this->array->has('foobar'), false);

		$this->assertEquals(isset($this->array->foo), true);
		$this->assertEquals(isset($this->array->foobar), false);
		$this->assertEquals(isset($this->array['foo']), true);
		$this->assertEquals(isset($this->array['foobar']), false);
	}

	/**
	 * @test
	 */
	public function has_single_nested_key()
	{
		$this->assertEquals($this->array->has('foo.one'), true);

		$this->assertEquals($this->array->has('foo.bar'), false);
	}

	/**
	 * @test
	 */
	public function get_single_key()
	{
		$this->assertEquals($this->array->get('bar'), 'foo');
		$this->assertEquals($this->array->get('empty'), '');
		$this->assertEquals($this->array->get('random'), null);
		$this->assertEquals($this->array->get('random', 'val'), 'val');

		$this->assertEquals($this->array->bar, 'foo');
		$this->assertEquals($this->array->foobar, null);

		$this->assertEquals($this->array['bar'], 'foo');
		$this->assertEquals($this->array['foobar'], null);

	}

	/**
	 * @test
	 */
	public function get_single_nested_key()
	{
		$this->assertEquals($this->array->get('foo.one'), 1);

		$this->assertEquals($this->array->get('foo.string'), 'Hello World');

		$this->assertEquals($this->array->get('foo.random'), null);
		$this->assertEquals($this->array->get('foo.random', 'val'), 'val');
	}

	/**
	 * @test
	 */
	public function get_array()
	{
		$result = $this->array->getArray();
		$this->assertEquals(is_array($result), true);
	}
}
