<?php
class AdminController extends Controller 
{
	public $layouts = "backend";
	
	public function actionIndex ()
	{
		User::checkLogged();
		$photos = Photos::photoCount();
		$news = News::newsCount();
		$music = Music::musicCount();
		$people = People::peopleCount();
		$video = Video::videoCount();
		$unreadMessages = Messages::messagesCount();
		$messages = Messages::getMessages();
		
        $this->view->vars('unreadMessages', $unreadMessages);				
        $this->view->vars('messages', $messages);				
        $this->view->vars('photos', $photos);				
        $this->view->vars('news', $news);				
        $this->view->vars('music', $music);				
        $this->view->vars('people', $people);				
        $this->view->vars('video', $video);
        $this->view->vars('feedback', $this->feedback->get());
        			
        $this->view->vars('pageTitle', 'Адмінка');				
		$this->view->renderView('admin/index');	
	}
	public function actionRead($id)
	{
		User::checkLogged();
		if(Messages::readMessage($id))
		echo '<i class="fa fa-envelope-open-o"></i>';
	}
	public function actionDelete($id)
	{
		User::checkLogged();
		if (Messages::deleteMessage($id))
		{
			$this->feedback->success("Повідомлення видалено");
			header("Location: /admin");
		}
		else
		{
			$this->feedback->error("Не можу видалити повідомлення");
			header("Location: /admin");
		}  
	}
}
?>