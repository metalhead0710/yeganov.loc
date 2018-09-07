<?php
class AdminAboutController extends Controller 
{
	public $layouts = "backend";
	
	public function actionIndex()	
	{
		User::checkLogged();
		$people = People::getPeople();
				
		$this->view->vars('pageTitle', 'Учасники');
		$this->view->vars('people', $people);		
		$this->view->vars('feedback', $this->feedback->get());
		$this->view->renderView('admin/about/index');		
	}
	
	public function actionCreate()
	{
		User::checkLogged();
		if (isset($_POST['submit'])) 
		{            
            $name = $_POST['name'];                       
            $position = $_POST['position'];
            $pic = $_FILES["pic"];
            $text = $_POST['text'];
            $isCurrent = ($_POST['isCurrent'] == 1 ) ? TRUE : FALSE;
            $display = ($_POST['display'] == 1 ) ? TRUE : FALSE;
			if($pic['name'] != '') {
            	$pic['name'] = uniqid('person') . '.jpg';                
                $destiny = ROOT . '/upload/images/people/';
                //Files::make_upload($pic, $destiny);
                Files::make_thumb_and_upload($pic, $destiny, 200);
	        }
	        if (
		        People::createPerson(
					$name,                       
		            $position,
		            $pic['name'],
		            $text,
		            $isCurrent,
		            $display
				)
	        )
	        {
	        	$this->feedback->success("Людину додано");
            	header("Location: /admin/about");
			}
			else
			{
				$this->feedback->error("Трапилась якась хуйня. Не можу додати учасника");
            	header("Location: /admin/about");
			}
				        				
		} 
		
		$this->view->vars('pageTitle', 'Створити учасника');
		$this->view->renderView('admin/about/create');
	}	
	public function actionUpdate($id)
	{
		User::checkLogged();
		$person = People::getPerson($id);
		if (isset($_POST['submit'])) 
		{            
            $name = $_POST['name'];                       
            $position = $_POST['position'];
            $pic = $_FILES["pic"];
            $text = $_POST['text'];
            $isCurrent = ($_POST['isCurrent'] == 1 ) ? TRUE : FALSE;
            $display = ($_POST['display'] == 1 ) ? TRUE : FALSE;
            if($pic['name'] != '') {
				$folder = ROOT . '/upload/images/people/';
				$oldFile = $person->pic;
				Files::removeFileAndThumb($folder, $oldFile);
            	$pic['name'] = uniqid('person') . '.jpg';                
                $destiny = ROOT . '/upload/images/people/';                
                Files::make_thumb_and_upload($pic, $destiny, 200);
	        }
	        else{
				$pic['name'] = $person->pic;
			}
	        if (People::updatePerson(
	        	$id,
				$name,                       
	            $position,
	            $pic['name'],
	            $text,
	            $isCurrent,
	            $display
			))
            {
				$this->feedback->success("Учасника успішно збережено");
            	header("Location: /admin/about");
			}
			else
			{
				$this->feedback->error("Не можу зберегти зміни, спробуйте пізніше");
            	header("Location: /admin/about");
			}        				
		}
		
		$this->view->vars('person', $person);
		$this->view->vars('pageTitle', 'Редагувати учасника');
		$this->view->renderView('admin/about/update');
	}
	public function actionDelete($id)
	{
		User::checkLogged();
		$person = People::getPerson($id);		
        $folder = ROOT . '/upload/images/people/';
		$oldFile = $person->pic;
		Files::removeFileAndThumb($folder, $oldFile);
		if (People::deletePerson($id))
		{
			$this->feedback->success("Учасника видалено");
			header("Location: /admin/about");
		}
		else
		{
			$this->feedback->error("Не можу видалити учасника");
			header("Location: /admin/about");
		}        	
	}
}
?>