<?php
class AdminPhotoController extends Controller
{
	public $layouts = "backend";
	
	public function actionIndex()	
	{
		User::checkLogged();
		$photocats = Photos::getPhotoCats();
				
		$this->view->vars('pageTitle', 'Фото');
		$this->view->vars('photocats', $photocats);		
		$this->view->vars('feedback', $this->feedback->get());
		$this->view->renderView('admin/photo/index');		
	}
	
	public function actionCreate()
	{
		User::checkLogged();
		if (isset($_POST['submit'])) 
		{            
            $name = $_POST['name'];                       
            $pic = $_FILES["pic"];
            $sort_order = $_POST['sort_order'];
            $folder = Translit::make_lat($name);
            if($pic['name'] != '') {
            	$pic['name'] = uniqid('photocat') . '.jpg';                
                $destiny = ROOT . '/upload/photos/'  . $folder . DS;
                if (!file_exists(ROOT . '/upload/photos/' . $folder))
                {
                    mkdir(ROOT . '/upload/photos/' . $folder );
                }
                //Files::make_upload($pic, $destiny);
                Files::make_thumb_and_upload($pic, $destiny, 250);
	        }
	        if (
		    	Photos::createPhotoCat(
					$name,                       
		            $pic['name'],
		            $sort_order,
		            $folder		            
				)
	        )
	        {
	        	$this->feedback->success("Каталог додано");
            	header("Location: /admin/photo");
			}
			else
			{
				$this->feedback->error("Трапилась якась хуйня. Не можу додати каталог");
            	header("Location: /admin/photo");
			}
				        				
		} 
		
		$this->view->vars('pageTitle', 'Створити каталог');
		$this->view->renderView('admin/photo/create');
	}	
	public function actionUpdate($id)
	{
		User::checkLogged();
		$photocat = Photos::getPhotoCat($id);
		$oldpic = $photocat->pic;
		if (isset($_POST['submit'])) 
		{            
            $name = $_POST['name'];                       
            $pic = $_FILES["pic"];
            $sort_order = $_POST['sort_order'];
            $folder = Translit::make_lat($name);
            if ($folder != $photocat->folder)
            {
				rename (ROOT . '/upload/photos/'  . $photocat->folder . DS, ROOT . '/upload/photos/'  . $folder . DS);
			} 
				
            if(!empty($pic['name'])) {
            	$pic['name'] = uniqid('photocat') . '.jpg';    
							
                $destiny = ROOT . '/upload/photos/'  . $folder . DS;
                Files::removeFileAndThumb($destiny, $oldpic);               
                //Files::make_upload($pic, $destiny);
                Files::make_thumb_and_upload($pic, $destiny, 250);
	        }
	        if (
		    	Photos::updatePhotoCat(
		    		$id,
					$name,                       
		            !empty($pic['name']) ? $pic['name'] : $oldpic,
		            $sort_order,
		            $folder		            
				)
	        )
            {
				$this->feedback->success("Каталог успішно збережено");
            	header("Location: /admin/photo");
			}
			else
			{
				$this->feedback->error("Не можу зберегти зміни, спробуйте пізніше");
            	header("Location: /admin/photo");
			}        				
		}
		
		$this->view->vars('photocat', $photocat);
		$this->view->vars('pageTitle', 'Редагувати каталог');
		$this->view->renderView('admin/photo/update');
	}
	public function actionDeleteCat($id)
	{
		User::checkLogged();
		$photocat = Photos::getPhotoCat($id);		
        $folder = ROOT . '/upload/photos/' . $photocat->folder . DS;
		$oldFile = $photocat->pic;
		Files::removeFileAndThumb($folder, $oldFile);
		Files::removeFolder($folder);
		if (Photos::deletePhotoCat($id))
		{
			$this->feedback->success("Каталог видалено");
			header("Location: /admin/photo");
		}
		else
		{
			$this->feedback->error("Не можу видалити каталог");
			header("Location: /admin/photo");
		}        	
	}
	
	
	public function actionAdd($id)
    {
        User::checkLogged();
        $photocat = Photos::getPhotoCat($id);
        if (isset($_POST['submit']))
        {
        	$folder = $photocat->folder;
            $pics = Files::reArrayFiles($_FILES["pic"]);
            
			if (!file_exists(ROOT . '/upload/photos/' .$photocat->folder . '/thumbs/'))
            {
                mkdir(ROOT . '/upload/photos/' .$photocat->folder . '/thumbs/');
            }
            $res = array ();			
            foreach($pics as $pic) 
            {
	            $pic['name'] = uniqid('photo') . '.jpg';                
                $destiny = ROOT . '/upload/photos/'  . $folder . DS;
                //Files::make_upload($pic, $destiny);
                Files::make_thumb_and_upload($pic, $destiny, 250);
                if ( Photos::addPhoto($pic['name'], $id) )
                {
					array_push($res, true);
				}
            }
            $r = 0;
            for($i=0; $i<count($res); $i++)
            {
            	if ($res[$i] == true)
            	{
					$r++;
				}				
			}
            if ($r == count($pics))
            {            	
				$this->feedback->success("Фото додано");
			}
			else
			{
				$this->feedback->warning("Деякі фото могли не завантажитись");
			}
            header("Location: /admin/photo/edit/" . $id );
        }
        $this->view->vars('photocat', $photocat);
		$this->view->vars('pageTitle', 'Додати фото');
		$this->view->renderView('admin/photo/add');
    }
    
    public function actionEdit($id)
    {
		User::checkLogged();
        $photocat = Photos::getPhotoCat($id);
        $photos = Photos::getPhotosByCatalog($id);
        $this->view->vars('photocat', $photocat);
        $this->view->vars('photos', $photos);
        $this->view->vars('feedback', $this->feedback->get());
		$this->view->vars('pageTitle', 'Додати фото');
		$this->view->renderView('admin/photo/edit');
	}
	
	public function actionDeleteOnePhoto($photoId)

    {
        User::checkLogged();
        
        $photo = Photos::getOnePhoto($photoId);
        $photocat = Photos::getPhotoCat($photo->photocatId);
        Files::removeFileAndThumb($photocat->folder, $photo->pic);
        if (Photos::deleteOnePhoto($photoId))
        {
			$this->feedback->success('Фото видалено');
		}
		else
		{
			$this->feedback->error('Не можу видалити фото');
		}
        header("Location: /admin/photo/edit/". $photo->photocatId);
    }
    
    public function actionDeleteMassivePhoto($id)
    {
        User::checkLogged();
        $photocat = Photos::getPhotoCat($id);
        $checked = $_POST['pic'];
        $folder = ROOT . '/upload/photos/' . $photocat->folder . DS;
        $res = array ();
        foreach  ($checked as $value) {
            $photo = Photos::getOnePhoto($value);
            Files::removeFileAndThumb($folder, $photo->pic);
            if(Photos::deleteOnePhoto($value))
            {
				array_push($res, true);
			}
        }
        $r = 0;
        for($i=0; $i<count($res); $i++)
        {
        	if ($res[$i] == true)
        	{
				$r++;
			}				
		}
        if ($r == count($checked))
        {            	
			$this->feedback->success("Фото видалено");
		}
		else
		{
			$this->feedback->warning("Деякі фото могли не видалитись");
		}
        header("Location: /admin/photo/edit/". $id);        
    }
	
}
?>