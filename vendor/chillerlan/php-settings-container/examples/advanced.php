<?php
/**
 * @created      28.08.2018
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

use chillerlan\Settings\SettingsContainerAbstract;

require_once __DIR__.'/../vendor/autoload.php';

// from library 1
trait SomeOptions{
	protected string $foo;
	protected string $what;

	// this method will be called in SettingsContainerAbstract::construct()
	// after the properties have been set
	protected function SomeOptions():void{
		// just some constructor stuff...
		$this->foo = strtoupper($this->foo);
	}

	/*
	 * special prefixed magic setters & getters
	 */

	// this method will be called from __set() when property $what is set
	protected function set_what(string $value):void{
		$this->what = md5($value);
	}

	// this method is called on __get() for the property $what
	protected function get_what():string{
		return 'hash: '.$this->what;
	}
}

// from library 2
trait MoreOptions{
	protected string $bar = 'whatever'; // provide default values
}

$commonOptions = [
	// SomeOptions
	'foo' => 'whatever',
	// MoreOptions
	'bar' => 'nothing',
];

// now plug the several library options together to a single object

/**
 * @property string $foo
 * @property string $what
 * @property string $bar
 */
class MySettings extends SettingsContainerAbstract{
	use SomeOptions, MoreOptions; // ...
};

$container = new MySettings($commonOptions);

var_dump($container->foo); // -> WHATEVER (constructor ran strtoupper on the value)
var_dump($container->bar); // -> nothing

$container->what = 'some value';
var_dump($container->what); // -> hash: 5946210c9e93ae37891dfe96c3e39614 (custom getter added "hash: ")
