<?php namespace Flynsarmy\FormBuilder\Tests\Unit\Traits;

use Flynsarmy\FormBuilder\Tests\TestCase;
use Flynsarmy\FormBuilder\Helpers\ArrayHelper;
use Way\Tests\Assert;

class BindableTest extends TestCase
{
	/**
	 * The object under test.
	 *
	 * @var object
	 */
	private $traitObject;

	/**
	 * Sets up the fixture.
	 *
	 * This method is called before a test is executed.
	 *
	 * @return void
	 */
	public function setUp()
	{
		parent::setUp();

		$this->traitObject = $this->createObjectForTrait();
	}

	/**
	 * *Creation Method* to create an object for the trait under test.
	 *
	 * @return object The newly created object.
	 */
	private function createObjectForTrait()
	{
		$traitName = 'Flynsarmy\FormBuilder\Traits\Bindable';

		return $this->getObjectForTrait($traitName);
	}

	/** @test */
	public function it_can_bind_events()
	{
		$this->traitObject->bind('foo', function() {return true;});

		$actual = !is_null($this->traitObject->getBinding('foo'));
		Assert::true($actual);
	}

	/** @test */
	public function it_can_unbind_events()
	{
		$this->traitObject->bind('foo', function() {return true;});
		$this->traitObject->unbind('foo');

		$actual = $this->traitObject->getBinding('foo');
		Assert::null($actual);
	}

	/** @test */
	public function it_can_be_fired()
	{
		$this->traitObject->foo = 'foo';

		$this->traitObject->bind('change_foo', function($obj) {
			$obj->foo = 'bar';
		});

		$this->traitObject->fire('change_foo', $this->traitObject);

		$expected = 'bar';
		$actual = $this->traitObject->foo;
		Assert::equals($expected, $actual);
	}

	/** @test */
	public function it_can_be_fired_multiple_times()
	{
		$this->traitObject->foo = 0;

		$this->traitObject->bind('increment_foo', function($obj) {
			$obj->foo++;
		});

		$this->traitObject->fire('increment_foo', $this->traitObject);
		$this->traitObject->fire('increment_foo', $this->traitObject);

		$expected = 2;
		$actual = $this->traitObject->foo;
		Assert::equals($expected, $actual);
	}

	/** @test */
	public function bindings_can_accept_multiple_arguments()
	{
		$this->traitObject->bind('multiple_arguments', function($obj, $arg2) {
			$obj->foo = $arg2;
		});

		$this->traitObject->fire('multiple_arguments', $this->traitObject, 'bar');

		$expected = 'bar';
		$actual = $this->traitObject->foo;
		Assert::equals($expected, $actual);
	}

	/** @test */
	public function bindings_can_be_overridden()
	{
		$this->traitObject->foo = 0;

		$this->traitObject->bind('set_foo_to_one', function($obj) {
			$obj->foo = 1;
		});
		$this->traitObject->bind('set_foo_to_one', function($obj) {
			$obj->foo = 2;
		});

		$this->traitObject->fire('set_foo_to_one', $this->traitObject);

		$expected = 2;
		$actual = $this->traitObject->foo;
		Assert::equals($expected, $actual);
	}
}