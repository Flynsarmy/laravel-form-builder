<?php namespace Flynsarmy\FormBuilder;

use Illuminate\Html\FormBuilder;
use Flynsarmy\FormBuilder\Exceptions\UnknownType;

class Field
{
	protected $builder;
	protected $id;
	protected $type;
	protected $args = array();
	protected $settings = array();

	/**
	 * Creates a new form field.
	 *
	 * @param FormBuilder $builder
	 * @param string      $id      Unique identifier for the field
	 */
	public function __construct(FormBuilder $builder, $id)
	{
		$this->builder = $builder;
		$this->id = $id;
	}

	/**
	 * Set the field type.
	 *
	 * @param  string $type   Accepts any field type/macro the Form facade supports.
	 *
	 * @return Flynsarmy\FormBuilder\Field
	 */
	public function type($type)
	{
		$this->type = $type;

		return $this;
	}

	/**
	 * Set the field type.
	 *
	 * @param  splat $args   Any arguments the Form::$type() method requires.
	 *
	 * @return Flynsarmy\FormBuilder\Field
	 */
	public function with()
	{
		$this->args = func_get_args();

		return $this;
	}

	/**
	 * Use the Form facade to render the field based on the type and arguments
	 * provided.
	 *
	 * @return string
	 */
	public function render()
	{
		if ( !$this->type )
			throw new UnknownType("You must set a field type for field '".$this->id."'.");

		return call_user_func_array([$this->builder, $this->type], $this->args);
	}

	/**
	 * Return a setting if it exists
	 *
	 * @param  string $name 'id', 'type', 'settings' or previously entered setting.
	 *
	 * @return mixed      Setting value or null if not found.
	 */
	public function __get($name)
	{
		if ( in_array($name, array('id', 'type', 'settings')) )
			return $this->$name;

		if ( isset($this->settings[$name]) )
			return $this->settings[$name];

		return null;
	}

	/**
	 * Lets us add custom field settings to be used during the render process.
	 *
	 * @param  string $name      Setting name
	 * @param  array  $arguments Setting value(s)
	 *
	 * @return Flynsarmy\FormBuilder\Field
	 */
	public function __call($name, $arguments)
	{
		if ( method_exists($this, $name) )
			return call_user_func_array(array($this, $name), $arguments);

		if ( !sizeof($arguments) )
			$this->settings[$name] = true;
		elseif ( sizeof($arguments) == 1 )
			$this->settings[$name] = $arguments[0];
		else
			$this->settings[$name] = $arguments;

		return $this;
	}
}