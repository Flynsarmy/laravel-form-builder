<?php namespace Flynsarmy\FormBuilder;

use Closure;

class FormBuilderManager
{
	use Traits\Bindable;

	/**
	 * Create a new Form
	 *
	 * @param  Closure $callback   Optional closure accepting a Form object
	 *
	 * @return Flynsarmy\FormBuilder\Form
	 */
	public function form($callback = null)
	{
		$form = new Form();

		foreach ( $this->bindables as $event => $bindable_callback )
			$form->bind($event, $bindable_callback);

		if ( $callback instanceof Closure )
			call_user_func($callback, $form);

		return $form;
	}
}