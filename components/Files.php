<?php
class Files
{
	public static function can_upload($picture){
	    if($picture['name'] == '')
	        return '';
	    if($picture['size'] == 0)
	        return 'Файл надто великий.';
	    $getMime = explode('.', $picture['name']);
	    $mime = strtolower(end($getMime));
	    $types = array('jpg', 'png', 'gif', 'bmp', 'jpeg', 'mp3');
	    if(!in_array($mime, $types))
	        return 'Недопустимий тип файлу.';
	    return true;
	}
	public static function make_upload($file, $destiny){
		if (self::can_upload($file))
		{
			if (copy($file['tmp_name'], $destiny . $file['name']))
			{
				return true;
			}			
		}
	    else{
            echo "<strong>$check</strong>";
            return false;
        }
	}
	public static function make_thumb_and_upload($picture, $destiny, $desired_width)
	{
		if (self::can_upload($picture))
		{
			copy($picture['tmp_name'], $destiny . $picture['name']);
		}
	    else{
            echo "<strong>$check</strong>";
        }
        $src_folder = $destiny;
        $src_file_path = $destiny . $picture['name'];
        $src_file_name = $picture['name'];
        if (self::make_thumb($src_folder, $src_file_path, $src_file_name, $desired_width))
        {
			return true;
		}
		else
		{
			return false;
		}

	}
	public static function make_thumb($src_folder, $src_file_path, $src_file_name, $desired_width) {
	    /* читаєм сорс картинку */
	    if (!file_exists($src_folder . DS. 'thumbs')) {
		    mkdir($src_folder . DS. 'thumbs');
		}
		$dest = $src_folder . 'thumbs' . DS . $src_file_name;
		if (mime_content_type($src_file_path) === 'image/jpeg')
		{
			$source_image = imagecreatefromjpeg($src_file_path);
		}
		else if (mime_content_type($src_file_path) === 'image/png')
		{
			$source_image = imagecreatefrompng($src_file_path);
		}	    
	    $width = imagesx($source_image);
	    $height = imagesy($source_image);
	    /* знаходим висоту під пропорцію ширини  */
	    $desired_height = floor($height * ($desired_width / $width));
	    /* створюєм нове "віртуальне" зображення */
	    $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
	    /* конвертуєм ... */
	    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
	    /* створюєм фізичне зображення */
	    if (mime_content_type($src_file_path) === 'image/jpeg')
		{
			if(imagejpeg($virtual_image, $dest))
			{
				return true;
			}
			
		}
		else if (mime_content_type($src_file_path) === 'image/png')
		{
			if (imagepng($virtual_image, $dest))
			{
				return true;
			}			
		}
	}
	public static function deleteDir($dirPath) {
	    if (! is_dir($dirPath)) {
	        echo ("Не можу знайти папку $dirPath");
	    }
	    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
	        $dirPath .= '/';
	    }
	    $files = glob($dirPath . '*', GLOB_MARK);
	    foreach ($files as $file) {
	        if (is_dir($file)) {
	            deleteDir($file);
	        } else {
	            unlink($file);
	        }
	    }
	    rmdir($dirPath);
	}
	public static function removeFile($filePath)
	{
		if(unlink($filePath))
		{
			return true;
		}
	}
	public static function removeFileAndThumb($folder, $filename)
	{
		$mainFile = $folder . $filename;
		$thumb = $folder . 'thumbs' . DS . $filename;
		if (file_exists($mainFile) && !empty($filename))
		{
			unlink($mainFile);
		}
		if (file_exists($thumb) && !empty($filename))
		{
			if(unlink($thumb))
			return true;			
		}		
	}
	public static function removeFolder($folder)
	{
		$thumb = $folder . 'thumbs'. DS;
		
		if (file_exists($thumb))
		{
			rmdir($thumb);
		}
		if (file_exists($folder))
		{
			rmdir($folder);
		}		
	}
	
	public static function reArrayFiles(&$file_post) 
	{
	    $file_ary = array();
	    $file_count = count($file_post['name']);
	    $file_keys = array_keys($file_post);

	    for ($i=0; $i<$file_count; $i++) {
	        foreach ($file_keys as $key) {
	            $file_ary[$i][$key] = $file_post[$key][$i];
	        }
	    }
	    return $file_ary;
	}
	
	public static function updateMusicJsFile()
	{
		$js = ROOT . DS. 'assets/js/music.js';
		$music = Music::getMusic();
		$begin = "
		var ap1 = new APlayer({
		    element: document.getElementById('musicplayer'),
		    narrow: false,
		    autoplay: false,
		    showlrc: false,
		    mutex: true,
		    theme: '#A21319',
		    music: [ ";

		$endFile =         
		   " ] 
		});
		ap1.init();
		";
		$fBegin = fopen($js, "w+");
		fwrite($fBegin, $begin);
		fclose($fBegin);
		$fForeach = fopen($js, "a+");
		foreach ($music as $item)
		{
			fwrite ($fForeach,
			'{title: ' . '"' . $item->title . '",' .
			'author:' . '"' . $item->author . '",' .
			'url:' . '"' . $item->songUrl . '",' .
			"pic:" . '"' . $item->picUrl . '"},' 
			);
		}
		fwrite ($fForeach,$endFile);
		fclose($fForeach);
	}
	public static function updateSliderCssFile()
	{
		$css = ROOT . DS. 'assets/css/slider.css';
		$banners = Banners::getBannersAssoc();
		$begin = "
.body_slides{
	list-style:none;
	margin:0;
	padding:0;
	z-index:-2; 
	background:#000;}
.body_slides,
.body_slides:after{
    position: absolute;
	width:100%;
	height:100vh;
	top:0px;
	left:0px;}
.body_slides:after { 
    content: '';
	background: transparent url(../img/slider/pattern.png);
}
@-webkit-keyframes anim_slides {
0% {opacity:0;}
6% {opacity:1;}
24% {opacity:1;}
30% {opacity:0;}
100% {opacity:0;}
}
@-moz-keyframes anim_slides {
0% {opacity:0;}
6% {opacity:1;}
24% {opacity:1;}
30% {opacity:0;}
100% {opacity:0;}
}
.body_slides li{
    width:100%;
	height:100%;
	position:absolute;
	top:0;
	left:0;
    background-size:cover;
    background-repeat:none;
	opacity:0;
    -webkit-animation: anim_slides 18s linear infinite 0s;
    -moz-animation: anim_slides 18s linear infinite 0s;
    -o-animation: anim_slides 18s linear infinite 0s;
    -ms-animation: anim_slides 18s linear infinite 0s;
    animation: anim_slides 18s linear infinite 0s;
}
";

		$fBegin = fopen($css, "w+");
		fwrite($fBegin, $begin);
		fclose($fBegin);
		$fForeach = fopen($css, "a+");
		foreach ($banners as $key =>$value)
		{
			$nth = $key +1;
			$delay = $key * 6;
fwrite ($fForeach,
".body_slides li:nth-child(". $nth ."){
	-webkit-animation-delay:". $delay ."s;
	-moz-animation-delay:". $delay ."s;
	background-image: url(/upload/images/banners/" . $value['pic'] . ") 
}
"
);
		}
		fclose($fForeach);
	}
	
}
