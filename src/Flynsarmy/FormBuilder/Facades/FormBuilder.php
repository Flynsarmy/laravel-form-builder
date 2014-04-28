<?php namespace Flynsarmy\FormBuilder\Facades;

use Illuminate\Support\Facades\Facade;

class FormBuilder extends Facade
{
	public static function getFacadeAccessor()
	{
		return 'formbuilder';
	}
}