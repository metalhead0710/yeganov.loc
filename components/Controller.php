<?php
class Controller {

	//protected $view;
	protected $layouts; 	
	public $vars = array();
	protected $feedback;
	
	function __construct() {
		//$start = microtime(true);
		$this->feedback = new Feedback();
		$this->view = new View($this->layouts, get_class($this));
		$this->Model = new Model();
		//$time = microtime(true) - $start;
		//printf('Скрипт выполнялся %.4F сек.', $time);
		
	}
}
?>