<?php
class HomeController extends Controller 
{
	public $layouts = "frontend";
	
	public function actionIndex()	
	{
		$news = News::getFirstNews();
		$contact = Contacts::getContatcs();
		$music = Music::getMusic();
		$people = People::getCurrentPeople();
		$exPeople = People::getExPeople();
		$photoCats = Photos::getPhotoCats();
		$photos = Photos::getPhotos();
		$videos = Video::getVideo();
		$this->view->vars('pageTitle', 'Проект Віталія Єганова/YEGANOV Project');
		$this->view->vars('news', $news);
		$this->view->vars('people', $people);
		$this->view->vars('exPeople', $exPeople);
		$this->view->vars('photoCats', $photoCats);
		$this->view->vars('photos', $photos);
		$this->view->vars('videos', $videos);
		$this->view->vars('contact', $contact);
		$this->view->vars('music', $music);
				
		$this->view->renderView('home/index');		
	}	
	public function actionEmailUs()
	{
		$name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $content = $_POST['content'];
        if (!empty($name) && !empty($email) && !empty($content))
        {
			$adminEmail = Contacts::getEmail();			 
	        $message = "Від {$name}. Email: {$email}. Текст: {$content}.";
	        $subject = 'Із сайту';
	        $result = mail($adminEmail, $subject, $message);
			if ($result)
			{
				Messages::addMessage($name, $email, $phone, $content);
				echo "<div class='alert alert-success modal' style='width: 380px;margin: 0 auto; display:block;bottom:initial; overflow-y:hidden'><button class='close' data-dismiss='alert'><i class='fa fa-times'></i></button>Ваше повідомлення відправлено!</div>";
				return true;
			}
			else
			{
				echo "<div class='alert alert-danger modal' style='width: 380px;margin: 0 auto; display:block;bottom:initial; overflow-y:hidden'><button class='close' data-dismiss='alert'><i class='fa fa-times'></i></button>Повідомлення не відправлено. Спробуйте пізніше!</div>";
				return false;
			}
		}
		else 
		{
			echo "<div class='alert alert-danger modal' style='width: 380px;margin: 0 auto; display:block;bottom:initial; overflow-y:hidden'><button class='close' data-dismiss='alert'><i class='fa fa-times'></i></button>Заповність всі поля</div>";
			exit();
		}
	}
}
?>