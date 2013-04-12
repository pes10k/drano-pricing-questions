<?php

class PES_Autolayout {
	
	protected $CI;

	public function __construct()
	{
		$this->CI = get_instance();
	}

	/**
	 * Method used with post_controller hook
	 * to perform automatic layout using the name of the 
	 * last called method in the last accessed controller.
	 * Automatically echoes out the HTML and then stops processing
	 * 
	 * @access public
	 * @return void
	 */
	public function automatic_layout()
	{
		if ( ! $this->CI->has_laid_out())
		{
			$method_name = $this->CI->router->fetch_method();
			$class_name = $this->CI->router->fetch_class();

			$this->CI->_layout($method_name);
		}
	}
}