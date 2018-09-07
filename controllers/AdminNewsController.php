<?php
class AdminNewsController extends Controller 
{
	public $layouts = "backend";
	
	public function actionIndex($page = 1)	
	{
		User::checkLogged();
		$news = News::getNews($page);
		$total = News::newsCount();
		
		$pagination = new Pagination($total, $page, News::LIM, 'page-');
		
		$this->view->vars('pageTitle', 'Новини');
		$this->view->vars('news', $news);
		$this->view->vars('pagination', $pagination);
		$this->view->vars('feedback', $this->feedback->get());
		$this->view->renderView('admin/news/index');		
	}
	
	public function actionCreate()
	{
		User::checkLogged();
		if (isset($_POST['submit'])) 
		{            
            $title = $_POST['title'];                       
            $place = $_POST['place'];
            $pic = $_FILES["pic"];
            $date = $_POST['date'];
            $time = $_POST['hours'] . ':' . $_POST['mins'];
            $newtext = $_POST['newtext'];
            if(empty($date))
            {
				$date = date('Y-m-d');
			}
			if($time === ':')
            {
            	$now = new DateTime();
				$time = $now->format('H:i:s');
			}
			if($pic['name'] != '') {
            	$pic['name'] = uniqid('post') . '.jpg';                
                $destiny = ROOT . '/upload/images/posts/';
                //Files::make_upload($pic, $destiny);
                Files::make_thumb_and_upload($pic, $destiny, 200);
	        }
	        if (
		        News::createNew(
					$title,                       
		            $place,
		            $pic['name'],
		            $date,
		            $time,
		            $newtext
				)
	        )
	        {
	        	$this->feedback->success("Новину сторено");
            	header("Location: /admin/news");
			}
			else
			{
				$this->feedback->error("Трапилась якась хуйня. Новини не буде");
            	header("Location: /admin/news");
			}
				        				
		} 
		
		$this->view->vars('pageTitle', 'Створити новину');
		$this->view->renderView('admin/news/create');
	}	
	public function actionUpdate($id)
	{
		User::checkLogged();
		$new = News::getNew($id);
		if (isset($_POST['submit'])) 
		{            
            $title = $_POST['title'];                       
            $place = $_POST['place'];
            $pic = $_FILES["pic"];
            $date = $_POST['date'];
            $time = $_POST['hours'] . ':' . $_POST['mins'];
            $newtext = $_POST['newtext'];
            if(empty($date))
            {
				$date = date('Y-m-d');
			}
			if($time === ':')
            {
            	$time = date('H:i:s');
			}
			if($pic['name'] != '') {
				$folder = ROOT . '/upload/images/posts/';
				$oldFile = $new->pic;
				Files::removeFileAndThumb($folder, $oldFile);
            	$pic['name'] = uniqid('post') . '.jpg';                
                $destiny = ROOT . '/upload/images/posts/';                
                Files::make_thumb_and_upload($pic, $destiny, 200);
	        }
	        else{
				$pic['name'] = $new->pic;
			}
	        if (News::updateNew(
	        	$id,
				$title,                       
	            $place,
	            $pic['name'],
	            $date,
	            $time,
	            $newtext
			))
            {
				$this->feedback->success("Новину успішно збережено");
            	header("Location: /admin/news");
			}
			else
			{
				$this->feedback->error("Не можу зберегти зміни, спробуйте пізніше");
            	header("Location: /admin/news");
			}        				
		}
		
		$this->view->vars('new', $new);
		$this->view->vars('pageTitle', 'Редагувати новину');
		$this->view->renderView('admin/news/update');
	}
	public function actionDelete($id)
	{
		User::checkLogged();
		$new = News::getNew($id);		
        $folder = ROOT . '/upload/images/posts/';
		$oldFile = $new->pic;
		Files::removeFileAndThumb($folder, $oldFile);
		if (News::deleteNew($id))
		{
			$this->feedback->success("Новину видалено");
			header("Location: /admin/news");
		}
		else
		{
			$this->feedback->error("Не можу видалити пост");
			header("Location: /admin/news");
		}        	
	}
}
?>