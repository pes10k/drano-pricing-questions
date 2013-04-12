<?php

class PES_Bootstrap {

	function setup()
	{
		spl_autoload_register('pes_bootstrap_autoload');

		include APPPATH.'libraries/SplClassLoader.php';
		$loader = new SplClassLoader('PES', APPPATH.'libraries');
		$loader->register();
	}
}

function pes_bootstrap_autoload($class_name)
{
	if ( ! class_exists($class_name))
	{
		static $find = array(
			'CI_' => '',
			'_' => '/',
			'\'' => '/',
		);

		$pear_class_path = APPPATH.'libraries/'.str_replace(array_keys($find), array_values($find), $class_name);
		$ci_class_path = APPPATH.'libraries/'.str_replace('_', '/', $class_name).'.php';

		if (is_file($pear_class_path.'.php'))
		{
			require_once $pear_class_path.'.php';
		}
		elseif (is_file($ci_class_path))
		{
			require_once $ci_class_path;
		}
	}
}
