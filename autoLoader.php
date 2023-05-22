<?php
/**
 * @param $className
 *
 * @return void
 * @throws Exception
 */
function crmsAutoLoader($className){
	$basePath = '';

	$path = $basePath;
	$path .= str_replace('\\', '/', $className);
	$path .= '.php';

	if(file_exists($path))
	{
		require_once($path);
	} else {
		throw new \Exception("Class {$className} can not be found on path: {$path}");
	}

}

spl_autoload_register('crmsAutoLoader');
