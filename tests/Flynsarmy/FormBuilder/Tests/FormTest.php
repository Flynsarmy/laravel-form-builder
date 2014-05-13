<?php namespace Flynsarmy\FormBuilder\Tests\Unit;

use Flynsarmy\FormBuilder\Tests\TestCase;
use Flynsarmy\FormBuilder\Form;
use Way\Tests\Assert;

/*
 * Testing private attributes: http://sebastian-bergmann.de/archives/881-Testing-Your-Privates.html
 * Testing private methods/attributes http://aaronsaray.com/blog/2011/08/16/testing-protected-and-private-attributes-and-methods-using-phpunit/
 */
class FormTest extends TestCase
{
	protected $form;
	protected $field;

	public function setUp()
	{
		parent::setUp();

		$builder = $this->app->make('form');
		$this->form = new Form($builder);
		// $this->field = Mockery::namedMock('Field', 'Flynsarmy\FormBuilder\Field');
	}

	/** @test */
	public function it_can_add_fields()
	{
		// Add 'id' field
		$this->form->add('id');
		Assert::attributeNotEmpty('fields', $this->form);
		$fields = Assert::readAttribute($this->form, 'fields');
		Assert::arrayHasKey('id', $fields);

		// Attempt to add 'id' field again
		// $this->setExpectedException('InvalidArgumentException');
	}

	/** @test */
	public function it_cannot_add_field_id_twice()
	{
		Assert::attributeEmpty('fields', $this->form);
	}
}