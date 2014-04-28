<?php namespace Flynsarmy\FormBuilder\Traits;

use Closure;

trait Bindable
{
	protected $bindings = array();

	public function getBinding($binding, $default=NULL)
	{
		if ( isset($this->bindings[$binding]))
			return $this->bindings[$binding];

		return $default;
	}

	public function bind($event, Closure $callback)
	{
		$this->bindings[$event] = $callback;

		return $this;
	}

	public function unbind($event)
	{
		if ( isset($this->bindings[$event]) )
			unset($this->bindings[$event]);

		return $this;
	}

	public function fire()
	{
		$args = func_get_args();
		$event = array_shift($args);

		if ( isset($this->bindings[$event]) )
			return call_user_func_array($this->bindings[$event], $args);

		return '';
	}
}