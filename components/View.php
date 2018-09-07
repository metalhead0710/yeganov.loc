<?php
class View
{
	private $view;
	private $controller;
	private $layouts;
	private $vars = array();
	
	public function __construct($layouts = 'frontend', $controllerName) {
		$this->layouts = $layouts;
		$this->controller = strtolower(preg_replace("/(Controller)$/", "", $controllerName));
	}
	
	public function vars($varname, $value) {
		if (isset($this->vars[$varname]) == true) {
			trigger_error ('Не можу встановити змінну <strong>' . $varname . '</strong>. Already set, and overwrite not allowed.', E_USER_NOTICE);
			return false;
		}
		$this->vars[$varname] = $value;
		return true;
	}
	
	public function renderView($name) {
		$pathLayout = ROOT . DS. 'views' . DS . 'layouts' . DS . $this->layouts . '.phtml';
		$contentPage = ROOT . DS.'views' . DS . $name . '.phtml';
		if (file_exists($pathLayout) == false) {
			trigger_error ('Шаблон <strong>' . $this->layouts . '</strong> не існує.', E_USER_NOTICE);
			return false;
		}
		if (file_exists($contentPage) == false) {
			trigger_error ('Сторінка <strong>' . $name . '</strong> не існує.', E_USER_NOTICE);
			return false;
		}
		
		foreach ($this->vars as $key => $value) {
			$$key = $value;
		}

		include ($pathLayout);                
	}
	
	public function renderPartial($name) {
		$contentPage = ROOT . DS.'views' . DS . $this->controller . DS . $name . '.phtml';
		
		if (file_exists($contentPage) == false) {
			trigger_error ('Сторінка <strong>' . $name . '</strong> не існує.', E_USER_NOTICE);
			return false;
		}
		
		foreach ($this->vars as $key => $value) {
			$$key = $value;
		}
		include_once($contentPage);
	}	
}
?>