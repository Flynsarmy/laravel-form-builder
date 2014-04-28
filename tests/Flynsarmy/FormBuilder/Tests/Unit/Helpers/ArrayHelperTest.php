<?php namespace Flynsarmy\FormBuilder\Tests\Unit\Helpers;

use Flynsarmy\FormBuilder\Tests\TestCase;
use Flynsarmy\FormBuilder\Helpers\ArrayHelper;
use Way\Tests\Assert;

class ArrayHelperTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();

		$this->foo = [
			'one' => 'one',
			'two' => 'two',
			'three' => 'three',
			'four' => 'four',
			'five' => 'five',
		];
		$this->bar = [
			'hmm' => 'hmm',
		];
	}

	public function testGetKeyPosition()
	{
		// Searching for key that does not exist
        $actual = ArrayHelper::getKeyPosition($this->foo, 'missing_key');
        $expected = -1;
        Assert::equals($expected, $actual);

        // First key
		$actual = ArrayHelper::getKeyPosition($this->foo, 'one');
        $expected = 0;
        Assert::equals($expected, $actual);

        // Second key
        $actual = ArrayHelper::getKeyPosition($this->foo, 'two');
        $expected = 1;
        Assert::equals($expected, $actual);

        // Fifth key
        $actual = ArrayHelper::getKeyPosition($this->foo, 'five');
        $expected = 4;
        Assert::equals($expected, $actual);
	}

	public function testInsert()
	{
		// Prepend value
		$actual = ArrayHelper::insert($this->foo, $this->bar, 0);
		$expected = [
			'hmm' => 'hmm',
			'one' => 'one',
			'two' => 'two',
			'three' => 'three',
			'four' => 'four',
			'five' => 'five',
		];
		Assert::equals($expected, $actual);

		// Adding after first index
		$actual = ArrayHelper::insert($this->foo, $this->bar, 1);
		$expected = [
			'one' => 'one',
			'hmm' => 'hmm',
			'two' => 'two',
			'three' => 'three',
			'four' => 'four',
			'five' => 'five',
		];
		Assert::equals($expected, $actual);

		// Adding to last index
		$actual = ArrayHelper::insert($this->foo, $this->bar, 999);
		$expected = [
			'one' => 'one',
			'two' => 'two',
			'three' => 'three',
			'four' => 'four',
			'five' => 'five',
			'hmm' => 'hmm',
		];
		Assert::equals($expected, $actual);

		// Adding multiple values
		$actual = ArrayHelper::insert($this->foo, ['hmm' => 'hmm', 'yon' => "yon"], 1);
		$expected = [
			'one' => 'one',
			'hmm' => 'hmm',
			'yon' => "yon",
			'two' => 'two',
			'three' => 'three',
			'four' => 'four',
			'five' => 'five',
		];
		Assert::equals($expected, $actual);
	}
}