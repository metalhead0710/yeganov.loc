<?php
 class PhotoController extends Controller
 {
 	public $layouts = "frontend-page";
 	
 	public function actionView($id)
 	{
		$photoCat = Photos::getPhotoCat($id);
		$photos = Photos::getPhotosByCatalog($id);
		$this->view->vars('pageTitle', $photoCat->name . ' | YEGANOV Project');
		$this->view->vars('photoCat', $photoCat);
		$this->view->vars('ogImage', (isset($_SERVER['HTTPS']) ? "https" : "http") . "://{$_SERVER["HTTP_HOST"]}/upload/photos/{$photoCat->folder}/thumbs/{$photoCat->pic}");
		$this->view->vars('photos', $photos);
		$this->view->renderView('photo/view');
	}
 }
?>