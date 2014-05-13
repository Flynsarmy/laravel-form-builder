<?php namespace Flynsarmy\FormBuilder;

use Closure;
use Illuminate\Html\FormBuilder;

class FormBuilderManager
{
	use Traits\Bindable;
	protected $builder;

	public function __construct(FormBuilder $builder)
	{
		$this->builder = $builder;
	}

	/**
	 * Create a new Form
	 *
	 * @param  Closure $callback   Optional closure accepting a Form object
	 *
	 * @return Flynsarmy\FormBuilder\Form
	 */
	public function form($callback = null)
	{
		$form = new Form($this->builder);

		foreach ( $this->bindings as $event => $binding_callback )
			$form->bind($event, $binding_callback);

		if ( $callback instanceof Closure )
			call_user_func($callback, $form);

		return $form;
	}
}