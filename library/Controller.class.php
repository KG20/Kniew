<?php

// class is used for all communication between the controller, the model and the view (template class). It creates an object for the model class and an object for template class. The object for model class has the same name as the model itself, so that we can call it something like $this->Item->selectAll(); from our controller.

// While destroying the class we call the render() function which displays the view (template) file.

class Controller {

	protected $_controller;
	protected $_action;
	protected $_template;
	protected $_mymodel;

	public $doNotRenderHeader;
	public $doNotRenderFooter;
	public $render;
	public $nomodel;

	function __construct($controller, $action) {

    	global $inflect;


		$this->_controller = $controller;
		$this->_action = $action;

		if($this->_mymodel)
		{
			$model = $this->_mymodel;
		}
		else
		{
			$model = ucfirst($controller);
		}
		if(!isset($this->doNotRenderHeader))
		{
			$this->doNotRenderHeader = 0;		

		}
		if(!isset($this->doNotRenderFooter))
		{
			$this->doNotRenderFooter = 0;		

		}
		if(!isset($this->render))
		{
			$this->render = 1;
		}
		if(!isset($this->nomodel) && $this->nomodel != 1) {$this->$model = new $model;}
		$this->_template = new Template($controller,$action);

	}

	function set($name,$value) 
	{
		$this->_template->set($name,$value);
	}

	function __destruct() 
	{ 
		if ($this->render) {
			$this->_template->render($this->doNotRenderHeader, $this->doNotRenderFooter);
		}
	}

}
