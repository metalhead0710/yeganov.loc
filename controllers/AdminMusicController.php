<?php
 class AdminMusicController extends Controller
 {
 	public $layouts = "backend";
 	
 	public function actionIndex()	
	{
		User::checkLogged();
		$music = Music::getMusic();
				
		$this->view->vars('pageTitle', 'Музика');
		$this->view->vars('music', $music);		
		$this->view->vars('feedback', $this->feedback->get());
		$this->view->renderView('admin/music/index');		
	}
	
	public function actionAdd()
	{
		User::checkLogged();
		if (isset($_POST['submit'])) 
		{            
            $title = $_POST['title'];                       
            $author = $_POST['author'];
            $pic = $_FILES["pic"];
            $song = $_FILES["song"];
            $sort_order = $_POST['sort_order'];
            $errors = array ();
			if($pic['name'] != '') {
            	$pic['name'] = uniqid('cover') . '.jpg';                
                $destiny = ROOT . '/upload/audio/tinypic/';
                if (!Files::make_thumb_and_upload($pic, $destiny, 100))
                {
					array_push($errors, false);
				}
	        }
	        if (!empty($song['name']))
	        {
				$song['name'] = uniqid('audio') . '.mp3';
				$destinyForMusic = ROOT . '/upload/audio/';
				if (!Files::make_upload($song, $destinyForMusic))
                {
					array_push($errors, false);
				}
			}
			if (!in_array(false, $errors))
	        {
	        	if(empty($pic['name']))
	        	{
					$picUrl = '/assets/img/112.jpg';
				}
				else
				{
					$picUrl = '/upload/audio/tinypic/thumbs/' . $pic['name'] ;
				}
	        	$songUrl = '/upload/audio/' . $song['name'];
				if (!Music::addSong(
					$title,
					$author,
					$song['name'],
					$songUrl,
					$pic['name'],
					$picUrl,
					$sort_order
				))
				{
					array_push($errors, false);
				}
			}
			if (!in_array(false, $errors))
			{
				Files::updateMusicJsFile();
			}
	        if (!in_array(false, $errors))
	        {
	        	$this->feedback->success("Аудіофайл додано");
            	header("Location: /admin/music");
			}
			else
			{
				$this->feedback->error("Трапилась якась хуйня. Музики не буде");
            	header("Location: /admin/music");
			}
				        				
		} 		
		$this->view->vars('pageTitle', 'Додати пісню');
		$this->view->renderView('admin/music/add');		
	}
	public function actionUpdate($id)
	{
		User::checkLogged();
		$songItem = Music::getOneSong($id);
		if (isset($_POST['submit'])) 
		{            
            $title = $_POST['title'];                       
            $author = $_POST['author'];
            $pic = $_FILES["pic"];
            $song = $_FILES["song"];
            $sort_order = $_POST['sort_order'];
            $errors = array ();
			if($pic['name'] != '') {
            	$pic['name'] = uniqid('cover') . '.jpg';                
                $destiny = ROOT . '/upload/audio/tinypic/';
                if (!Files::make_thumb_and_upload($pic, $destiny, 100) )
                {
                	array_push($errors, false);
				}
				else
				{
					Files::removeFileAndThumb($destiny, $songItem->picFileName);
				}
	        }
	        else{
				$pic['name'] = $songItem->picFileName;
			}
	        if (!empty($song['name']))
	        {
				$song['name'] = uniqid('audio') . '.mp3';
				$destinyForMusic = ROOT . '/upload/audio/';
				if (!Files::make_upload($song, $destinyForMusic))
                {
                	array_push($errors, false);
				}
				else
				{
					Files::removeFile($destinyForMusic . $songItem->songFileName);
				}
			}
			else{
				$song['name'] = $songItem->songFileName;
			}
			if (!in_array(false, $errors))
	        {
	        	$picUrl = '/upload/audio/tinypic/thumbs/' . $pic['name'] ;
	        	$songUrl = '/upload/audio/' . $song['name'];
				if (!Music::updateSong(
					$id,
					$title,
					$author,
					$song['name'],
					$songUrl,
					$pic['name'],
					$picUrl,
					$sort_order
				))
				{
					array_push($errors, false);
				}
			}
			if (!in_array(false, $errors))
			{
				Files::updateMusicJsFile();
			}
	        if (!in_array(false, $errors))
	        {
	        	$this->feedback->success("Аудіофайл збережено");
            	header("Location: /admin/music");
			}
			else
			{
				$this->feedback->error("Трапилась якась хуйня. Пісня не збереглась");
            	header("Location: /admin/music");
			}
		} 		
		$this->view->vars('pageTitle', 'Редагувати пісню');
		$this->view->vars('song', $songItem);
		$this->view->renderView('admin/music/update');		
	}
	public function actionRemove($id)
	{
		User::checkLogged();
		$song = music::getOneSong($id);	
        $folderPic = ROOT . '/upload/audio/tinypic/';
		$oldPic = $song->picFileName;
		$oldSong = ROOT . $song->songUrl;
		Files::removeFileAndThumb($folderPic, $oldPic);
		Files::removeFile($oldSong);
		if (music::deletesong($id))
		{
			$this->feedback->success("Пісню видалено");			
		}
		else
		{
			$this->feedback->error("Не можу видалити пісню");			
		}
		Files::updateMusicJsFile();
		header("Location: /admin/music");   	
	}
 }
?>