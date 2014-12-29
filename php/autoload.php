<?php
/**
 * This files has the capability of loading and linking portions of this application automatically
 * when needed, so that it is not required to define or include those portions of the
 * program explicitly.
 * By using this snippet the application is given a last chance to load the class before PHP
 * fails with an error.
 * 
 */

error_reporting(E_ALL);

set_include_path(get_include_path() . ':' . __DIR__ . '/src'); // For include path config option



spl_autoload_register(function ($class) { //spl_autoload_register() provides a more flexible alternative for autoloading classes.

	$class = ltrim($class, '\\');
	$file  = '';
	$namespace = '';

	if ($endOfNs = strrpos($class, '\\')) {
		$namespace = substr($class, 0, $endOfNs);
		$class = substr($class, $endOfNs + 1);
		$file  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
	}
	$file .= $class .'.php';
	require_once $file;
});
