<?php namespace Flynsarmy\FormBuilder\Tests;

class TestCase extends \Orchestra\Testbench\TestCase
{
	public function setUp()
	{
		parent::setUp();

		$this->getEnvironmentSetUp($this->app);
	}

	/**
	 * Get package providers.  At a minimum this is the package being tested, but also
	 * would include packages upon which our package depends, e.g. Cartalyst/Sentry
	 * In a normal app environment these would be added to the 'providers' array in
	 * the config/app.php file.
	 *
	 * @return array
	 */
	protected function getPackageProviders()
	{
		return [
			'Flynsarmy\FormBuilder\FormBuilderServiceProvider',
		];
	}

	/**
	 * Define environment setup.
	 *
	 * @param  Illuminate\Foundation\Application    $app
	 * @return void
	 */
	protected function getEnvironmentSetUp($app)
	{

	}
}