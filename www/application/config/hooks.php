<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['pre_system'] = array(
    'class'    => 'PES_Bootstrap',
    'function' => 'setup',
    'filename' => 'PES_Bootstrap.php',
    'filepath' => 'hooks',
);

$hook['post_controller'] = array(
	'class'		=>	'PES_Autolayout',
	'function'	=>	'automatic_layout',
	'filename'	=>	'PES_Autolayout.php',
	'filepath'	=>	'hooks',
);