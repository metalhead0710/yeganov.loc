<?php

class ErrorController extends Controller
{
	public $layouts = "frontend-page";
	
	public function action404()
	{
		$this->view->vars('pageTitle', 'Помилка');
		$this->view->renderView('error/404');
	}
}
	
	
?>
