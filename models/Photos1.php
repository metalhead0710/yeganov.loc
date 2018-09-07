<?php
class Photos extends Model
{
	public static function getPhotoCats()
	{
		$photocats = R::findAll('photocats', ' ORDER BY sort_order ');
		return $photocats;
	}
	
	public static function photoCount()
	{
		$count = R::count('photos');
		return $count;
	}
	
	public static function getPhotos()
	{
		$photos = R::findAll('photos');
		return $photos;
	}
	
	public static function getPhotosByCatalog($id)
	{
		$photos = R::findAll('photos', 'photocat_id = :id', [ ':id' => $id ]);
		return $photos;
	}
	
	public static function getPhotoCat($id)
	{
			$photocat = R::load('photocats', $id);
		return $photocat;		
	}
	public static function createPhotoCat($name, $pic, $sort_order, $folder)
	{
		$photocat = R::dispense( 'photocats' );
		$photocat->name = $name;
		$photocat->pic = $pic;
		$photocat->sort_order = $sort_order;
		$photocat->folder = $folder;
		$id = R::store($photocat);
		if (isset($id))
			return true;
		else
		return false;		
	}
	public static function updatePhotoCat($id, $name, $pic, $sort_order, $folder)
	{
		$photocat = R::load( 'photocats', $id );
		$photocat->name = $name;
		$photocat->pic = $pic;
		$photocat->sort_order = $sort_order;
		$photocat->folder = $folder;
		$id = R::store($photocat);
		if (isset($id))
			return true;
		else
		return false;
	}
	public static function deletePhotoCat($id)
	{
		$photocat = R::load( 'photocats', $id );
		$res = R::trash( $photocat );
		$res = R::findOne('photocats', 'id = :id', [ ':id' => $id ]);
		if ($res == null)
			return true;
		else
		return false;
		
	}
	public static function addPhoto($pic, $photocatId)
	{
		$photo = R::dispense( 'photos' );
		$photo->pic = $pic;
		$photo->photocatId = $photocatId;
		$id = R::store($photo);
		if (isset($id))
			return true;
		else
		return false;		
	}
	public static function getOnePhoto($id)
	{
		$photo = R::load('photos', $id);
		return $photo;
	}
	public static function deleteOnePhoto($id)
	{
		$photo = R::load( 'photos', $id );
		$res = R::trash( $photo );
		$res = R::findOne('photos', 'id = :id', [ ':id' => $id ]);
		if ($res == null)
			return true;
		else
		return false;
		
	}
}
?>