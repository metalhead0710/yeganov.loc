<?php
class NewsController extends Controller
{
	public $layouts = "frontend-page";
	
	public function actionIndex()	
	{
		$news = News::getAllNews();			
		$this->view->vars('pageTitle', 'Новини | YEGANOV Project');
		$this->view->vars('news', $news);				
		$this->view->renderView('news/index');
	}

	public function actionView($id)
    {
	    $new = News::getNew($id);
	    $this->view->vars('pageTitle', $new->title .' | YEGANOV Project');
	    $this->view->vars('ogImage', (isset($_SERVER['HTTPS']) ? "https" : "http") . "://{$_SERVER["HTTP_HOST"]}/upload/images/posts/{$new->pic}");
	    $this->view->vars('new', $new);
        $this->view->renderView('news/view');
    }
}
?>