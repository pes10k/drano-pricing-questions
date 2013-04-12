<?php

class PES_Controller extends CI_Controller {

	private $breadcrumbs = array();

	/**
	 * Tracks whether the content has been passed through the
	 * layout template.  Used to make sure we don't send out
	 * two complete pages when looking using the post controller
	 * hook
	 *
	 * @var mixed
	 * @access public
	 */
	protected $has_laid_out = FALSE;

	/**
	 * Array of varables to pass to templates.	 The values for each key
	 * will be passed to the template into a variable with the same name
	 * and the coresponding value
	 *
	 * (default value: array())
	 *
	 * @var array
	 * @access public
	 */
	public $data = array(
    	'additional_scripts' => array(),
	);

	/**
	 * The name of the template to feed the site content into.
	 * These layout templates are located in /views/layout
	 *
	 * (default value: 'main')
	 *
	 * @var string
	 * @access public
	 */
	public $layout = 'main';

	function _add_partial($name = FALSE)
	{
		$this->_populate_templates();
		$this->data[$name] = $this->_partial($name);
	}

	function _partial($name = FALSE, $data = FALSE)
	{
		$variables = $data ? $data : $this->data;
		$this->_populate_templates();
		return $this->load->view('partial/'.$name, $variables, TRUE);
	}

	function _layout($subview = '', $file = '', $class = FALSE, $cache_key = FALSE)
	{
		if ($file === '')
		{
			$file = $this->layout;
		}

		if ( ! $class)
		{
			$class = get_class($this);
		}

	 	$this->_populate_templates();

		if ( ! isset($this->data['yield']))
		{
			$this->data['yield'] = $this->load->view($file.'/'.strtolower($class).'/'.$subview, $this->data, TRUE);
		}

		if ($file === 'none')
		{
			if ($cache_key !== FALSE)
			{
				$this->khcache->store($cache_key, $this->data['yield']);
			}
			echo $this->data['yield'];
			exit;
		}
		else
		{
			$this->has_laid_out = TRUE;

			if ($cache_key !== FALSE)
			{
				$html = $this->load->view('layout/'.$this->layout, $this->data, TRUE);
				$this->khcache->store($cache_key, $html);

				$data = array(
					'cached_html'	=>	$html,
				);

				$this->load->view('cache/html', $data);
			}
			else
			{
				$this->load->view('layout/'.$this->layout, $this->data);
			}
		}
	}

	public function _display_cached_page($cache_key)
	{
		if (($html = $this->khcache->fetch($cache_key)) === FALSE)
		{
			return FALSE;
		}
		else
		{
			$data = array(
				'cached_html'	=>	$html,
			);

			$this->load->view('cache/html', $data);
			return TRUE;
		}
	}

	/**
	 * Returns whether or not the content has been laid out
	 * (ie whether or not we've sent a complete page to the
	 * browser)
	 *
	 * @access public
	 * @return bool
	 */
	public function has_laid_out()
	{
		return $this->has_laid_out;
	}

	private function _populate_templates()
	{
		$alerts = array(
			'alert',
			'alert_info',
			'alert_error',
			'alert_success',
		);

		foreach ($alerts as $an_alert_type)
		{
			if ($an_alert = $this->session->flashdata($an_alert_type))
			{
				$this->data[$an_alert_type] = $an_alert;
			}
		}

		if (empty($this->data['message']) && ! empty($this->session))
		{
			$this->data['message'] = $this->session->flashdata('message');
		}

		$this->data['breadcrumbs'] = $this->breadcrumbs;
		$this->data['ci'] = $this;
	}

	protected function set_data($key, $val)
	{
		$this->data[$key] = $val;
		return $this;
	}

	protected function add_script($script)
	{
		$this->data['additional_scripts'][] = $script;
		return $this;
	}

	protected function add_breadcrumb($item)
	{
		$this->breadcrumbs[] = $item;
		return $this;
	}
}
