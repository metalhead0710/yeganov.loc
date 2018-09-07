<?php
class AdminContactsController extends Controller 
{
	public $layouts = "backend";
	
	public function actionIndex()
	{
		User::checkLogged();
		$contact = Contacts::getContatcs();
		
		if ($contact->id == 0)
		{
			$contact = Contacts::createRow();
		}
		if (isset($_POST['submit'])) 
		{            
            $email = $_POST['email'];                       
            $tel1 = $_POST['tel1'];
            $tel2 = $_POST["tel2"];
            $vk = $_POST['vk'];
            $facebook = $_POST['facebook'];
            $youtube = $_POST['youtube'];
            
	        if (Contacts::updateContact(
				        	$email, 
				        	$tel1, 
				        	$tel2, 
				        	$vk, 
				        	$facebook, 
				        	$youtube
						)
			)
            {
				$this->feedback->success("Контакти збережено");
            	header("Location: /admin/contacts");
            	die();
			}
			else
			{
				$this->feedback->error("Не можу зберегти зміни, спробуйте пізніше");
            	header("Location: /admin/contacts");
            	die();
			}        				
		}
		
		$this->view->vars('contact', $contact);
		$this->view->vars('feedback', $this->feedback->get());
		$this->view->vars('pageTitle', 'Редагувати контакти');
		$this->view->renderView('admin/contacts/update');
	}
}
?>