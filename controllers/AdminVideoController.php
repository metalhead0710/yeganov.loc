<?php
class AdminVideoController extends Controller
{
	public $layouts = "backend";
	
	public function actionIndex()
	{
		User::checkLogged();
		
		$video = Video::getVideo();
		
		$this->view->vars('video', $video);
		$this->view->vars('feedback', $this->feedback->get());
		$this->view->vars('pageTitle', 'Відео');
		$this->view->renderView('admin/video/index');
	}
	
	public function actionCreate()
	{
		User::checkLogged();
		
		if (isset($_POST['submit'])) 
		{            
            $title = $_POST['title'];                       
            $sort_order = $_POST['sort_order'];
            $url = $_POST['url'];
            if ( Video::createVideo(
					$title,                       
		            $sort_order,
		            $url
				)
	        )
	        {
	        	$this->feedback->success("Відео додано");
            	header("Location: /admin/video");
			}
			else
			{
				$this->feedback->error("Трапилась якась хуйня. Відео не буде");
            	header("Location: /admin/video");
			}				        				
		} 
		
		$this->view->vars('pageTitle', 'Створити відео');
		$this->view->renderView('admin/video/create');		
	}
	public function actionUpdate($id)
	{
		User::checkLogged();
		$video = Video::getOneVideo($id);
		if (isset($_POST['submit'])) 
		{            
            $title = $_POST['title'];                       
            $sort_order = $_POST['sort_order'];
            $url = $_POST['url'];
            if ( Video::updateVideo(
            		$id,
					$title,                       
		            $sort_order,
		            $url
				)
	        )
	        {
	        	$this->feedback->success("Відео збережено");
            	header("Location: /admin/video");
			}
			else
			{
				$this->feedback->error("Трапилась якась хуйня. Зміни не збереглись");
            	header("Location: /admin/video");
			}				        				
		} 
		
		$this->view->vars('pageTitle', 'Редагувати відео');
		$this->view->vars('video', $video);
		$this->view->renderView('admin/video/update');
	}
	public function actionDelete($id)
	{
		User::checkLogged();
		if (Video::deleteVideo($id))
		{
			$this->feedback->success("Відео видалено");
			header("Location: /admin/video");
		}
		else
		{
			$this->feedback->error("Не можу видалити відео");
			header("Location: /admin/video");
		}        	
	}
}
?>