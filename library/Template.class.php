<?php
class Template {
     
    protected $variables = array();
    protected $_controller;
    protected $_action;
     
    function __construct($controller,$action) {
        $this->_controller = $controller;
        $this->_action = $action;
    }
 
    /** Set Variables **/
 
    function set($name,$value) {
        $this->variables[$name] = $value;
    }
 
    /** Display Template **/
     
    function render($doNotRenderHeader = 0, $doNotRenderFooter = 0) {

        $html = new HTML;
        extract($this->variables);
         
        if ($doNotRenderHeader == 0) 
        {
            
            if (file_exists(ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . 'header.php')) 
            {
                include (ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . 'header.php');
            } 
            else
            {
                include (ROOT . DS . 'application' . DS . 'views' . DS . 'header.php');
            }
        }
        else
        {
            if (file_exists(ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . 'head.php')) 
            {
                include (ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . 'head.php');
            } 
            else
            {
                include (ROOT . DS . 'application' . DS . 'views' . DS . 'head.php');
            }
        }

        if (file_exists(ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . $this->_action . '.php')) {
            include (ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . $this->_action . '.php');         
        }
            
        if ($doNotRenderFooter == 0) 
        {
            if (file_exists(ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . 'footer.php')) {
                include (ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . 'footer.php');
            } else {
                include (ROOT . DS . 'application' . DS . 'views' . DS . 'footer.php');
            }
        }
        else
        {
            if (file_exists(ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . 'foot.php')) {
                include (ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . 'foot.php');
            } else {
                include (ROOT . DS . 'application' . DS . 'views' . DS . 'foot.php');
            }            

        }
    }
 
}