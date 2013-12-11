<?php

spl_autoload_register(function ($class) {
	$file = 'lib/'.trim(str_replace(array('\\', '_'), '/', $class), '/').'.php';
	if(file_exists($file))
		require_once $file;
});
