## Laravel Form Builder

[![Build Status](https://travis-ci.org/Flynsarmy/laravel-form-builder.png?branch=master)](https://travis-ci.org/Flynsarmy/laravel-form-builder)

### A simple and intuitive form builder

Laravel Form Builder has a relatively simple goal. Allow users to create a Form
object, add fields to it and render when ready. All the relevant HTML will be
spit out. Form Builder uses Laravel's Form facade and will render any field
supported by it including macros.


### Installation

Require this package in your composer.json and run `composer update` (or run `composer require flynsarmy/form-builder:1.0.*` directly):

	"flynsarmy/form-builder": "1.0.*"

After updating composer, add the ServiceProvider to the providers array in app/config/app.php

	'Flynsarmy\FormBuilder\FormBuilderServiceProvider',

and optionally the Facade to the aliases array in the same file. This will allow for global callbacks (more on that later).

	'FormBuilder'     => 'Flynsarmy\FormBuilder\Facades\FormBuilder',


### Usage

#### Add/Edit/Delete Fields

Create a form, add fields, render.

	$form = FormBuilder::form();

	//$form->add('<unique identifier>')->type('<Same as Form::$type facade>')->with('<any args required by Form::$type facade>');
	$form->add('first_name')->type('text')->with('first_name');
	$form->add('gender')->type('select')->with('gender', ['m'=>'Male', 'f'=>'Female']);

	$form->render();

Need to edit or remove a field?

	// Set field with id 'gender' to have 3 options instead of 2.
	$form->get('gender')->with('gender', ['m'=>'Male', 'f'=>'Female', 'n'=>'Not Telling']);

	// Remove the gender field
	$form->remove('gender');

Add fields exactly where you want them

	$form->addAfter('first_name', 'last_name')->...; // Add last name after first name
	$form->addBefore('last_name', 'first_name')->...; // Add first name before last name

Closures are also supported

	use Flynsarmy\FormBuilder\Form;
	use Flynsarmy\FormBuilder\Field;
	// Closure support for FormBuilder
	FormBuilder::form(function(Form $form) {
		$form
			// Closure support for add()
			->add('first_name', function(Field $field) {
				$field->type('text')->with('first_name');
			})
			->add('gender', function(Field $field) {
				$field->type('select')->with('gender', ['M'=>'Male', 'F'=>'Female']);
			});
	})->render();

Because Form Builder uses the Form facade, we can use `Form::model($model)` too!

	echo Form::model($model),
	    $form->render(),
	Form::close();


#### Field settings

You can assign settings to fields. These are most often used in conjunction with callbacks.

	$form->add('first_name')
		->type('text')->with('first_name', null, ['maxlength' => 10])
		// Pass any other settings your layout requires. You can use any method name.
		->label('First Name')
		->description('Enter your first name')
		->columns(12)
		->tab('Details');

To retrieve a setting

	// Retrieving a setting
	$field->label;

	// Retrieve all settings
	$field->settings;

#### Callbacks

Callbacks can be used to render your form exactly the way you want it to look.

Supported callbacks include:

	beforeForm(Form $form, array $tabs)
	afterForm(Form $form, array $tabs)
	beforeField(Form $form, Field $field)
	afterField(Form $form, Field $field)

They can be used on a per-form basis

	// Per-form Callbacks
	$form->bind('beforeField', function(Form $form, Field $field) {
		// Use field settings to display your form nicely
		return '<label>' . $field->label . '</label>';
	});

or using the optional facade, a global basis

	// Global form callbacks
	FormBuilder::bind('beforeField', function(Form $form, Field $field) {
			return '<div><label>'.$field->label.': </label>';
		})
		->bind('afterField', function(Form $form, Field $field) {
			return '</div>';
		});
	FormBuilder::form(function(Form $form) {
		$form->add('first_name')->type('text')->with('first_name')->label('First Name');
		$form->add('last_name')->type('text')->with('last_name')->label('Last Name');
	})->render();


### Exxamples

#### Twitter Bootstrap Integration

	// Add labels and help blocks to fields
	FormBuilder::
		bind('beforeField', function($field) {
			return '<div class="form-group"><label>'.$field->label.'</label>';
		})
		->bind('afterField', function($field) {
			$output = '';
			if ( $field->description )
				$output .= '<p class="help-block">' . $field->description . '</p>';
			return $output . '</div>';
		});

	$form = FormBuilder::form(function(Form $form) {
		$form->add('email', function(Field $field) {
			$field->type('email')->with('email', null, ['class' => 'form-control', 'placeholder' => 'Enter email'])->label('Email Address');
		})
		->add('password', function(Field $field) {
			$field->type('password')->with('password', ['class' => 'form-control', 'placeholder' => 'Password'])->label('Password');
		})
		->add('file_input', function(Field $field) {
			$field->type('file')->with('file_input')->label('File Input')->description("Example block-level help text here.");
		})
		->add('submit', function(Field $field) {
			$field->type('submit')->with('submit', ['class' => 'btn btn-default']);
		});
	});

	echo Form::model($model), $form->render(), Form::close();

### License

Laravel Form Builder is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)