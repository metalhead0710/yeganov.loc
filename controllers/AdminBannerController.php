<?php
 class AdminBannerController extends Controller
 {
 	public $layouts = "backend";
 	
 	public function actionIndex()	
	{
		User::checkLogged();
		$banners = Banners::getBanners();
				
		$this->view->vars('pageTitle', 'Банери');
		$this->view->vars('banners', $banners);		
		$this->view->vars('feedback', $this->feedback->get());
		$this->view->renderView('admin/banners/index');		
	}
	
	public function actionAdd()
	{
		User::checkLogged();
		if (isset($_POST['submit'])) 
		{            
            $pic = $_FILES["pic"];
            $sort_order = $_POST['sort_order'];
            if($pic['name'] != '') {
            	$pic['name'] = uniqid('banner') . '.jpg';                
                $destiny = ROOT . '/upload/images/banners/';
                //Files::make_upload($pic, $destiny);
                Files::make_thumb_and_upload($pic, $destiny, 200);
	        }
	        if (
		        Banners::createBanner(
					$pic['name'],
		            $sort_order
				)
	        )
	        {
	        	Files::updateSliderCssFile();
	        	$this->feedback->success("Банер додано");
            	header("Location: /admin/banners");
			}
			else
			{
				$this->feedback->error("Трапилась якась хуйня. Не можу додати банер");
            	header("Location: /admin/banners");
			}
				        				
		}		
	}
	public function actionUpdate($id)
	{
		User::checkLogged();
		$banner = Banners::getOneBanner($id);
		if (isset($_POST['submit'])) 
		{            
            $sort_order = $_POST['sort_order'];
            if (Banners::updateBanner(
	        	$id,
				$sort_order
			))
            {
            	Files::updateSliderCssFile();
				$this->feedback->success("Банер успішно збережено");
            	header("Location: /admin/banners");
			}
			else
			{
				$this->feedback->error("Не можу зберегти зміни, спробуйте пізніше");
            	header("Location: /admin/banners");
			}        				
		}		
	}
	public function actionRemove($id)
	{
		User::checkLogged();
		$banner = Banners::getOneBanner($id);	
        $folder = ROOT . '/upload/images/banners/';
		$oldFile = $banner->pic;
		Files::removeFileAndThumb($folder, $oldFile);
		if (Banners::deleteBanner($id))
		{
			Files::updateSliderCssFile();
			$this->feedback->success("Банер видалено");
			header("Location: /admin/banners");
		}
		else
		{
			$this->feedback->error("Не можу видалити банер");
			header("Location: /admin/banners");
		}        	
	}
 }
?>